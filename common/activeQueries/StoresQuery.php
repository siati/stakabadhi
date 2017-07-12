<?php

namespace common\activeQueries;
use common\models\Stores;

/**
 * This is the ActiveQuery class for [[\common\models\Stores]].
 *
 * @see \common\models\Stores
 */
class StoresQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Stores[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Stores|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return \common\models\Stores ActiveRecords
     */
    public function allStores() {
        return $this->orderBy('name asc')->all();
    }
    
     public function countStores() {
        $table = Stores::tableName();
        
        return Stores::findBySql("select count(id) as id from $table")->all();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return \common\models\Stores ActiveRecord
     */
    public function byReferenceNo($reference_no) {
        return $this->where("reference_no='$reference_no'")->one();
    }

}
