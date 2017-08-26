<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%classes}}".
 *
 * @property integer $id
 * @property integer $school
 * @property string $level
 * @property integer $class
 * @property string $stream
 * @property string $symbol
 * @property string $name
 * @property string $active
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class Classes extends \yii\db\ActiveRecord {

    const active = 'yes';
    const not_active = 'no';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%classes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['school', 'class'], 'integer'],
            [['level', 'class', 'stream', 'symbol', 'name', 'created_by'], 'required'],
            [['level', 'active'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['stream'], 'string', 'max' => 1],
            [['symbol'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 20],
            [['stream', 'symbol', 'name'], 'distinctStream'],
            [['active'], 'newClassMustBeActive'],
            [['symbol', 'name'], 'distinctAttribute'],
            [['created_by', 'updated_by'], 'string', 'max' => 25],
        ];
    }

    /**
     * stream can only exist once per class
     */
    public function distinctStream() {
        if (is_object(static::bySchoolLevelClassAndStream($this->id, $this->school, $this->level, $this->class, $this->stream)))
            $this->addError('stream', 'This stream already exists for the class');
    }

    /**
     * class can only exist once
     */
    public function distinctAttribute($attribute) {
        if (is_object(static::find()->distinctAttribute($this->id, $this->school, $this->level, $attribute, $this->$attribute)))
            $this->addError($attribute, 'This ' . $this->getAttributeLabel($attribute) . 'already exists');
    }
    
    /**
     * new class must be active
     */
    public function newClassMustBeActive() {
        if ($this->isNewRecord && $this->active != self::active)
            $this->addError ('active', 'New class must be active by default');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'school' => Yii::t('app', 'School'),
            'level' => Yii::t('app', 'Level'),
            'class' => Yii::t('app', 'Class'),
            'stream' => Yii::t('app', 'Stream'),
            'symbol' => Yii::t('app', 'Symbol'),
            'name' => Yii::t('app', 'Name'),
            'active' => Yii::t('app', 'Active'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\ClassesQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\ClassesQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk class id
     * @return Classes model
     */
    public static function returnClass($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $stream stream
     * @param symbol $symbol class symbol
     * @param string $name class name
     * @param string $active yes, no
     * @return Classes models
     */
    public static function searchClasses($id, $school, $level, $class, $stream, $symbol, $name, $active) {
        return static::find()->searchClasses($id, $school, $level, $class, $stream, $symbol, $name, $active);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $active yes, no
     * @return Classes models
     */
    public static function forSchool($school, $active) {
        return static::searchClasses(null, $school, null, null, null, null, null, $active);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $active yes, no
     * @return Classes models
     */
    public static function forSchoolAndLevel($school, $level, $active) {
        return static::searchClasses(null, $school, $level, null, null, null, null, $active);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $active yes, no
     * @return Classes models
     */
    public static function forSchoolLevelAndClass($school, $level, $class, $active) {
        return static::searchClasses(null, $school, $level, $class, null, null, null, $active);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $stream stream
     * @param string $active yes, no
     * @return Classes models
     */
    public static function forSchoolLevelAndStream($school, $level, $stream, $active) {
        return static::searchClasses(null, $school, $level, null, $stream, null, null, $active);
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $stream stream
     * @return Classes model
     */
    public static function bySchoolLevelClassAndStream($id, $school, $level, $class, $stream) {
        foreach (static::searchClasses($id, $school, $level, $class, $stream, null, null, null) as $classRoom)
            return $classRoom;
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $stream stream
     * @return Classes model
     */
    public static function newClass($school, $level, $class, $stream) {
        $model = new Classes;

        $model->school = $school;
        $model->level = $level;
        $model->class = $class;
        $model->stream = $stream;
        $model->active = self::active;

        return $model;
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $stream stream
     * @return Classes model
     */
    public static function classToLoad($id, $school, $level, $class, $stream) {
        return is_object($model = static::returnClass($id)) ? $model : static::newClass($school, $level, $class, $stream);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        $this->isNewRecord ? $this->created_at = StaticMethods::now() : $this->updated_at = StaticMethods::now();

        return $this->save();
    }

    /**
     * 
     * @param array $posts post params
     * @return string server response
     */
    public static function classRegistrationService($posts) {
        if (isset($posts['Classes']))
            foreach ($posts['Classes'] as $id => $post)
                empty($id) ? $posts['Classes'][$id]['created_by'] = Yii::$app->user->identity->name : $posts['Classes'][$id]['updated_by'] = Yii::$app->user->identity->name;

        return StaticMethods::seekService('http://localhost/we@ss/frontend/web/services/services/school-classes', $posts);
    }

}
