<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%subjects}}".
 *
 * @property integer $id
 * @property integer $school
 * @property string $level
 * @property string $dept
 * @property string $dept_name
 * @property integer $class
 * @property string $subject
 * @property string $code
 * @property string $name
 * @property string $active
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class Subjects extends \yii\db\ActiveRecord {

    const active = 'yes';
    const not_active = 'no';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%subjects}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['school', 'class'], 'integer'],
            [['level', 'dept', 'dept_name', 'class', 'subject', 'code', 'name', 'created_by'], 'required'],
            [['level', 'active'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['dept', 'subject'], 'string', 'max' => 5],
            [['dept_name', 'created_by', 'updated_by'], 'string', 'max' => 25],
            [['code'], 'string', 'max' => 6],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * distinct subject per class
     */
    public function distinctSubject() {
        if (is_object(static::bySchoolLevelClassAndSubject($this->id, $this->school, $this->level, $this->class, $this->subject)))
            $this->addError('subject', 'This subject already exists for this class');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'school' => Yii::t('app', 'School'),
            'level' => Yii::t('app', 'Level'),
            'dept' => Yii::t('app', 'Department Code'),
            'dept_name' => Yii::t('app', 'Department Name'),
            'class' => Yii::t('app', 'Class'),
            'subject' => Yii::t('app', 'Subject'),
            'code' => Yii::t('app', 'Subject Code'),
            'name' => Yii::t('app', 'Subject Name'),
            'active' => Yii::t('app', 'Active'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\SubjectsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\SubjectsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk subject id
     * @return Subjects model
     */
    public static function returnSubjects($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $dept department
     * @param integer $class class
     * @param string $subject subject
     * @param string $active yes, no
     * @return Subjects models
     */
    public static function searchSubjects($id, $school, $level, $dept, $class, $subject, $active) {
        return static::find()->searchSubjects($id, $school, $level, $dept, $class, $subject, $active);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $active yes, no
     * @return Subjects models
     */
    public static function forSchool($school, $active) {
        return static::searchSubjects(null, $school, null, null, null, null, $active);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $active yes, no
     * @return Subjects models
     */
    public static function forSchoolAndLevel($school, $level, $active) {
        return static::searchSubjects(null, $school, $level, null, null, null, $active);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $dept department
     * @param string $active yes, no
     * @return Subjects models
     */
    public static function forSchoolLevelAndDept($school, $level, $dept, $active) {
        return static::searchSubjects(null, $school, $level, $dept, null, null, $active);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param string $dept department
     * @param integer $class class
     * @param string $active yes, no
     * @return Subjects models
     */
    public static function forSchoolLevelDeptAndClass($school, $level, $dept, $class, $active) {
        return static::searchSubjects(null, $school, $level, $dept, $class, null, $active);
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $subject subject
     * @return Subjects models
     */
    public static function bySchoolLevelClassAndSubject($id, $school, $level, $class, $subject) {
        return static::searchSubjects($id, $school, $level, null, $class, $subject, null);
    }

    /**
     * 
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $subject subject
     * @return Subjects models
     */
    public static function newSubject($school, $level, $class, $subject) {
        $model = new Subjects;

        $model->school = $school;
        $model->level = $level;
        $model->class = $class;
        $model->subject = $subject;

        $model->active = self::active;

        return $model;
    }

    /**
     * 
     * @param integer $id class id
     * @param integer|null $school school id
     * @param string $level school level
     * @param integer $class class
     * @param string $subject subject
     * @return Subjects models
     */
    public static function classToLoad($id, $school, $level, $class, $subject) {
        return is_object($model = static::returnSubjects($id)) ? $model : static::newSubject($school, $level, $class, $subject);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        $this->isNewRecord ? $this->created_at = StaticMethods::now() : $this->updated_at = StaticMethods::now();

        return $this->save();
    }

}
