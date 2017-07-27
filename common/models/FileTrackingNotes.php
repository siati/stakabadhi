<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%file_tracking_notes}}".
 *
 * @property integer $id
 * @property integer $store_level
 * @property integer $store_id
 * @property string $notes
 * @property integer $created_by
 * @property string $created_at
 */
class FileTrackingNotes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file_tracking_notes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_level', 'store_id', 'notes', 'created_by'], 'required'],
            [['store_level', 'store_id', 'created_by'], 'integer'],
            [['notes'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_level' => Yii::t('app', 'Store Level'),
            'store_id' => Yii::t('app', 'Store ID'),
            'notes' => Yii::t('app', 'Notes'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\FileTrackingNotesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\activeQueries\FileTrackingNotesQuery(get_called_class());
    }
}
