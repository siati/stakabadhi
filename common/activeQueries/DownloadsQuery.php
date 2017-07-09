<?php

namespace common\activeQueries;

use common\models\Downloads;

/**
 * This is the ActiveQuery class for [[\common\models\Downloads]].
 *
 * @see \common\models\Downloads
 */
class DownloadsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\Downloads[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Downloads|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $filename filename
     * @return Downloads ActiveRecord
     */
    public function byUserAndFilename($user, $filename) {
        return $this->where("user='$user' && filename='$filename'")->one();
    }
    
    /**
     * 
     * @param integer $user user id
     * @return Downloads ActiveRecords
     */
    public function downloadsQuery($user) {        
        return $this->where(empty($user) ? '' : "user='$user'")->all();
    }

}
