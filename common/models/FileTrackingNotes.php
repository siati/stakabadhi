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
class FileTrackingNotes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%file_tracking_notes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store_level', 'store_id', 'notes', 'created_by'], 'required'],
            [['store_level', 'store_id', 'created_by'], 'integer'],
            [['notes'], 'notNumerical'],
            [['notes'], 'string', 'min' => 15],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
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
    public static function find() {
        return new \common\activeQueries\FileTrackingNotesQuery(get_called_class());
    }
    
    /**
     * 
     * @param integer $pk note id
     * @return FileTrackingNotes model
     */
    public static function returnNote($pk) {
        return static::findByPk($pk);
    }
    
    /**
     * 
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @return FileTrackingNotes notes
     */
    public static function notesForStore($store_level, $store_id) {
        return static::find()->notesForStore($store_level, $store_id);
    }
    
    /**
     * 
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @return FileTrackingNotes notes
     */
    public static function newNote($store_level, $store_id) {
        $model = new FileTrackingNotes;
        
        $model->store_level = $store_level;
        $model->store_id = $store_id;
        $model->created_by = Yii::$app->user->identity->id;
        
        return $model;
    }
    
    /**
     * 
     * @param integer $id note id
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @return FileTrackingNotes notes
     */
    public static function noteToLoad($id, $store_level, $store_id) {
        return is_object($model = static::returnNote($id)) ? $model : static::newNote($store_level, $store_id);
    }
    
    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        $this->isNewRecord ? $this->created_at = StaticMethods::now() : '';
        
        return $this->save() && (Logs::newLog(Logs::file_tracking_note, "Made note $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, null,  null, "$this->store_level,$this->store_id", $this->notes, null, Logs::success) || true);
    }

}
