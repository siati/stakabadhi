<?php

namespace common\activeQueries;
use common\models\Compartments;

/**
 * This is the ActiveQuery class for [[\common\models\Compartments]].
 *
 * @see \common\models\Compartments
 */
class CompartmentsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Compartments[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Compartments|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return \common\models\Compartments ActiveRecords
     */
    public function allCompartments() {
        return $this->orderBy('name asc')->all();
    }

    /**
     * @param integer $store store id
     * @param boolean $whereStringAMust force where clause
     * @return string where clause
     */
    public static function buildWhere($store, $whereStringAMust) {
        return $whereStringAMust || !empty($store) ? "store='$store'" : '';
    }
    
    /**
     * @param integer $store store id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return \common\models\Compartments ActiveRecords
     */
    public function compartmentsForStore($store, $whereStringAMust, $oneOrAll) {
        return $this->where(static::buildWhere($store, $whereStringAMust))->orderBy('name asc')->$oneOrAll();
    }

    /**
     * @param integer $store store id
     * @param boolean $whereStringAMust force where clause
     * @return \common\models\Compartments ActiveRecord
     */
    public function countCompartments($store, $whereStringAMust) {
        $table = Compartments::tableName();
        
        $where = static::buildWhere($store, $whereStringAMust);
        
        return Compartments::findBySql("select count(id) as id from $table where $where")->all();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return \common\models\Compartments ActiveRecord
     */
    public function byReferenceNo($reference_no) {
        return $this->where("reference_no='$reference_no'")->one();
    }

}
