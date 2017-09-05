<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%teacher_movements}}".
 *
 * @property integer $id
 * @property integer $teacher
 * @property integer $school
 * @property integer $request
 * @property string $since
 * @property string $till
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 * @property string $updater_school
 */
class TeacherMovements extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%teacher_movements}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['teacher', 'school', 'created_by'], 'required'],
            [['teacher', 'school', 'request', 'updater_school'], 'integer'],
            [['since', 'till', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'string', 'max' => 25],
            [['school'], 'validateSchool']
        ];
    }

    /**
     * teacher cannot be reposted in the same school he already is 
     */
    public function validateSchool() {
        if ($this->isNewRecord && is_object($current = static::teachersCurrentPosting($this->teacher)) && $current->school == $this->school)
            $this->addError('school', 'Teacher already in this school currently');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'teacher' => Yii::t('app', 'Teacher'),
            'school' => Yii::t('app', 'School'),
            'request' => Yii::t('app', 'Request'),
            'since' => Yii::t('app', 'Since'),
            'till' => Yii::t('app', 'Till'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updater_school' => Yii::t('app', 'Updater School')
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\TeacherMovementsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\TeacherMovementsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk movement id
     * @return TeacherMovements model
     */
    public static function returnMovement($pk) {
        return static::find()->byPk($pk);
    }

    public static function allMovements() {
        return static::find()->allMovents();
    }

    /**
     * 
     * @param integer $teacher teacher id
     * @param integer $school school id
     * @param integer $request request id
     * @param boolean $current true - current posting
     * @param string $since1 yyyy-mm-dd
     * @param string $since2 yyyy-mm-dd
     * @param string $till1 yyyy-mm-dd
     * @param string $till2 yyyy-mm-dd
     * @return TeacherMovements models
     */
    public static function searchMovements($teacher, $school, $request, $current, $since1, $since2, $till1, $till2) {
        return static::find()->searchMovements($teacher, $school, $current, $since1, $since2, $till1, $till2);
    }

    /**
     * 
     * @param integer $teacher teacher id
     * @param integer $school school id
     * @return TeacherMovements models
     */
    public static function currentPostings($teacher, $school) {
        return static::searchMovements($teacher, $school, null, true, null, null, null, null);
    }

    /**
     * 
     * @param integer $teacher teacher id
     * @param integer $school school id
     * @return TeacherMovements model
     */
    public static function teachersCurrentPostingInSchool($teacher, $school) {
        
        $movements = static::currentPostings($teacher, $school);
        
        return empty($movements) ? false : end($movements);
    }

    /**
     * 
     * @param integer $teacher teacher id
     * @param integer $school school id
     * @return TeacherMovements model
     */
    public static function teachersCurrentPosting($teacher) {
        foreach (static::searchMovements($teacher, null, null, true, null, null, null, null) as $movement)
            return $movement;
    }

    /**
     * 
     * @param integer $teacher teacher id
     * @param integer $school school id
     * @return TeacherMovements model
     */
    public static function newMovement($teacher, $school) {
        $model = new TeacherMovements;

        $model->teacher = $teacher;

        $model->school = $school;

        $model->since = StaticMethods::now();

        return $model;
    }

    /**
     * 
     * @param integer $id movement id
     * @param integer $teacher teacher id
     * @param integer $school school id
     * @return TeacherMovements model
     */
    public static function movementToLoad($id, $teacher, $school) {
        return is_object($model = static::returnMovement($id)) || (is_object($model = static::teachersCurrentPosting($teacher)) && $model->school == $school) ? $model : static::newMovement($teacher, $school);
    }

    /**
     * 
     * @param integer $id movement id
     * @param integer $teacher teacher id
     * @param string $since yyyy-mm-dd
     * @param string $created_by created by
     * @return TeacherMovements model
     */
    public static function movementDerivedFromNewTeacher($teacher, $school, $since, $created_by) {
        $posting = static::movementToLoad(null, $teacher, $school);

        $posting->since = $since;

        $posting->created_by = $created_by;

        $posting->modelSave();

        return $posting;
    }

    /**
     * 
     * @param string $till closed at yyyy-mm-dd
     * @param string $updated_by updated by
     * @param integer $updater_school school of `$updated_by`
     * @return boolean true - movement closed
     */
    public function closeMovement($till, $updated_by, $updater_school) {
        if (empty($this->till)) {
            $this->till = $till;

            $this->updated_by = $updated_by;

            $this->updater_school = $updater_school;

            return $this->modelSave();
        }

        return true;
    }

    /**
     * 
     * @param integer $teacher teacher id
     * @param integer $school new school id
     * @param string $till yyyy-mm-dd
     * @param string $updated_by updated by
     * @return boolean true - current movement closed
     */
    public static function closeCurrentMovement($teacher, $school, $till, $updated_by) {
        return !is_object($posting = static::teachersCurrentPosting($teacher)) || ($posting->school != $school && $posting->closeMovement($till, $updated_by, $school));
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        $this->isNewRecord ? $this->created_at = StaticMethods::now() : $this->updated_at = StaticMethods::now();
        
        $this->till > 0 ? '' : $this->till = null;

        if ($this->validate()) {
            $this->isNewRecord ? $transaction = Yii::$app->db->beginTransaction() : '';

            try {
                if ((empty($transaction) || static::closeCurrentMovement($this->teacher, $this->school, $this->since, empty($this->updated_by) ? $this->created_by : $this->updated_by)) && $this->save(false)) {
                    empty($transaction) || $transaction->commit();

                    return true;
                } else
                    empty($transaction) || $transaction->rollBack();
            } catch (Exception $ex) {
                empty($transaction) || $transaction->rollBack();
            }
        }
    }

    /**
     * 
     * @return boolean|string true - date teacher moved to another school
     */
    public function teacherMovedToAnotherSchool() {
        ($yes = is_object($latterPosting = static::find()->teacherMovedToAnotherSchool($this->teacher, $this->school, $this->id, $this->since))) && $this->closeMovement($latterPosting->since, $latterPosting->created_by, $latterPosting->school);

        return $yes ? $this->till : false;
    }

}
