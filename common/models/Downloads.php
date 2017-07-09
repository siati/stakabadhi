<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%downloads}}".
 *
 * @property integer $id
 * @property integer $user
 * @property string $filename
 */
class Downloads extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%downloads}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user', 'filename'], 'required'],
            [['user'], 'integer'],
            [['filename'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', 'User'),
            'filename' => Yii::t('app', 'Name Of File'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\DownloadsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\DownloadsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk download id
     * @return Downloads model
     */
    public static function returnDownload($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param integer $user user id
     * @param string $filename filename
     * @return Downloads model
     */
    public static function byUserAndFilename($user, $filename) {
        return static::find()->byUserAndFilename($user, $filename);
    }

    /**
     * 
     * @param integer $user user id
     * @return Downloads models
     */
    public static function downloadsQuery($user) {
        return static::find()->downloadsQuery($user);
    }

    /**
     * 
     * @param integer $user user id
     * @param string $filename filename
     * @return Downloads model
     */
    public static function newDownload($user, $filename) {
        $model = new Downloads;

        $model->user = $user;
        $model->filename = $filename;

        return $model->save(false) ? $model : false;
    }

    /**
     * 
     * @param integer $user user id
     * @param string $filename filename
     * @return Downloads model
     */
    public static function downloadToLoad($user, $filename) {
        return is_object($model = static::byUserAndFilename($user, $filename)) ? $model : static::newDownload($user, $filename);
    }

    /**
     * delete downloads for offline users
     */
    public static function deleteOfflineUsersDownloads() {
        foreach (User::onlineOfflineUsers(User::CURRENTLY_NOT_LOGGED_IN) as $user)
            static::deleteUsersDownloads($user->id);
    }

    /**
     * 
     * @param integer $user user id
     */
    public static function deleteUsersDownloads($user) {
        foreach (static::downloadsQuery($user) as $download)
            $download->deleteDownload();
    }

    /**
     * 
     * delete download file
     */
    public function deleteDownload() {
        try {
            ((is_file($location = StaticMethods::downloadsFolder() . $this->filename) && unlink($location)) || (is_dir($location) && rmdir($location)) || true) && $this->delete();
        } catch (Exception $ex) {
            
        }
    }

}
