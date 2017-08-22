<?php

namespace common\activeQueries;

use common\models\SchoolRegistrations;

/**
 * This is the ActiveQuery class for [[\common\models\SchoolRegistrations]].
 *
 * @see \common\models\SchoolRegistrations
 */
class SchoolRegistrationsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\SchoolRegistrations[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SchoolRegistrations|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @param string $active yes / no
     * @return SchoolRegistrations ActiveRecords
     */
    public function allSchools($active) {
        return $this->where(empty($active) ? '' : "active = '$active'")->orderBy("name asc")->all();
    }

    /**
     * 
     * @param string $level level of school - primary / secondary etc
     * @param integer $county county id
     * @param integer $constituency constituency id
     * @param integer $ward ward id
     * @param string $active yes / no
     * @return SchoolRegistrations ActiveRecords
     */
    public function searchSchools($level, $county, $constituency, $ward, $active) {
        return $this->where(
                        'id > 0' .
                        (empty($level) ? '' : " && level = '$level'") .
                        (empty($county) ? '' : " && county = '$county'") .
                        (empty($constituency) ? '' : " && constituency = '$constituency'") .
                        (empty($ward) ? '' : " && ward = '$ward'") .
                        (empty($active) ? '' : " && active = '$active'")
                )->orderBy("name asc")->all();
    }
    
    /**
     * 
     * @param string $code school code
     * @return SchoolRegistrations ActiveRecord
     */
    public function byCode($code) {
        return $this->where("code = '$code'")->one();
    }
    
    /**
     * 
     * @param string $phone school phone
     * @return SchoolRegistrations ActiveRecord
     */
    public function byPhone($phone) {
        return $this->where("phone = '$phone'")->one();
    }
    
    /**
     * 
     * @param string $email school email
     * @return SchoolRegistrations ActiveRecord
     */
    public function byEmail($email) {
        return $this->where("email = '$email'")->one();
    }
    
    /**
     * 
     * @param string $auth_key school auth key
     * @return SchoolRegistrations ActiveRecord
     */
    public function byAuthKey($auth_key) {
        return $this->where("auth_key = '$auth_key'")->one();
    }

}
