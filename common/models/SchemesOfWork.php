<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%schemes_of_work}}".
 *
 * @property integer $id
 * @property integer $school
 * @property integer $year
 * @property integer $term
 * @property integer $class
 * @property integer $stream
 * @property integer $subject
 * @property string $notes
 * @property integer $submitted_as
 * @property string $location
 * @property string $subject_teacher
 * @property integer $subject_teacher_tsc_no
 * @property string $subject_head
 * @property string $subject_head_tsc_no
 * @property string $dept_head
 * @property string $dept_head_tsc_no
 * @property string $school_head
 * @property string $school_head_tsc_no
 * @property string $submitted_by
 * @property string $submitted_at
 * @property string $received
 * @property integer $received_by
 * @property string $received_at
 * @property string $remarks
 */
class SchemesOfWork extends \yii\db\ActiveRecord {

    const received = 'yes';
    const not_received = 'no';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%schemes_of_work}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['school', 'year', 'term', 'class', 'stream', 'subject', 'location', 'subject_teacher', 'subject_teacher_tsc_no', 'submitted_by'], 'required'],
            [['school', 'year', 'term', 'class', 'stream', 'subject', 'submitted_as', 'subject_teacher_tsc_no', 'received_by'], 'integer'],
            [['location'], 'file', 'extensions' => StaticMethods::implodeAcceptableFileTypes(), 'checkExtensionByMimeType' => false, 'maxSize' => 1024 * 1024 * 1024 * 1024 * 1024],
            [['notes', 'received', 'remarks'], 'string'],
            [['submitted_at', 'received_at'], 'safe'],
            [['subject_teacher', 'subject_head', 'dept_head', 'school_head', 'submitted_by'], 'string', 'max' => 50],
            [['subject_head_tsc_no', 'dept_head_tsc_no', 'school_head_tsc_no'], 'string', 'max' => 7],
            [['school', 'year', 'term', 'class', 'stream', 'subject'], 'distinctScheme'],
        ];
    }

    /**
     * distinct scheme
     * @param string $attribute attribute of scheme of work
     */
    public function distinctScheme($attribute) {
        if (count(static::searchSchemes($this->id, $this->school, $this->year, $this->term, $this->class, $this->stream, $this->subject, null, null)) > 0)
            $this->addError($attribute, 'This document seems to have been submitted earlier');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'school' => Yii::t('app', 'School'),
            'year' => Yii::t('app', 'Year'),
            'term' => Yii::t('app', 'Term'),
            'class' => Yii::t('app', 'Class'),
            'stream' => Yii::t('app', 'Stream'),
            'subject' => Yii::t('app', 'Subject'),
            'notes' => Yii::t('app', 'Notes'),
            'submitted_as' => Yii::t('app', 'Submitted As'),
            'location' => Yii::t('app', 'Location'),
            'subject_teacher' => Yii::t('app', 'Subject Teacher'),
            'subject_teacher_tsc_no' => Yii::t('app', 'Subject Teacher TSC No'),
            'subject_head' => Yii::t('app', 'Subject Head'),
            'subject_head_tsc_no' => Yii::t('app', 'Subject Head TSC No'),
            'dept_head' => Yii::t('app', 'Department Head'),
            'dept_head_tsc_no' => Yii::t('app', 'Department Head TSC No'),
            'school_head' => Yii::t('app', 'School Head'),
            'school_head_tsc_no' => Yii::t('app', 'School Head TSC No'),
            'submitted_by' => Yii::t('app', 'Submitted By'),
            'submitted_at' => Yii::t('app', 'Submitted At'),
            'received' => Yii::t('app', 'Received'),
            'received_by' => Yii::t('app', 'Received By'),
            'received_at' => Yii::t('app', 'Received At'),
            'remarks' => Yii::t('app', 'Remarks'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\SchemesOfWorkQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\SchemesOfWorkQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk scheme id
     * @return SchemesOfWork model
     */
    public static function returnScheme($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return SchemesOfWork models
     */
    public static function allSchemes() {
        return static::find()->allSchemes();
    }

    /**
     * 
     * @param integer $id scheme id
     * @param integer $school school id
     * @param integer $year year
     * @param integer $term term
     * @param integer $class class id
     * @param integer $stream stream id
     * @param integer $subject subject id
     * @param string $submitted_by_date date submitted by
     * @param string $received yes or no
     * @return SchemesOfWork models
     */
    public static function searchSchemes($id, $school, $year, $term, $class, $stream, $subject, $submitted_by_date, $received) {
        return static::find()->searchSchemes($id, $school, $year, $term, $class, $stream, $subject, $submitted_by_date, $received);
    }

    /**
     * 
     * @param integer $school school id
     * @param integer $year year
     * @param integer $term term
     * @param integer $class class id
     * @param integer $stream stream id
     * @param integer $subject subject id
     * @return SchemesOfWork model
     */
    public static function newScheme($school, $year, $term, $class, $stream, $subject) {
        $model = new SchemesOfWork;

        $model->school = $school;
        $model->year = $year;
        $model->term = $term;
        $model->class = $class;
        $model->stream = $stream;
        $model->subject = $subject;

        return $model;
    }

    /**
     * 
     * @param integer $id scheme id
     * @param integer $school school id
     * @param integer $year year
     * @param integer $term term
     * @param integer $class class id
     * @param integer $stream stream id
     * @param integer $subject subject id
     * @return SchemesOfWork model
     */
    public static function schemeToLoad($id, $school, $year, $term, $class, $stream, $subject) {
        return is_object($model = static::returnScheme($id)) ? $model : static::newScheme($school, $year, $term, $class, $stream, $subject);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        return $this->save();
    }

    /**
     * 
     * @return string file location
     */
    public function fileLocation() {
        return StaticMethods::uploadsFolder() . $this->location;
    }

    /**
     * 
     * @return string file location url
     */
    public function imageLocationUrl() {
        return StaticMethods::uploadsFolderUrl() . $this->location;
    }

    /**
     * 
     * @return boolean true - model and image deleted
     */
    public function modelDelete() {
        return ($this->isNewRecord || $this->delete()) && @unlink(StaticMethods::uploadsFolder() . $this->location);
    }

}
