<?php

namespace common\activeQueries;

use common\models\StoreLevels;

/**
 * This is the ActiveQuery class for [[\common\models\StoreLevels]].
 *
 * @see \common\models\StoreLevels
 */
class StoreLevelsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\StoreLevels[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\StoreLevels|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return \common\models\StoreLevels ActiveRecords
     */
    public function allLevels() {
        return $this->orderBy('level asc')->all();
    }

    /**
     * 
     * @param integer $level level
     * @return \common\models\StoreLevels ActiveRecord
     */
    public function byLevel($level) {
        return $this->where("level='$level'")->one();
    }

    /**
     * 
     * @param string $name level name
     * @return \common\models\StoreLevels ActiveRecord
     */
    public function byName($name) {
        return $this->where("name='$name'")->one();
    }

    /**
     * 
     * @param string $table level table
     * @return \common\models\StoreLevels ActiveRecord
     */
    public function byAssociatedTable($table) {
        return $this->where("associated_table='$table'")->one();
    }

}
