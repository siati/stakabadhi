<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%slide_images}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $caption
 * @property string $location
 * @property string $url_to
 * @property integer $created_by
 * @property string $created_at
 * @property string $active
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $name_visible
 * @property string $caption_visible
 */
class SlideImages extends \yii\db\ActiveRecord {

    const active = '1';
    const not_active = '0';
    const name_visible = '1';
    const name_not_visible = '0';
    const caption_visible = '1';
    const caption_not_visible = '0';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%slide_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'location', 'created_by'], 'required'],
            [['location'], 'file', 'extensions' => implode(',', static::acceptableFileTypes()), 'checkExtensionByMimeType' => false, 'maxSize' => 1024 * 1024],
            [['caption', 'active', 'name_visible', 'caption_visible'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'min' => 1, 'max' => 20],
            [['url_to'], 'url'],
            [['url_to'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'caption' => Yii::t('app', 'Caption'),
            'location' => Yii::t('app', 'Location'),
            'url_to' => Yii::t('app', 'Associated Link Location'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'active' => Yii::t('app', 'Active'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'name_visible' => Yii::t('app', 'Name Is Visible'),
            'caption_visible' => Yii::t('app', 'Caption Is Visible'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\SlideImagesQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\SlideImagesQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk image id
     * @return SlideImages model
     */
    public static function returnImage($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return SlideImages models
     */
    public static function allImages() {
        return static::find()->allImages();
    }

    /**
     * 
     * @return SlideImages models
     */
    public static function allActiveImages() {
        return static::find()->allActiveImages();
    }

    /**
     * 
     * @return SlideImages models
     */
    public static function allInactiveImages() {
        return static::find()->allInactiveImages();
    }

    /**
     * 
     * @param integer $active 0 - inactive, 1 - active
     * @param string $name image name
     * @param string $caption image caption
     * @param string $url_to image link to
     * @param integer $created_by user id
     * @param string $created_since created since
     * @param string $created_till created till
     * @param integer $updated_by user id
     * @param string $updated_since updated since
     * @param string $updated_till updated till
     * @return SlideImages models
     */
    public static function queryImages($active, $name, $caption, $url_to, $created_by, $created_since, $created_till, $updated_by, $updated_since, $updated_till) {
        return static::find()->queryImages($active, $name, $caption, $url_to, $created_by, $created_since, $created_till, $updated_by, $updated_since, $updated_till);
    }

    /**
     * 
     * @return SlideImages model
     */
    public static function newImage() {
        $model = new SlideImages;

        $model->created_by = Yii::$app->user->identity->id;
        $model->active = self::active;
        $model->name_visible = self::name_visible;
        $model->caption_visible = self::caption_visible;

        return $model;
    }

    /**
     * 
     * @param integer $id image id
     * @return SlideImages model
     */
    public static function imageToLoad($id) {
        return is_object($model = static::returnImage($id)) ? $model : static::newImage();
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord)
            $this->created_at = StaticMethods::now();
        else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
        }

        return $this->save();
    }

    /**
     * 
     * @return string image location
     */
    public function imageLocation() {
        return StaticMethods::slidesFolder() . $this->location;
    }

    /**
     * 
     * @return string image location url
     */
    public function imageLocationUrl() {
        return StaticMethods::slidesFolderUrl() . $this->location;
    }

    /**
     * 
     * @return boolean true - model and image deleted
     */
    public function modelDelete() {
        return ($this->isNewRecord || $this->delete()) && @unlink(StaticMethods::slidesFolder() . $this->location);
    }

    /**
     * 
     * @return string extension of image
     */
    public function imageExtesion() {
        return substr($this->location, strripos($this->location, '.') + 1);
    }

    /**
     * 
     * @param UploadedFile $file uploaded file
     * @param boolean $save true - save
     * @param string $folder attribute of Files object class
     */
    public function saveUploadedFile($file, $save) {
        !empty($file) && static::fileTypeAllowed($file->name) && ($this->location = $file) && $this->validate(['location']) && $this->isNewRecord && $save && $file->saveAs(StaticMethods::slidesFolder() . ($saveAs = (strtolower(StaticMethods::stripNonNumeric(StaticMethods::now()) . ".$file->extension")))) ?
                        ($this->location = $saveAs) : (empty($file) || !$save ? ($this->isNewRecord ? $this->location = strtolower(StaticMethods::stripNonNumeric(StaticMethods::now() . '.jpg')) : '') : ($this->addError('location', "$file->name not uploaded")));
    }

    /**
     * 
     * @return array extensions allowed for images uploaded
     */
    public static function acceptableFileTypes() {
        foreach ($exts = StaticMethods::acceptableFileTypes() as $i => $ext) {
            $check = StaticMethods::fileTypeDescription($ext);

            if ($check[StaticMethods::ext_type] != StaticMethods::ext_is_img)
                unset($exts[$i]);
        }

        return $exts;
    }

    /**
     * 
     * @param string $fileName file name
     * @return boolean true - file type acceptable
     */
    public static function fileTypeAllowed($fileName) {
        $explode = explode('.', $fileName);

        $check = StaticMethods::fileTypeDescription(strtolower(end($explode)));

        return $check[StaticMethods::ext_type] == StaticMethods::ext_is_img;
    }

}
