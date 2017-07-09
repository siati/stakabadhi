<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%documents_permissions}}".
 *
 * @property integer $id
 * @property integer $document
 * @property integer $section
 * @property string $permission
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class DocumentsPermissions extends \yii\db\ActiveRecord {

    const file_deny = StaticMethods::file_deny;
    const file_read = StaticMethods::file_read;
    const file_write = StaticMethods::file_write;
    const file_alter = StaticMethods::file_alter;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%documents_permissions}}';
    }

    public $name, $active, $admin_one, $admin_two, $sub_admin_one, $sub_admin_two, $other_users, $count;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['document', 'section', 'created_by'], 'required'],
            [['document', 'section', 'created_by', 'updated_by'], 'integer'],
            [['permission'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'document' => Yii::t('app', 'Document'),
            'section' => Yii::t('app', 'Section'),
            'permission' => Yii::t('app', 'Permission'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\DocumentsPermissionsQuery the active query used by this AR clas$
     */
    public static function find() {
        return new \common\activeQueries\DocumentsPermissionsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk permission id
     * @return DocumentsPermissions model
     */
    public static function returnPermission($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return DocumentsPermissions model
     */
    public static function byDocumentAndSection($document, $section) {
        return static::find()->byDocumentAndSection($document, $section);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @param string $permission permission
     * @return DocumentsPermissions model
     */
    public static function byDocumentAndSectionAndPermission($document, $section, $permission) {
        return static::find()->byDocumentAndSectionAndPermission($document, $section, $permission);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return DocumentsPermissions model
     */
    public static function sectionCanWriteDocument($document, $section) {
        return static::find()->sectionCanWriteDocument($document, $section);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return DocumentsPermissions model
     */
    public static function sectionCanAlterDocument($document, $section) {
        return static::find()->sectionCanAlterDocument($document, $section);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return DocumentsPermissions model
     */
    public static function sectionDeniedAccessToDocument($document, $section) {
        return static::find()->sectionDeniedAccessToDocument($document, $section);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return DocumentsPermissions model
     */
    public static function sectionCanReadDocument($document, $section) {
        return static::find()->sectionCanReadDocument($document, $section);
    }

    /**
     * 
     * @param integer $document document id
     * @return DocumentsPermissions models
     */
    public static function permissionsForDocument($document) {
        return static::find()->permissionsForDocument($document);
    }

    /**
     * 
     * @param integer $section section id
     * @return DocumentsPermissions models
     */
    public static function permissionsForSection($section) {
        return static::find()->permissionsForSection($section);
    }

    /**
     * 
     * @param integer $section section id
     * @return DocumentsPermissions model
     */
    public static function sectionHasAPermission($section) {
        return is_object(static::find()->sectionHasAPermission($section));
    }

    /**
     * 
     * @param string $permission permission
     * @return DocumentsPermissions models
     */
    public static function documentsWithPermission($permission) {
        return static::find()->documentsWithPermission($permission);
    }

    /**
     * 
     * @param integer $document document id
     * @param string $permission permission
     * @return DocumentsPermissions models
     */
    public static function documentWithPermission($document, $permission) {
        return static::find()->documentWithPermission($document, $permission);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return DocumentsPermissions model
     */
    public static function newPermission($document, $section) {
        $model = new DocumentsPermissions;

        $model->document = $document;
        $model->section = $section;
        $model->permission = self::file_deny;
        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return DocumentsPermissions model
     */
    public static function permissionToLoad($document, $section) {
        return is_object($model = static::byDocumentAndSection($document, $section)) ? $model : static::newPermission($document, $section);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord)
            $this->created_at = StaticMethods::now();
        else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
        }

        $previousModel = static::returnPermission($this->id);

        return ($this->save(false) &&
                (Logs::newLog(Logs::update_group_access_to_folder, "Updated group $this->section access to folder $this->document in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, is_object($previousModel) ? $previousModel->id : '', is_object($previousModel) ? $previousModel->permission : '', $this->id, $this->permission, is_object($previousModel) ? 'Update' : 'Insert', Logs::success) || true)) || !$this->hasErrors();
    }

    /**
     * synchronize with parent's rights
     */
    public function syncRights() {
        if ($this->permission != self::file_deny)
            if (is_object($document = Documents::returnDocument($this->document)) && count($parents = $document->allParentsToDocument()) > 0)
                foreach ($parents as $parent)
                    if (empty($done) && is_object($parentPermission = static::byDocumentAndSection($parent->id, $this->section))) {
                        if ($parentPermission->permission != self::file_alter)
                            if (($this->permission == self::file_read && in_array($parentPermission->permission, [self::file_deny])) || ($this->permission == self::file_write && in_array($parentPermission->permission, [self::file_read, self::file_deny])) || ($this->permission == self::file_alter && in_array($parentPermission->permission, [self::file_write, self::file_read, self::file_deny])))
                                $this->permission = $parentPermission->permission;

                        $done = true;
                    }
    }

    /**
     * synchronize children's rights
     */
    public function documentChildrenRights() {
        if ($this->permission != self::file_alter)
            if (is_object($document = Documents::returnDocument($this->document)))
                foreach ($children = $document->childFolders(null) as $child)
                    if (is_object($permission = static::byDocumentAndSection($child->id, $this->section)))
                        if ($permission->permission != self::file_deny)
                            if (($permission->permission == self::file_read && in_array($this->permission, [self::file_deny])) || ($permission->permission == self::file_write && in_array($this->permission, [self::file_read, self::file_deny])) || ($permission->permission == self::file_alter && in_array($this->permission, [self::file_write, self::file_read, self::file_deny]))) {
                                $permission->permission = $this->permission;
                                $permission->modelSave();
                            }
    }

    /**
     * 
     * @param integer $document document id
     * @param Documents $parents parent documents to `$documents`
     * @return boolean true document permissions created
     */
    public static function defaultDirectoryRights($document, $parents) {
        foreach ($sections = Sections::allSections(null) as $section)
            if (($permission = static::permissionToLoad($document, $section->id)) && $permission->isNewRecord) {

                $done = false;

                foreach ($parents as $parent)
                    if (!$done && is_object($parentPermission = static::byDocumentAndSection($parent->id, $section->id))) {
                        $permission->permission = $parentPermission->permission;
                        $done = true;
                    }

                $permission->modelSave();
            }

        return true;
    }

    /**
     * 
     * @param integer $section section id
     * @return boolean true section permissions created
     */
    public static function defaultSectionRights($section) {
        foreach (Documents::byDocumentType(Documents::FILE_IS_DIRECTORY) as $document) {
            $permission = static::permissionToLoad($document->id, $section);

            $permission->isNewRecord && $permission->modelSave();
        }

        return true;
    }

    /**
     * 
     * @param integer $document document id
     * @return boolean true document permissions dropped
     */
    public static function dropDocumentPermissions($document) {
        foreach (static::permissionsForDocument($document) as $permission)
            $permission->dropPermission("document $permission->document");

        return true;
    }

    /**
     * 
     * @param integer $section section id
     * @return boolean true section permissions dropped
     */
    public static function dropSectionPermissions($section) {
        foreach (static::permissionsForSection($section) as $permission)
            $permission->dropPermission("section $permission->section");

        return true;
    }

    /**
     * @param string $description description for permission delete
     * @return boolean true - permission deleted
     */
    public function dropPermission($description) {
        return $this->delete() && (Logs::newLog(Logs::drop_document_permission, "Deleted document permission $this->id for document $this->document, section $this->section in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $this->permission, null, null, "Deleted along with $description", Logs::success) || true);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @param integer $user user id
     * @param string $oneOrAll one or all
     * @return DocumentsPermissions model
     */
    public static function userHasDocumentPermissionThroughSection($document, $section, $user, $oneOrAll) {
        return static::find()->userHasDocumentPermissionThroughSection($document, $section, $user, $oneOrAll);
    }

    /**
     * 
     * @param null|integer $document document id
     * @param integer $user user id
     * @param string $oneOrAll one or all
     * @return DocumentsPermissions models
     */
    public static function userHasDocumentPermissionThroughAnySection($document, $user, $oneOrAll) {
        return static::find()->userHasDocumentPermissionThroughAnySection($document, $user, $oneOrAll);
    }

    /**
     * 
     * @param null|integer $document document id
     * @param integer $user user id
     * @param string $right right: read, write, alter
     * @return DocumentsPermissions models
     */
    public static function userHasDocumentPermissions($document, $user, $right) {
        return static::find()->userHasDocumentPermissions($document, $user, $right);
    }

    /**
     * 
     * @param integer $user user ids
     * @param string $documentParents list of document parent ids for where clause
     * @return DocumentsPermissions model
     */
    public static function leastParentsPrivileges2($user, $documentParents) {
        foreach (static::find()->leastParentsPrivileges($user, $documentParents) as $permission) {
            $permission->permission = $permission->permission == 4 ? (self::file_alter) : ($permission->permission == 3 ? (self::file_write) : ($permission->permission == 2 ? (self::file_read) : ($permission->permission == 1 ? self::file_deny : '')));
            return $permission;
        }
    }
    
    /**
     * 
     * @param integer $user user id
     * @param integer $document document id
     * @param integer $section section id
     * @param boolean $considerSectionOnly true - consider section only without necessarily analyzing its users
     * @param boolean $mustBeActive true - section must be active
     * @param boolean $maxPrivilege true - max privilege
     * @return string user privilege to document
     */
    public static function desiredUserPrivilegeToDocument($user, $document, $section, $considerSectionOnly, $mustBeActive, $maxPrivilege) {
        $privilege = self::file_deny;
        
        foreach (static::find()->desiredUserPrivilegeToDocument($user, $document, $section, $considerSectionOnly, $mustBeActive, $maxPrivilege) as $permission)
            $privilege = $permission->permission == 4 ? (self::file_alter) : ($permission->permission == 3 ? (self::file_write) : ($permission->permission == 2 ? self::file_read : $privilege));
        
        return $privilege;
    }

    /**
     * 
     * @param integer|Sections $section section id or model
     * @param integer $user user id
     * @param boolean $considerSectionOnly true - consider section only without necessarily analyzing its users
     * @param boolean $mustBeActive true - section must be active
     * @return string user access right to document
     */
    public function userDocumentPermission($section, $user, $considerSectionOnly, $mustBeActive) {

        if ($this->permission != self::file_deny && (is_object($section) || is_object($section = Sections::returnSection($section))) && (!$mustBeActive || $section->active == Sections::section_active)) {

            if ($this->permission == self::file_alter && ($considerSectionOnly || $section->userHasPreAlterRights($user)))
                return self::file_alter;

            if (($this->permission == self::file_alter || $this->permission == self::file_write) && ($considerSectionOnly || $section->userHasPreWriteRights($user)))
                return self::file_write;

            if (($this->permission == self::file_alter || $this->permission == self::file_write || $this->permission == self::file_read) && ($considerSectionOnly || $section->userHasPreReadRights($user)))
                return self::file_read;
        }

        return self::file_deny;
    }

}
