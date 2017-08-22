<?php

namespace common\activeQueries;

use common\models\Subjects;

/**
 * This is the ActiveQuery class for [[\common\models\Subjects]].
 *
 * @see \common\models\Subjects
 */
class SubjectsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Subjects[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Subjects|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return Subjects ActiveRecords
     */
    public function allSubjects($active) {
        return $this->where(empty($active) ? '' : "active = '$active'")->groupBy('subject')->orderBy("school asc, level asc, dept_name asc, class asc, name asc")->all();
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $dept department
     * @param integer $class class
     * @param string $subject subject
     * @param string $active yes, no
     * @return Subjects ActiveRecords
     */
    public function searchSubjects($id, $school, $level, $dept, $class, $subject, $active) {
        return $this->where(
                        (empty($id) ? 'id > 0' : "id != '$id'") .
                        (empty($school) ? '' : " && school = '$school'") .
                        (empty($level) ? '' : " && level = '$level'") .
                        (empty($dept) ? '' : " && dept = '$dept'") .
                        (empty($class) ? '' : " && class = '$class'") .
                        (empty($subject) ? '' : " && subject = '$subject'") .
                        (empty($active) ? '' : " && active = '$active'")
                )->orderBy("school asc, level asc, dept_name asc, class asc, name asc")->all();
    }

}
