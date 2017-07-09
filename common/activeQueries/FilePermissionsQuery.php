<?php

namespace common\activeQueries;

use common\models\FilePermissions;
use common\models\StoreLevels;

/**
 * This is the ActiveQuery class for [[\common\models\FilePermissions]].
 *
 * @see \common\models\FilePermissions
 */
class FilePermissionsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\FilePermissions[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\FilePermissions|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return \common\models\FilePermissions ActiveRecords
     */
    public function allPermissions() {
        return $this->all();
    }

    /**
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @param array $read_users user ids
     * @param array $write_users user ids
     * @param array $deny_users user ids
     * @return \common\models\FilePermissions ActiveRecords
     */
    public function searchDrawers($store_level, $store_id, $read_users, $write_users, $deny_users) {
        $comma = FilePermissions::comma;

        foreach ($read_users as $read_user)
            $read = (empty($read) ? '' : "$read || ") . "(read_rights = '$read_user' || read_rights like '$read_user$comma%' || read_rights like '%$comma$read_user$comma%' || read_rights like '%$comma$read_user')";

        foreach ($write_users as $write_user)
            $write = (empty($write) ? '' : "$write || ") . "(write_rights = '$write_user' || write_rights like '$write_user$comma%' || write_rights like '%$comma$write_user$comma%' || write_rights like '%$comma$write_user')";

        foreach ($deny_users as $deny_user)
            $deny = (empty($deny) ? '' : "$deny || ") . "(deny_rights = '$deny_user' || deny_rights like '$deny_user$comma%' || deny_rights like '%$comma$deny_user$comma%' || deny_rights like '%$comma$deny_user')";

        return $this->where("store_level = '$store_level'" . (empty($store_id) ? '' : " && store_id='$store_id'") . (empty($read) ? '' : " && ($read)") . (empty($write) ? '' : " && ($write)") . (empty($deny) ? '' : " && ($deny)"))->all();
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @param integer $file file id
     * @param integer $level level id
     * @param integer $user user id
     * @param boolean $parentsOnly true - parents only
     * @return \common\models\FilePermissions ActiveRecords
     */
    public function effectiveUserRightToStorage($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder, $file, $level, $user, $parentsOnly) {

        $comma = FilePermissions::comma;

        $read_right = "read_rights = '$user' || read_rights like '$user$comma%' || read_rights like '%$comma$user$comma%' || read_rights like '%$comma$user'";

        $write_right = "write_rights = '$user' || write_rights like '$user$comma%' || write_rights like '%$comma$user$comma%' || write_rights like '%$comma$user'";

        $deny_right = "deny_rights = '$user' || deny_rights like '$user$comma%' || deny_rights like '%$comma$user$comma%' || deny_rights like '%$comma$user'";

        $where = "(store_level='" . ($storeLevel = StoreLevels::stores) . "' && store_id='$store')";

        $where .= $level > ($compartmentLevel = StoreLevels::compartments) || ($level == $compartmentLevel && !$parentsOnly) ? " || (store_level='$compartmentLevel' && store_id='$compartment')" : '';
        $where .= $level > ($subcompartmentLevel = StoreLevels::subcompartments) || ($level == $subcompartmentLevel && !$parentsOnly) ? " || (store_level='$subcompartmentLevel' && store_id='$subcompartment')" : '';
        $where .= $level > ($subsubcompartmentLevel = StoreLevels::subsubcompartments) || ($level == $subsubcompartmentLevel && !$parentsOnly) ? " || (store_level='$subsubcompartmentLevel' && store_id='$subsubcompartment')" : '';
        $where .= $level > ($shelfLevel = StoreLevels::shelves) || ($level == $shelfLevel && !$parentsOnly) ? " || (store_level='$shelfLevel' && store_id='$shelf')" : '';
        $where .= $level > ($drawerLevel = StoreLevels::drawers) || ($level == $drawerLevel && !$parentsOnly) ? " || (store_level='$drawerLevel' && store_id='$drawer')" : '';
        $where .= $level > ($batchLevel = StoreLevels::batches) || ($level == $batchLevel && !$parentsOnly) ? " || (store_level='$batchLevel' && store_id='$batch')" : '';
        $where .= $level > ($folderLevel = StoreLevels::folders) || ($level == $folderLevel && !$parentsOnly) ? " || (store_level='$folderLevel' && store_id='$folder')" : '';
        $where .= $level > ($fileLevel = StoreLevels::files) || ($level == $fileLevel && !$parentsOnly) ? " || (store_level='$fileLevel' && store_id='$file')" : '';

        $table = FilePermissions::tableName();
        
        return FilePermissions::findBySql("select max(if($read_right, $user, 0)) as read_rights, max(if($write_right, $user, 0)) as write_rights, max(if($deny_right, $user, 0)) as deny_rights from $table where (($read_right) || ($write_right) || ($deny_right)) && ($where)")->all();
    }

}
