<?php

namespace common\activeQueries;

use common\models\DocumentsPermissions;
use common\models\Sections;

/**
 * This is the ActiveQuery class for [[\common\models\DocumentsPermissions]].
 *
 * @see \common\models\DocumentsPermissions
 */
class DocumentsPermissionsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\DocumentsPermissions[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\DocumentsPermissions|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function byDocumentAndSection($document, $section) {
        return $this->where("document='$document' && section='$section'")->one();
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @param string $permission permission
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function byDocumentAndSectionAndPermission($document, $section, $permission) {
        return $this->where("document='$document' && section='$section' && permission='$permission'")->one();
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function sectionCanReadDocument($document, $section) {
        $read = DocumentsPermissions::file_read;
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        return $this->where("document='$document' && section='$section' && permission in ('$read', '$write', '$alter')")->one();
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function sectionCanWriteDocument($document, $section) {
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        return $this->where("document='$document' && section='$section' && permission in ('$write', '$alter')")->one();
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function sectionCanAlterDocument($document, $section) {
        return $this->byDocumentAndSectionAndPermission($document, $section, DocumentsPermissions::file_alter);
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function sectionDeniedAccessToDocument($document, $section) {
        $read = DocumentsPermissions::file_read;
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        return $this->where("document='$document' && section='$section' && permission not in ('$read', '$write', '$alter')")->one();
    }

    /**
     * 
     * @param integer $document document id
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function permissionsForDocument($document) {
        return $this->where("document='$document'")->all();
    }

    /**
     * 
     * @param integer $section section id
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function permissionsForSection($section) {
        return $this->where("section='$section'")->all();
    }

    /**
     * 
     * @param integer $section section id
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function sectionHasAPermission($section) {
        return $this->where("section='$section'")->one();
    }

    /**
     * 
     * @param string $permission permission
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function documentsWithPermission($permission) {
        return $this->where("permission='$permission'")->all();
    }

    /**
     * 
     * @param integer $document document id
     * @param string $permission permission
     * @return \common\models\DocumentsPermissions ActiveRecords
     */
    public function documentWithPermission($document, $permission) {
        $read = DocumentsPermissions::file_read;
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        if ($permission == $alter || $permission == $write || $permission == $read)
            $where = "permission='$alter'";

        if ($permission == $write || $permission == $read)
            $where = (empty($where) ? '' : "$where || ") . "permission='$write'";

        if ($permission == $read)
            $where = (empty($where) ? '' : "$where || ") . "permission='$read'";

        return $this->where("document='$document' && ($where)")->all();
    }

    /**
     * 
     * @param integer $document document id
     * @param integer $section section id
     * @param integer $user user id
     * @param string $oneOrAll one or all
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function userHasDocumentPermissionThroughSection($document, $section, $user, $oneOrAll) {
        $read = DocumentsPermissions::file_read;
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        $t = DocumentsPermissions::tableName();

        $s = Sections::tableName();

        $delimiter = Sections::users_delimiter;

        return
                        $this
                        ->select('t.`id`, t.`document`, t.`section`, t.`permission`, s.`name`, s.`active`, s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`, s.`other_users`')
                        ->from("$t t")->leftJoin("$s s", 't.section = s.id')
                        ->where((empty($document) || is_numeric($document) ? "t.`document` = '$document'" : "t.`document` in ($document)") . " && t.`section` = '$section' && ((t.`permission` = '$alter' && '$user' in (s.`admin_one`, s.`admin_two`)) || (t.`permission` = '$write' && '$user' in (s.`sub_admin_one`, s.`sub_admin_two`)) || (t.`permission` = '$read' && (s.`other_users` like '$user$delimiter%' || s.`other_users` like '%$delimiter$user$delimiter%' || s.`other_users` like '%$delimiter$user')) || ((s.`admin_one` = '' || s.`admin_two` is null) && (s.`sub_admin_one` = '' || s.`sub_admin_two` is null) && (s.`other_users` = '' || s.`other_users` is null)))")
                        ->$oneOrAll();
    }

    /**
     * 
     * @param null|integer $document document id
     * @param integer $user user id
     * @param string $oneOrAll one or all
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function userHasDocumentPermissionThroughAnySection($document, $user, $oneOrAll) {
        $read = DocumentsPermissions::file_read;
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        $t = DocumentsPermissions::tableName();

        $s = Sections::tableName();

        $delimiter = Sections::users_delimiter;

        $doc = empty($document) ? ('') : (is_numeric($document) ? "t.`document` = '$document' && " : "t.`document` in ($document) && ");

        return
                        $this
                        ->select('t.`id`, t.`document`, t.`section`, t.`permission`, s.`name`, s.`active`, s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`, s.`other_users`')
                        ->from("$t t")->leftJoin("$s s", 't.section = s.id')
                        ->where("$doc((t.`permission` = '$alter' && '$user' in (s.`admin_one`, s.`admin_two`)) || (t.`permission` = '$write' && '$user' in (s.`sub_admin_one`, s.`sub_admin_two`)) || (t.`permission` = '$read' && (s.`other_users` like '$user$delimiter%' || s.`other_users` like '%$delimiter$user$delimiter%' || s.`other_users` like '%$delimiter$user')) || ((s.`admin_one` = '' || s.`admin_two` is null) && (s.`sub_admin_one` = '' || s.`sub_admin_two` is null) && (s.`other_users` = '' || s.`other_users` is null)))")
                        ->$oneOrAll();
    }

    /**
     * 
     * @param null|integer $document document id
     * @param integer $user user id
     * @param string $right permission
     * @return \common\models\DocumentsPermissions ActiveRecord
     */
    public function userHasDocumentPermissions($document, $user, $right) {
        $delimiter = Sections::users_delimiter;

        $whereDoc = "t.`permission` = '$right'" . (empty($document) ? '' : " && t.`document` = '$document'");

        if ($right == ($write = DocumentsPermissions::file_alter))
            $wherePerm = "(t.`permission` = '$right' && '$user' in (s.`admin_one`, s.`admin_two`))";
        else
        if ($right == ($read = DocumentsPermissions::file_write))
            $wherePerm = "(t.`permission` = '$write' && '$user' in (s.`admin_one`, s.`admin_two`)) || (t.`permission` = '$right' && '$user' in (s.`sub_admin_one`, s.`sub_admin_two`))";
        else
        if ($right == DocumentsPermissions::file_read)
            $wherePerm = "(t.`permission` = '$write' && '$user' in (s.`admin_one`, s.`admin_two`)) || (t.`permission` = '$read' && '$user' in (s.`sub_admin_one`, s.`sub_admin_two`)) || (t.`permission` = '$right' && (s.`other_users` like '$user$delimiter%' || s.`other_users` like '%$delimiter$user$delimiter%' || s.`other_users` like '%$delimiter$user')) || ((s.`admin_one` = '' || s.`admin_two` is null) && (s.`sub_admin_one` = '' || s.`sub_admin_two` is null) && (s.`other_users` = '' || s.`other_users` is null))";

        if (empty($whereDoc) && (empty($wherePerm) || empty($user)))
            return [];

        $where = $whereDoc . (empty($wherePerm) ? ('') : (empty($whereDoc) ? $wherePerm : " && ($wherePerm)"));

        $t = DocumentsPermissions::tableName();

        $s = Sections::tableName();

        return $this->select('t.`id`, t.`document`, t.`section`, t.`permission`, s.`name`, s.`active`, s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`, s.`other_users`')->from("$t t")->leftJoin("$s s", 't.section = s.id')->where("$where")->all();
    }

    /**
     * 
     * @param integer $user user ids
     * @param string $documentParents list of document parent ids for where clause
     * @return \common\models\DocumentsPermissions ActiveRecords
     */
    public function leastParentsPrivileges($user, $documentParents) {
        if (empty($documentParents))
            return [];

        $deny = DocumentsPermissions::file_deny;
        $read = DocumentsPermissions::file_read;
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        $delimiter = Sections::users_delimiter;

        $t = DocumentsPermissions::tableName();

        $s = Sections::tableName();

        $is_alter = "t.`permission` = '$alter' && '$user' in (s.`admin_one`, s.`admin_two`)";

        $is_write = "t.`permission` = '$write' && '$user' in (s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`)";

        $either = "('$user' in (s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`) || s.`other_users` like '$user$delimiter%' || s.`other_users` like '%$delimiter$user$delimiter%' || s.`other_users` like '%$delimiter$user')";

        $is_read = "t.`permission` = '$read' && $either";

        return
                DocumentsPermissions::findBySql("
                    select min( if($is_alter, 4, if($is_write, 3, if($is_read, 2, 1))) ) as `permission`, count(distinct t.`id`) as `count`
                        
                    from $t t left join $s s on t.section = s.id
                        
                    where t.`document` in ($documentParents) && ( ($is_alter) || ($is_write) || ($is_read) || (t.`permission` = '$deny' && $either) )
                ")->all();
    }

    /**
     * 
     * @param integer $user user ids
     * @param integer $document document id
     * @param integer $section section id
     * @param boolean $considerSectionOnly true - consider section only without necessarily analyzing its users
     * @param boolean $mustBeActive true - section must be active
     * @param boolean $maxPrivilege true - max privilege
     * @return \common\models\DocumentsPermissions ActiveRecords
     */
    public function desiredUserPrivilegeToDocument($user, $document, $section, $considerSectionOnly, $mustBeActive, $maxPrivilege) {
        $read = DocumentsPermissions::file_read;
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        $delimiter = Sections::users_delimiter;

        $t = DocumentsPermissions::tableName();

        $s = Sections::tableName();

        $active = $mustBeActive ? (" && s.active = '" . Sections::section_active . "'") : '';

        $is_alter = "t.`permission` = '$alter'$active" . ($considerSectionOnly ? '' : " && '$user' in (s.`admin_one`, s.`admin_two`)");

        $is_write = "t.`permission` = '$write'$active" . ($considerSectionOnly ? '' : " && '$user' in (s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`)");

        $is_read = "t.`permission` = '$read'$active" . ($considerSectionOnly ? '' : " && ('$user' in (s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`) || s.`other_users` like '$user$delimiter%' || s.`other_users` like '%$delimiter$user$delimiter%' || s.`other_users` like '%$delimiter$user')");

        $minOrMax = $maxPrivilege ? 'max' : 'min';

        $where = "t.`document` = '$document'" . (empty($section) ? '' : " && t.section = '$section'") . " && ( ($is_alter) || ($is_write) || ($is_read) )";

        return DocumentsPermissions::findBySql("
                    select $minOrMax( if($is_alter, 4, if($is_write, 3, if($is_read, 2, 1))) ) as `permission`, count(distinct t.`id`) as `count`
                        
                    from $t t left join $s s on t.section = s.id
                        
                    where $where limit 1
                ")->all();
    }

    /**
     * 
     * @param integer $user user ids
     * @param string $documentChildren list of document child ids for where clause
     * @return \common\models\DocumentsPermissions ActiveRecords
     */
    public function childrenFirstPrivilege($user, $documentChildren) {
        if (empty($documentChildren))
            return [];

        $deny = DocumentsPermissions::file_deny;
        $read = DocumentsPermissions::file_read;
        $write = DocumentsPermissions::file_write;
        $alter = DocumentsPermissions::file_alter;

        $delimiter = Sections::users_delimiter;

        $t = DocumentsPermissions::tableName();

        $s = Sections::tableName();

        $is_alter = "t.`permission` = '$alter' && '$user' in (s.`admin_one`, s.`admin_two`)";

        $is_write = "t.`permission` = '$write' && '$user' in (s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`)";

        $either = "('$user' in (s.`admin_one`, s.`admin_two`, s.`sub_admin_one`, s.`sub_admin_two`) || s.`other_users` like '$user$delimiter%' || s.`other_users` like '%$delimiter$user$delimiter%' || s.`other_users` like '%$delimiter$user')";

        $is_read = "t.`permission` = '$read' && $either";

        return
                        $this
                        ->select("t.`permission`")
                        ->from("$t t")->leftJoin("$s s", 't.section = s.id')
                        ->where("t.`document` in ($documentChildren) && ( ($is_alter) || ($is_write) || ($is_read) || (t.`permission` = '$deny' && ($either)) )")
                        ->orderBy("t.`document` asc")->limit('1')->all();
    }

}
