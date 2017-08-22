<?php

namespace common\activeQueries;
use common\models\AuthKey;

/**
 * This is the ActiveQuery class for [[\common\models\AuthKey]].
 *
 * @see \common\models\AuthKey
 */
class AuthKeyQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\AuthKey[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\AuthKey|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return AuthKey ActiveRecord
     */
    public function loadKey() {
        return $this->one();
    }

}
