<?php

namespace common\activeQueries;

use common\models\Shelves;

/**
 * This is the ActiveQuery class for [[\common\models\Shelves]].
 *
 * @see \common\models\Shelves
 */
class ShelvesQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Shelves[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Shelves|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return \common\models\Shelves ActiveRecord
     */
    public function allShelves() {
        return $this->orderBy('name asc')->all();
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @return string where clause
     */
    public static function buildWhere($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust) {
        return (empty($store) ? '' : $where = "store='$store'")
                . (empty($compartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "compartment='$compartment'"))
                . (empty($subcompartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "sub_compartment='$subcompartment'"))
                . (empty($subsubcompartment) ? ('') : (empty($where) ? '' : ' && ')) . (($whereStringAMust && empty($where)) || !empty($subsubcompartment) ? "sub_sub_compartment='$subsubcompartment'" : '');
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return \common\models\Shelves ActiveRecord
     */
    public function searchShelves($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust, $oneOrAll) {
        return $this->where(
                        static::buildWhere($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust)
                )->orderBy('name asc')->$oneOrAll();
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @return \common\models\Shelves ActiveRecord
     */
    public function countShelves($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust) {
        $table = Shelves::tableName();
        
        $where = static::buildWhere($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust);
        
        return Shelves::findBySql("select count(id) as id from $table where $where")->all();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return \common\models\Shelves ActiveRecord
     */
    public function byReferenceNo($reference_no) {
        return $this->where("reference_no='$reference_no'")->one();
    }

}
