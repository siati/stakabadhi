<?php

namespace common\activeQueries;

use common\models\Files;

/**
 * This is the ActiveQuery class for [[\common\models\Files]].
 *
 * @see \common\models\Files
 */
class FilesQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Files[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Files|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return \common\models\Files ActiveRecord
     */
    public function allFiles() {
        return $this->orderBy('name asc')->all();
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return \common\models\Files ActiveRecord
     */
    public function searchFiles($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder, $whereStringAMust, $oneOrAll) {
        return $this->where(
                        (empty($store) ? '' : $where = "store='$store'")
                        . (empty($compartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "compartment='$compartment'"))
                        . (empty($subcompartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "sub_compartment='$subcompartment'"))
                        . (empty($subsubcompartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "sub_sub_compartment='$subsubcompartment'"))
                        . (empty($shelf) ? ('') : $where = ((empty($where) ? '' : ' && ') . "shelf='$shelf'"))
                        . (empty($drawer) ? ('') : $where = ((empty($where) ? '' : ' && ') . "drawer='$drawer'"))
                        . (empty($batch) ? ('') : $where = ((empty($where) ? '' : ' && ') . "batch='$batch'"))
                        . (empty($folder) ? ('') : (empty($where) ? '' : ' && ')) . ($whereStringAMust || !empty($folder) ? "folder='$folder'" : '')
                )->orderBy('name asc')->$oneOrAll();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return \common\models\Files ActiveRecord
     */
    public function byReferenceNo($reference_no) {
        return $this->where("reference_no='$reference_no'")->one();
    }

}
