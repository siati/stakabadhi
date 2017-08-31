<?php

namespace common\activeQueries;

use common\models\Teachers;

/**
 * This is the ActiveQuery class for [[\common\models\Teachers]].
 *
 * @see \common\models\Teachers
 */
class TeachersQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Teachers[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Teachers|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @param string $active yes/no
     * @return Teachers ActiveRecords
     */
    public function allTeachers($active) {
        return $this->where(empty($active) ? '' : "active = '$active'")->orderBy('fname asc, mname asc, lname asc')->all();
    }

    /**
     * 
     * @param integer $id_no id no
     * @return Teachers ActiveRecord
     */
    public function byIDNo($id_no) {
        return $this->where("id_no = '$id_no'")->one();
    }

    /**
     * 
     * @param integer $tsc_no tsc no
     * @return Teachers ActiveRecord
     */
    public function byTSCNo($tsc_no) {
        return $this->where("tsc_no = '$tsc_no'")->one();
    }

    /**
     * 
     * @param integer $phone phone no
     * @return Teachers ActiveRecord
     */
    public function byPhone($phone) {
        return $this->where(empty($phone) ? 'id < 0' : "phone = '$phone'")->one();
    }

    /**
     * 
     * @param integer $email email address
     * @return Teachers ActiveRecord
     */
    public function byEmail($email) {
        return $this->where(empty($email) ? 'id < 0' : "email = '$email'")->one();
    }

    /**
     * 
     * @param string $name name of teacher
     * @param string $gender m: male, f: female
     * @param string $subject subject
     * @param string $active yes / no
     * @return Teachers ActiveRecords
     */
    public function searchTeachers($name, $gender, $subject, $active) {
        return $this->where(
                        'id > 0' .
                        (empty($name) ? '' : " && (fname like '$name%' || mname like '$name%' || lnane like = '$name%')") .
                        (empty($gender) ? '' : "gender = '$gender'") .
                        (empty($subject) ? '' : " && (subject_one = '$subject' || subject_two = '$subject')") .
                        (empty($active) ? '' : "active = '$active'")
                )->orderBy('fname asc, mname asc, lname asc')->all();
    }

}
