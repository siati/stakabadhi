<?php

namespace common\activeQueries;

use common\models\SubCompartments;

/**
 * This is the ActiveQuery class for [[\common\models\SubCompartments]].
 *
 * @see \common\models\SubCompartments
 */
class SubCompartmentsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\SubCompartments[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SubCompartments|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return \common\models\SubCompartments ActiveRecord
     */
    public function allSubcompartments() {
        return $this->orderBy('name asc')->all();
    }
    
    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return \common\models\SubCompartments ActiveRecord
     */
    public function searchSubcompartments($store, $compartment, $whereStringAMust, $oneOrAll) {
        return $this->where(
                (empty($store) ? '' : $where = "store='$store'") . (empty($compartment) ? ('') : (empty($where) ? '' : ' && ')) . ($whereStringAMust || !empty($compartment) ? "compartment='$compartment'" : '')
                )->orderBy('name asc')->$oneOrAll();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return \common\models\SubCompartments ActiveRecord
     */
    public function byReferenceNo($reference_no) {
        return $this->where("reference_no='$reference_no'")->one();
    }

}
