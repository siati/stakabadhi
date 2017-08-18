<?php

namespace common\activeQueries;

use common\models\SchemesOfWork;

/**
 * This is the ActiveQuery class for [[\common\models\SchemesOfWork]].
 *
 * @see \common\models\SchemesOfWork
 */
class SchemesOfWorkQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return SchemesOfWork[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SchemesOfWork|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * 
     * @return SchemesOfWork ActiveRecords
     */
    public function allSchemes() {
        return $this->orderBy('year asc, term asc, school asc, class asc, stream asc, subject asc')->all();
    }

    /**
     * 
     * @param integer $id scheme id
     * @param integer $school school id
     * @param integer $year year
     * @param integer $term term
     * @param integer $class class id
     * @param integer $stream stream id
     * @param integer $subject subject id
     * @param string $submitted_by_date date submitted by
     * @param string $received yes or no
     * @return SchemesOfWork ActiveRecords
     */
    public function searchSchemes($id, $school, $year, $term, $class, $stream, $subject, $submitted_by_date, $received) {
        return $this->where((empty($id) ? 'id > 0' : "id != '$id'") .
                        (empty($school) ? '' : " && school = '$school'") .
                        (empty($year) ? '' : " && year = '$year'") .
                        (empty($term) ? '' : " && term = '$term'") .
                        (empty($class) ? '' : " && class = '$class'") .
                        (empty($stream) ? '' : " && stream = '$stream'") .
                        (empty($subject) ? '' : " && subject = '$subject'") .
                        (empty($submitted_by_date) ? '' : " && submitted_at <= '$submitted_by_date 23:59:59'") .
                        (empty($received) ? '' : " && received = '$received'")
                )->orderBy('year asc, term asc, school asc, class asc, stream asc, subject asc')->all();
    }

}
