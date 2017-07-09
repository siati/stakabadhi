<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sections}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 * @property string $description
 * @property integer $admin_one
 * @property integer $admin_two
 * @property integer $sub_admin_one
 * @property integer $sub_admin_two
 * @property string $other_users
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Sections extends \yii\db\ActiveRecord {

    const section_active = '1';
    const section_not_active = '0';
    const users_delimiter = ',';
    const make_admin = 'admin';
    const make_sub_admin = 'sub_admin';
    const make_other_user = 'other_user';
    const add_user = 'add_user';
    const remove_user = 'remove_user';
    const one = 'one';
    const all = 'all';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%sections}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['active', 'admin_one', 'admin_two', 'sub_admin_one', 'sub_admin_two', 'created_by', 'updated_by'], 'integer'],
            [['name', 'created_by'], 'required'],
            [['description', 'other_users'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'min' => 5, 'max' => 30],
            [['description'], 'string', 'min' => 5, 'max' => 200],
            [['name', 'description'], 'notNumerical'],
            ['name', 'capitalizeEachWord'],
            ['description', 'paragraphCase'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name Of Section'),
            'active' => Yii::t('app', 'Active'),
            'description' => Yii::t('app', 'Description Of Section'),
            'admin_one' => Yii::t('app', 'Head Of Section 1'),
            'admin_two' => Yii::t('app', 'Head Of Section 2'),
            'sub_admin_one' => Yii::t('app', 'Assistant Head Of Section 1'),
            'sub_admin_two' => Yii::t('app', 'Assistant Head Of Section 2'),
            'other_users' => Yii::t('app', 'Other Users'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\SectionsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\SectionsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk section id
     * @return Sections model
     */
    public static function returnSection($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param integer $user user id
     * @return Sections models
     */
    public static function byAdmin($user) {
        return static::find()->byAdmin($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return Sections models
     */
    public static function bySubAdmin($user) {
        return static::find()->bySubAdmin($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return Sections models
     */
    public static function byMembership($user) {
        return static::find()->byMembership($user);
    }

    /**
     * 
     * @param integer $active 1 - active, 0 - not active
     * @return Sections models
     */
    public static function allSections($active) {
        return static::find()->allSections($active);
    }

    /**
     * 
     * @param integer $user user id
     * @param string $privilege admin, sub_admin, other_user
     * @param integer $active 1 - active, 0 - not active
     * @param string $oneOrAll one - limit one, all - no limit
     * @return Sections model(s)
     */
    public static function byUserPrivilegeAndStatus($user, $privilege, $active, $oneOrAll) {
        return static::find()->byUserPrivilegeAndStatus($user, $privilege, $active, $oneOrAll);
    }

    /**
     * 
     * @param integer $user user id
     * @return Sections model(s)
     */
    public static function sectionsForUserCurrentDocumentAccess($user) {
        return
                static::byUserPrivilegeAndStatus($user, self::make_admin, self::section_active, self::all) +
                static::byUserPrivilegeAndStatus($user, self::make_sub_admin, self::section_active, self::all) +
                static::byUserPrivilegeAndStatus($user, self::make_other_user, self::section_active, self::all);
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user is admin
     */
    public function userIsAdmin($user) {
        return in_array("$user", ["$this->admin_one", "$this->admin_two"]);
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user is sub admin
     */
    public function userIsSubAdmin($user) {
        return in_array("$user", ["$this->sub_admin_one", "$this->sub_admin_two"]);
    }

    /**
     * 
     * @return array other members of section
     */
    public function sectionMembers() {
        foreach ($members = explode(self::users_delimiter, $this->other_users) as $i => $member)
            if (empty($member))
                unset($members[$i]);

        return $members;
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user is member
     */
    public function userIsMember($user) {
        return in_array("$user", $this->sectionMembers());
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user has alter rights
     */
    public function userHasPreAlterRights($user) {
        return $this->userIsAdmin($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user has write rights
     */
    public function userHasPreWriteRights($user) {
        return $this->userIsSubAdmin($user) || $this->userIsAdmin($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user has read rights
     */
    public function userHasPreReadRights($user) {
        return $this->userIsMember($user) || $this->userIsSubAdmin($user) || $this->userIsAdmin($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user has alter rights
     */
    public function userHasAlterRights($user) {
        return $this->active == self::section_active && $this->userHasPreAlterRights($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user has write rights
     */
    public function userHasWriteRights($user) {
        return $this->active == self::section_active && $this->userHasPreWriteRights($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user has read rights
     */
    public function userHasReadRights($user) {
        return $this->active == self::section_active && $this->userHasPreReadRights($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - user has access to section
     */
    public function userHasAccess($user) {
        return $this->userHasReadRights($user);
    }

    /**
     * 
     * @return boolean true - section has members
     */
    public function sectionHasMembership() {
        return !empty($this->admin_one) || !empty($this->admin_two) || !empty($this->sub_admin_one) || !empty($this->sub_admin_two) || !empty($this->sectionMembers());
    }

    /**
     * 
     * @return boolean true - section has a document permission
     */
    public function sectionHasPermission() {
        return DocumentsPermissions::sectionHasAPermission($this->id);
    }

    /**
     * 
     * @param string $name name of section
     * @return Sections model
     */
    public static function newSection($name) {
        $model = new Sections;

        $model->name = $name;

        $model->active = self::section_active;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id section id
     * @param string $name name of section
     * @return Sections model
     */
    public static function sectionToLoad($id, $name) {
        return is_object($model = static::returnSection($id)) ? $model : static::newSection($name);
    }

    /**
     * 
     * @param string $actionType description of action to do
     * @param Sections $previousModel previous model
     * @param integer $user user id
     * @return boolean true - model saved
     */
    public function logSectionSave($actionType, $previousModel, $user) {
        $desc = $actionType == Logs::create_group ? ("Created new user group $this->name in ") : ($actionType == Logs::update_group ? "Updated user group $this->name in " : ($actionType == Logs::activate_group ? ("Changed active status of user group $this->name to $this->active in ") : ($actionType == Logs::remove_user_from_group ? "Removed user $user from user group $this->name in " : "Updated privileges for user $user in user group $this->name in ")));
        
        $old = $actionType == Logs::create_group || !is_object($previousModel) ? ('') : ($actionType == Logs::update_group || $actionType == Logs::activate_group ? "$previousModel->name,$previousModel->description,$previousModel->active" : "$previousModel->admin_one;$previousModel->admin_two;$previousModel->sub_admin_one;$previousModel->sub_admin_two;$previousModel->other_users");
        
        $new = $actionType == Logs::create_group || $actionType == Logs::update_group || $actionType == Logs::activate_group ? "$this->name,$this->description,$this->active" : "$this->admin_one;$this->admin_two;$this->sub_admin_one;$this->sub_admin_two;$this->other_users";
        
        for ($i = 0; $i < 10; $i++) {
            $old = str_replace (',,', ',', $old);
            $old = str_replace (';;', ';', $old);
            $new = str_replace (',,', ',', $new);
            $new = str_replace (';;', ';', $new);
        }
        
        substr($old, 0, 1) == ',' || substr($old, 0, 1) == ';' ? $old = substr($old, 1) : '';
        
        substr($new, 0, 1) == ',' || substr($new, 0, 1) == ';' ? $new = substr($new, 1) : '';
        
        substr($old, strlen($old) - 1) == ',' || substr($old, strlen($old) - 1) == ';' ? $old = substr($old, 0, strlen($old) - 1) : '';
        
        substr($new, strlen($new) - 1) == ',' || substr($new, strlen($new) - 1) == ';' ? $new = substr($new, 0, strlen($new) - 1) : '';
        
        empty($old) ? $old = null : '';
        
        empty($new) ? $new = null : '';
        
        return Logs::newLog($actionType, $desc . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $actionType == Logs::create_group || !is_object($previousModel) ? '' : $this->id, $old, $this->id, $new, null, Logs::success) || true;
    }

    /**
     * 
     * @param string $actionType Description
     * @param integer $user user id
     * @return boolean true - model saved
     */
    public function modelSave($actionType, $user) {
        if ($this->isNewRecord){
            $this->created_at = StaticMethods::now();
            $isNew = true;
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
        }

        $this->nullMembership();

        $previousModel = static::returnSection($this->id);

        return ($this->save() && (empty($isNew) || DocumentsPermissions::defaultSectionRights($this->id)) && $this->logSectionSave($actionType, $previousModel, $user)) || !$this->hasErrors();
    }

    /**
     * empty entries defaulted to `null`
     */
    public function nullMembership() {
        empty($this->admin_one) ? $this->admin_one = null : '';
        empty($this->admin_two) ? $this->admin_two = null : '';
        empty($this->sub_admin_one) ? $this->sub_admin_one = null : '';
        empty($this->sub_admin_two) ? $this->sub_admin_two = null : '';
        empty($this->other_users) ? $this->other_users = null : '';
    }

    /**
     * 
     * @return boolean true - section deleted
     */
    public function sectionDrop() {
        return !$this->sectionHasMembership() && !$this->sectionHasPermission() && $this->delete() && DocumentsPermissions::dropSectionPermissions($this->id) &&
                (Logs::newLog(Logs::delete_group, "Deleted user group $this->name from " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, "$this->name, $this->description, $this->active", null, null, null, Logs::success) || true);
    }

    /**
     * 
     * @param integer $user user id
     * @param string $privilege implied privilege make_admin, make_sub_admin, make_other_user
     * @return boolean true - user privileges updated
     */
    public function manageUserPrivileges($user, $privilege) {

        $privilege === self::remove_user ? $this->removeUserFromSection($user) : $this->assignUserPrivilege($user, $privilege);

        return $this->modelSave($privilege === self::remove_user ? Logs::remove_user_from_group : Logs::give_user_group_privilege, $user);
    }

    /**
     * 
     * @param integer $user user id
     * @param string $privilege implied privilege make_admin, make_sub_admin, make_other_user
     */
    public function assignUserPrivilege($user, $privilege) {
        if (!empty($user))
            if ($privilege === self::make_admin && (empty($this->admin_one) || empty($this->admin_two) || $user == $this->admin_one || $user == $this->admin_two)) {
                if (empty($this->admin_one) || empty($this->admin_two)) {
                    empty($this->admin_one) && $this->admin_two != $user ? ($this->admin_one = $user) : (empty($this->admin_two) && $this->admin_one != $user ? $this->admin_two = $user : '');
                    $this->distinctAdmins();
                }
            } else
            if ($privilege !== self::make_other_user && (empty($this->sub_admin_one) || empty($this->sub_admin_two) || $user == $this->sub_admin_one || $user == $this->sub_admin_two)) {
                if (empty($this->sub_admin_one) || empty($this->sub_admin_two)) {
                    empty($this->sub_admin_one) && $this->sub_admin_two != $user ? ($this->sub_admin_one = $user) : (empty($this->sub_admin_two) && $this->sub_admin_one != $user ? $this->sub_admin_two = $user : '');
                    $this->distinctSubAdmins();
                }
            } else {
                $this->addOtherUser($user);
                $this->distinctMembers();
            }
    }

    /**
     * remove user from group
     * 
     * @param integer $user user id
     */
    public function removeUserFromSection($user) {
        foreach (['sub_admin_one', 'sub_admin_two'] as $attribute)
            if ($this->$attribute == $user)
                $this->$attribute = null;

        foreach (['admin_one', 'admin_two'] as $attribute)
            if ($this->$attribute == $user)
                $this->$attribute = null;

        $this->removeOtherUser($user);

        Documents::unlockFilesLockedByUser($user);
    }

    /**
     * admin must not occur as sub-admin or member
     */
    public function distinctAdmins() {
        foreach (['admin_one', 'admin_two'] as $attribute) {
            foreach (['sub_admin_one', 'sub_admin_two'] as $attributeCopy)
                if ($this->$attributeCopy == $this->$attribute)
                    $this->$attributeCopy = null;

            $this->removeOtherUser($this->$attribute);
        }
    }

    /**
     * sub-admin must not occur as admin or member
     */
    public function distinctSubAdmins() {
        foreach (['sub_admin_one', 'sub_admin_two'] as $attribute) {
            foreach (['admin_one', 'admin_two'] as $attributeCopy)
                if ($this->$attributeCopy == $this->$attribute)
                    $this->$attributeCopy = null;

            $this->removeOtherUser($this->$attribute);
        }
    }

    /**
     * member must not occur as admin or sub-admin
     */
    public function distinctMembers() {
        foreach ($this->sectionMembers() as $member) {
            foreach (['sub_admin_one', 'sub_admin_two'] as $attribute)
                if ($this->$attribute == $member)
                    $this->$attribute = null;

            foreach (['admin_one', 'admin_two'] as $attribute)
                if ($this->$attribute == $member)
                    $this->$attribute = null;
        }
    }

    /**
     * 
     * @param integer $user user id
     * @return string section members, with `$user'
     */
    public function addOtherUser($user) {
        if (!empty($user) && !in_array("$user", $members = $this->sectionMembers()))
            array_push($members, "$user");

        $this->other_users = isset($members) ? implode(static::users_delimiter, $members) : '';
    }

    /**
     * 
     * @param integer $user user id
     * @return string section members, without `$user'
     */
    public function removeOtherUser($user) {
        if (in_array("$user", $members = $this->sectionMembers()))
            unset($members[array_search("$user", $members)]);

        $this->addOtherUser(null);
    }

    /**
     * order section admins
     */
    public function orderSectionAdmins() {
        empty($this->admin_one) && !empty($this->admin_two) ? $this->admin_one = $this->admin_two : '';
        $this->admin_two == $this->admin_one ? $this->admin_two = null : '';
        empty($this->admin_one) ? $this->admin_one = null : '';
        empty($this->admin_two) ? $this->admin_two = null : '';
    }

    /**
     * order section sub admins
     */
    public function orderSectionSubAdmins() {
        empty($this->sub_admin_one) && !empty($this->sub_admin_two) ? $this->sub_admin_one = $this->sub_admin_two : '';
        $this->sub_admin_two == $this->sub_admin_one ? $this->sub_admin_two = null : '';
        empty($this->sub_admin_one) ? $this->sub_admin_one = null : '';
        empty($this->sub_admin_two) ? $this->sub_admin_two = null : '';
    }

    /**
     * 
     * @param integer $user user id
     * @return string corresponding css class by which to easily identify user rights in section
     */
    public function userSectionClientClass($user) {
        return $this->userHasPreAlterRights($user) ? (self::make_admin) : ($this->userHasPreWriteRights($user) ? (self::make_sub_admin) : ($this->userHasPreReadRights($user) ? self::make_other_user : self::remove_user));
    }

}
