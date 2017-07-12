<?php

namespace common\activeQueries;

use common\models\Folders;

/**
 * This is the ActiveQuery class for [[\common\models\Folders]].
 *
 * @see \common\models\Folders
 */
class FoldersQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Folders[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Folders|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return \common\models\Folders ActiveRecord
     */
    public function allFolders() {
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
     * @param boolean $whereStringAMust force where clause
     * @return string where clause
     */
    public static function buildWhere($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust) {
        return (empty($store) ? '' : $where = "store='$store'")
                . (empty($compartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "compartment='$compartment'"))
                . (empty($subcompartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "sub_compartment='$subcompartment'"))
                . (empty($subsubcompartment) ? ('') : $where = ((empty($where) ? '' : ' && ') . "sub_sub_compartment='$subsubcompartment'"))
                . (empty($shelf) ? ('') : $where = ((empty($where) ? '' : ' && ') . "shelf='$shelf'"))
                . (empty($drawer) ? ('') : $where = ((empty($where) ? '' : ' && ') . "drawer='$drawer'"))
                . (empty($batch) ? ('') : (empty($where) ? '' : ' && ')) . (($whereStringAMust && empty($where)) || !empty($batch) ? "batch='$batch'" : '');
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return \common\models\Folders ActiveRecord
     */
    public function searchFolders($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust, $oneOrAll) {
        return $this->where(
                        static::buildWhere($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust)
                )->orderBy('name asc')->$oneOrAll();
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param boolean $whereStringAMust force where clause
     * @return \common\models\Folders ActiveRecord
     */
    public function countFolders($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust) {
        $table = Folders::tableName();
        
        $where = static::buildWhere($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust);
        
        return Folders::findBySql("select count(id) as id from $table where $where")->all();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return \common\models\Folders ActiveRecord
     */
    public function byReferenceNo($reference_no) {
        return $this->where("reference_no='$reference_no'")->one();
    }

}
