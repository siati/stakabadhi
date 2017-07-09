<?php

namespace common\activeQueries;

use common\models\Logs;

/**
 * This is the ActiveQuery class for [[\common\models\Logs]].
 *
 * @see \common\models\Logs
 */
class LogsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Logs[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Logs|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @param integer $origin_id document id
     * @return \common\models\Logs ActiveRecord
     */
    public function documentHasAVersion($origin_id) {
        $type = Logs::new_version;
        $status = Logs::success;
        $available = Logs::available;
        
        return $this->where("type='$type' && origin_id='$origin_id' && status='$status' && available='$available'")->one();
    }
    
    /**
     * 
     * @param integer $further_narration filename
     * @return \common\models\Logs ActiveRecord
     */
    public function documentIsAVersion($further_narration) {
        $type = Logs::new_version;
        $status = Logs::success;
        $available = Logs::available;
        
        return $this->where("type='$type' && further_narration='$further_narration' && status='$status' && available='$available'")->one();
    }
    
    /**
     * 
     * @param integer $origin_id document id
     * @return \common\models\Logs ActiveRecord
     */
    public function documentVersions($origin_id) {
        $type = Logs::new_version;
        $status = Logs::success;
        $available = Logs::available;
        
        return $this->where("type='$type' && origin_id='$origin_id' && status='$status' && available='$available'")->orderBy('created_at desc')->all();
    }
    
    /**
     * 
     * @param integer $origin_id document id
     * @param string $since earliest version date desired
     * @param string $till latest version date desired
     * @param boolean $ascDesc true - order by created_at ascending
     * @return \common\models\Logs ActiveRecord
     */
    public function documentVersionsDetweenDates($origin_id, $since, $till, $ascDesc) {
        $type = Logs::new_version;
        $status = Logs::success;
        $available = Logs::available;
        
        return $this->where("type='$type' && origin_id='$origin_id' && created_at >= '$since' && created_at <= '$till' && status='$status' && available='$available'")->orderBy('created_at ' . ($ascDesc ? 'asc' : 'desc'))->all();
    }

}
