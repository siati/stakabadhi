<?php

namespace common\activeQueries;

/**
 * This is the ActiveQuery class for [[\common\models\FileTrackingNotes]].
 *
 * @see \common\models\FileTrackingNotes
 */
class FileTrackingNotesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\FileTrackingNotes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\FileTrackingNotes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
