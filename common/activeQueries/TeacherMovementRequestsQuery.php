<?php

namespace common\activeQueries;

/**
 * This is the ActiveQuery class for [[\common\models\TeacherMovementRequests]].
 *
 * @see \common\models\TeacherMovementRequests
 */
class TeacherMovementRequestsQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\TeacherMovementRequests[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\TeacherMovementRequests|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
