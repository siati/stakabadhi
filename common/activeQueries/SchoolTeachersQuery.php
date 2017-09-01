<?php

namespace common\activeQueries;

use common\models\SchoolTeachers;

/**
 * This is the ActiveQuery class for [[\common\models\SchoolTeachers]].
 *
 * @see \common\models\SchoolTeachers
 */
class SchoolTeachersQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\SchoolTeachers[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SchoolTeachers|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @param boolean $current true - current
     * @param string $since yyyy-mm-dd
     * @param string $till yyyy-mm-dd
     * @return SchoolTeachers ActiveRecords
     */
    public function allTeachers($current, $since, $till) {
        return $this->where(
                        'id > 0' .
                        ($current ? (" && since <= current_timestamp && (till >= current_timestamp || till = '' || till is null)") : (
                        (empty($since) ? '' : " && since >= '$since'") .
                        (empty($till) ? '' : " && till <= '$till'")
                        ))
                )->orderBy('fname asc, mname asc, lname asc')->all();
    }

    /**
     * 
     * @param integer $id_no id no
     * @return SchoolTeachers ActiveRecord
     */
    public function byIDNo($id_no) {
        return $this->where("id_no = '$id_no'")->one();
    }

    /**
     * 
     * @param integer $tsc_no tsc no
     * @return SchoolTeachers ActiveRecord
     */
    public function byTSCNo($tsc_no) {
        return $this->where("tsc_no = '$tsc_no'")->one();
    }

    /**
     * 
     * @param integer $phone phone no
     * @return SchoolTeachers ActiveRecord
     */
    public function byPhone($phone) {
        return $this->where(empty($phone) ? 'id < 0' : "phone = '$phone'")->one();
    }

    /**
     * 
     * @param integer $email email address
     * @return SchoolTeachers ActiveRecord
     */
    public function byEmail($email) {
        return $this->where(empty($email) ? 'id < 0' : "email = '$email'")->one();
    }

    /**
     * 
     * @param integer $id_no id no of teacher
     * @param integer $tsc_no tsc no of teacher
     * @param string $name name of teacher
     * @param string $gender m: male, f: female
     * @param string $subject subject
     * @param boolean $current true - current posting
     * @param string $since1 yyyy-mm-dd
     * @param string $since2 yyyy-mm-dd
     * @param string $till1 yyyy-mm-dd
     * @param string $till2 yyyy-mm-dd
     * @return SchoolTeachers ActiveRecords
     */
    public function searchTeachers($id_no, $tsc_no, $name, $gender, $subject, $current, $since1, $since2, $till1, $till2) {
        return $this->where(
                        'id > 0' .
                        (empty($id_no) && empty($tsc_no) ? ('') : (empty($tsc_no) ? (" && id_no = '$id_no'") : (empty($id_no) ? " && tsc_no = '$tsc_no'" : " && id_no = '$id_no' && tsc_no = '$tsc_no'"))) .
                        (empty($name) ? '' : " && (fname like '$name%' || mname like '$name%' || lnane like = '$name%')") .
                        (empty($gender) ? '' : "gender = '$gender'") .
                        (empty($subject) ? '' : " && (subject_one = '$subject' || subject_two = '$subject')") .
                        ($current ?
                            (" && since <= current_timestamp && (till >= current_timestamp || till = '' || till is null)") :
                            (
                                (empty($since1) ? '' : " && since >= '$since1'") .
                                (empty($since2) ? '' : " && since <= '$since2'") .
                                (empty($till1) ? '' : " && (till >= '$till1' || till = '' || till is null)") .
                                (empty($till2) ? '' : " && till <= '$till2'")
                            )
                        )
                )->orderBy('fname asc, mname asc, lname asc')->all();
    }

}
