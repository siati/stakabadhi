<?php

namespace common\activeQueries;

use common\models\SubSubCompartments;

/**
 * This is the ActiveQuery class for [[\common\models\SubSubCompartments]].
 *
 * @see \common\models\SubSubCompartments
 */
class SubSubCompartmentsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\SubSubCompartments[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SubSubCompartments|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return \common\models\SubSubCompartments ActiveRecord
     */
    public function allSubSubcompartments() {
        return $this->orderBy('name asc')->all();
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @return string where clause
     */
    public static function buildWhere($store, $compartment, $subcompartment, $whereStringAMust) {
        return (empty($store) ? '' : $where = "store='$store'")
                . (empty($compartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "compartment='$compartment'"))
                . (empty($subcompartment) ? ('') : (empty($where) ? '' : ' && ')) . (($whereStringAMust && empty($where)) || !empty($subcompartment) ? "sub_compartment='$subcompartment'" : '');
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return \common\models\SubSubCompartments ActiveRecord
     */
    public function searchSubsubcompartments($store, $compartment, $subcompartment, $whereStringAMust, $oneOrAll) {
        return $this->where(
                        static::buildWhere($store, $compartment, $subcompartment, $whereStringAMust)
                )->orderBy('name asc')->$oneOrAll();
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @return \common\models\SubSubCompartments ActiveRecord
     */
    public function countSubsubcompartments($store, $compartment, $subcompartment,$whereStringAMust) {
        $table = SubSubCompartments::tableName();
        
        $where = static::buildWhere($store, $compartment, $subcompartment, $whereStringAMust);
        
        return SubSubCompartments::findBySql("select count(id) as id from $table where $where")->all();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return \common\models\SubSubCompartments ActiveRecord
     */
    public function byReferenceNo($reference_no) {
        return $this->where("reference_no='$reference_no'")->one();
    }

}
