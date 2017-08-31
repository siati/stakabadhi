<?php

namespace common\activeQueries;

use common\models\TeacherMovements;

/**
 * This is the ActiveQuery class for [[\common\models\TeacherMovements]].
 *
 * @see \common\models\TeacherMovements
 */
class TeacherMovementsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\TeacherMovements[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\TeacherMovements|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return TeacherMovements ActiveRecords
     */
    public function allMovements() {
        return $this->orderBy('teacher asc, since asc')->all();
    }

    /**
     * 
     * @param integer $teacher teacher id
     * @param integer $school school id
     * @param boolean $current true - current posting
     * @param string $since1 yyyy-mm-dd
     * @param string $since2 yyyy-mm-dd
     * @param string $till1 yyyy-mm-dd
     * @param string $till2 yyyy-mm-dd
     * @return TeacherMovements ActiveRecords
     */
    public function searchMovements($teacher, $school, $current, $since1, $since2, $till1, $till2) {
        return $this->where(
                        'id > 0' .
                        (empty($teacher) ? '' : " && teacher = '$teacher'") .
                        (empty($school) ? '' : " && school = '$school'") .
                        (
                            $current ? (" && since <= current_date && (till >= current_date || till = '' || till is null)") :
                            (
                                (empty($since1) ? '' : " && since >= '$since1'") .
                                (empty($since2) ? '' : " && since <= '$since2'") .
                                (empty($till1) ? '' : " && (9till >= '$till1' || till = '' || till is null)") .
                                (empty($till2) ? '' : " && till <= '$till2'")
                            )
                        )
                )->orderBy($current ? 'school asc, since asc' : 'teacher asc, since asc')->all();
    }

}
