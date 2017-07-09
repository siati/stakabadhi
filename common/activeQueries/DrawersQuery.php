<?php

namespace common\activeQueries;

use common\models\Drawers;

/**
 * This is the ActiveQuery class for [[\common\models\Drawers]].
 *
 * @see \common\models\Drawers
 */
class DrawersQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Drawers[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Drawers|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return \common\models\Drawers ActiveRecord
     */
    public function allDrawers() {
        return $this->orderBy('name asc')->all();
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param boolean $whereStringAMust force where clause
     * @return \common\models\Drawers ActiveRecord
     */
    public function searchDrawers($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $whereStringAMust) {
        return $this->where(
                        (empty($store) ? '' : $where = "store='$store'")
                        . (empty($compartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "compartment='$compartment'"))
                        . (empty($subcompartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "sub_compartment='$subcompartment'"))
                        . (empty($subsubcompartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "sub_sub_compartment='$subsubcompartment'"))
                        . (empty($shelf) ? ('') : (empty($where) ? '' : ' && ')) . ($whereStringAMust || !empty($shelf) ? "shelf='$shelf'" : '')
                )->orderBy('name asc')->all();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return \common\models\Drawers ActiveRecord
     */
    public function byReferenceNo($reference_no) {
        return $this->where("reference_no='$reference_no'")->one();
    }

}
