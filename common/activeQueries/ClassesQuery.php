<?php

namespace common\activeQueries;

use common\models\Classes;

/**
 * This is the ActiveQuery class for [[\common\models\Classes]].
 *
 * @see \common\models\Classes
 */
class ClassesQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Classes[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Classes|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return Classes ActiveRecords
     */
    public function allClasses($active) {
        return $this->where(empty($active) ? '' : "active = '$active'")->orderBy("school asc, level asc, class asc, name asc")->all();
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $stream stream
     * @param symbol $symbol class symbol
     * @param string $name class name
     * @param string $active yes, no
     * @return Classes ActiveRecords
     */
    public function searchClasses($id, $school, $level, $class, $stream, $symbol, $name, $active) {
        return $this->where(
                        (empty($id) ? 'id > 0' : "id != '$id'") .
                        (empty($school) ? '' : " && school = '$school'") .
                        (empty($level) ? '' : " && level = '$level'") .
                        (empty($class) ? '' : " && class = '$class'") .
                        (empty($stream) ? '' : " && stream = '$stream'") .
                        (empty($symbol) ? '' : " && symbol = '$symbol'") .
                        (empty($name) ? '' : " && name like '%$name%'") .
                        (empty($active) ? '' : " && active = '$active'")
                )->orderBy('school asc, level asc, class asc, name asc')->all();
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $attribute column / `$attribute` name
     * @param string $value column / `$attribute` value
     * @return Classes ActiveRecord
     */
    public function distinctAttribute($id, $school, $level, $attribute, $value) {
        return $this->where("id != '$id'" . (empty($school) ? '' : " && school = '$school'") . " && level = '$level' && $attribute = '$value'")->one();
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $active yes, no
     * @return Classes ActiveRecords
     */
    public function distinctSchoolClassesWithoutStreams($school, $level, $active) {
        return $this->where(
                        'id > 0' .
                        (empty($school) ? '' : " && school = '$school'") .
                        (empty($level) ? '' : " && level = '$level'") .
                        (empty($active) ? '' : " && active = '$active'")
                )->groupBy('school, level, class')->orderBy('school asc, level asc, class asc, name asc')->all();
    }

}
