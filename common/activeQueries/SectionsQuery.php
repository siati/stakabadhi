<?php

namespace common\activeQueries;

use common\models\Sections;

/**
 * This is the ActiveQuery class for [[\common\models\Sections]].
 *
 * @see \common\models\Sections
 */
class SectionsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Sections[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Sections|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @param string $name section name
     * @return \common\models\Sections ActiveRecord
     */
    public function byName($name) {
        return $this->where("name='$name'")->one();
    }

    /**
     * 
     * @param integer $user user id
     * @return \common\models\Sections ActiveRecords
     */
    public function byAdmin($user) {
        return $this->where("admin_one='$user' || admin_two='$user'")->orderBy('active desc, name asc')->all();
    }

    /**
     * 
     * @param integer $user user id
     * @return \common\models\Sections ActiveRecords
     */
    public function bySubAdmin($user) {
        return $this->where("sub_admin_one='$user' || sub_admin_two='$user'")->orderBy('active desc, name asc')->all();
    }
    
    /**
     * 
     * @param integer $user user id
     * @return \common\models\Sections ActiveRecords
     */
    public function byMembership($user) {
        $delimiter = Sections::users_delimiter;
        return $this->where("other_users like '$user$delimiter%' || other_users like '%$delimiter$user$delimiter%' || other_users like '%$delimiter$user'")->orderBy('active desc, name asc')->all();
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $privilege admin, sub_admin, other_user
     * @param integer $active 1 - active, 0 - not active
     * @param string $oneOrAll one - limit one, all - no limit
     * @return \common\models\Sections ActiveRecords
     */
    public function byUserPrivilegeAndStatus($user, $privilege, $active, $oneOrAll) {
        $delimiter = Sections::users_delimiter;
        
        $where1 = $active == Sections::section_active || $active == Sections::section_not_active ? "active='$active'" : '';
        
        $where2 = $privilege == Sections::make_admin ? ("admin_one='$user' || admin_two='$user'") : ($privilege == Sections::make_admin ? ("sub_admin_one='$user' || sub_admin_two='$user'") :
                ($privilege == Sections::make_other_user ? "other_users like '$user$delimiter%' || other_users like '%$delimiter$user$delimiter%' || other_users like '%$delimiter$user'" : ''));
        
        $where = $where1 . (empty($where2) ? ('') : (empty($where1) ? $where2 : " && ($where2)"));
        
        return $this->where($where)->$oneOrAll();
    }
    
    /**
     * 
     * @param integer $active 1 - active, 0 - not active
     * @return \common\models\Sections ActiveRecords
     */
    public function allSections($active) {
        return $this->where(is_null($active) || $active == '' ? '' : "active='$active'")->orderBy('active desc, name asc')->all();
    }

}
