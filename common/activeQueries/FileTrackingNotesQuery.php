<?php

namespace common\activeQueries;

/**
 * This is the ActiveQuery class for [[\common\models\FileTrackingNotes]].
 *
 * @see \common\models\FileTrackingNotes
 */
class FileTrackingNotesQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\FileTrackingNotes[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\FileTrackingNotes|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * 
     * @return \common\models\FileTrackingNotes ActiveRecords
     */
    public function allNotes() {
        return $this->orderBy('created_at desc')->all();
    }
    
    /**
     * 
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @return \common\models\FileTrackingNotes ActiveRecords
     */
    public function notesForStore($store_level, $store_id) {
        return $this->where("store_level = '$store_level' && store_id = '$store_id'")->orderBy('created_at desc')->all();
    }

}
