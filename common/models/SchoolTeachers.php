<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%school_teachers}}".
 *
 * @property integer $id
 * @property string $fname
 * @property string $mname
 * @property string $lname
 * @property string $dob
 * @property string $gender
 * @property string $id_no
 * @property string $tsc_no
 * @property string $phone
 * @property string $email
 * @property string $subject_one
 * @property string $subject_two
 * @property string $postal_no
 * @property string $postal_code
 * @property integer $county
 * @property integer $constituency
 * @property integer $ward
 * @property string $location
 * @property string $sub_location
 * @property string $village
 * @property string $since
 * @property string $till
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class SchoolTeachers extends \yii\db\ActiveRecord {

    const min_age = 25;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%school_teachers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['fname', 'mname', 'lname', 'dob', 'gender', 'id_no', 'tsc_no', 'subject_one', 'postal_no', 'postal_code', 'county', 'constituency', 'ward', 'created_by'], 'required'],
            [['dob', 'since', 'till', 'created_at', 'updated_at'], 'safe'],
            [['gender'], 'string'],
            [['id_no', 'tsc_no', 'phone', 'postal_no', 'postal_code', 'county', 'constituency', 'ward'], 'integer'],
            [['fname', 'mname', 'lname'], 'string', 'max' => 15],
            [['id_no'], 'string', 'min' => 7, 'max' => 8],
            [['tsc_no'], 'string', 'min' => 6, 'max' => 7],
            [['phone'], 'string', 'min' => 9, 'max' => 13],
            [['phone'], 'kenyaPhoneNumber'],
            [['email'], 'email'],
            [['dob'], 'atleastTwentyYears'],
            [['email'], 'string', 'max' => 40],
            [['subject_one', 'subject_two'], 'string', 'max' => 3],
            [['postal_no'], 'string', 'max' => 6],
            [['postal_code'], 'string', 'max' => 5],
            [['location', 'sub_location', 'village'], 'string', 'max' => 30],
            [['created_by', 'updated_by'], 'string', 'max' => 25]
        ];
    }

    /**
     * set minimum acceptable age
     */
    public function atleastTwentyYears() {
        if (date('Y') - substr($this->dob, 0, 4) < ($age = self::min_age))
            $this->addError('dob', "Minimum age required age is $age years");
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'fname' => Yii::t('app', 'First Name'),
            'mname' => Yii::t('app', 'Middle Name'),
            'lname' => Yii::t('app', 'Last Name'),
            'dob' => Yii::t('app', 'Date Of Birth'),
            'gender' => Yii::t('app', 'Gender'),
            'id_no' => Yii::t('app', 'National ID. No.'),
            'tsc_no' => Yii::t('app', 'TSC. No.'),
            'phone' => Yii::t('app', 'Phone No.'),
            'email' => Yii::t('app', 'Email Address'),
            'subject_one' => Yii::t('app', 'Main Subject'),
            'subject_two' => Yii::t('app', 'Second Subject'),
            'postal_no' => Yii::t('app', 'Postal No.'),
            'postal_code' => Yii::t('app', 'Postal Code'),
            'county' => Yii::t('app', 'County'),
            'constituency' => Yii::t('app', 'Constituency'),
            'ward' => Yii::t('app', 'Ward'),
            'location' => Yii::t('app', 'Location'),
            'sub_location' => Yii::t('app', 'Sub Location'),
            'village' => Yii::t('app', 'Village'),
            'since' => Yii::t('app', 'Since'),
            'till' => Yii::t('app', 'Till'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\SchoolTeachersQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\SchoolTeachersQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk school teacher id
     * @return SchoolTeachers model
     */
    public static function returnTeacher($pk) {
        return static::find()->byPk($pk);
    }

    /**
     * 
     * @param boolean $current true - current
     * @param string $since yyyy-mm-dd
     * @param string $till yyyy-mm-dd
     * @return SchoolTeachers models
     */
    public static function allTeachers($current, $since, $till) {
        return static::find()->allTeachers($current, $since, $till);
    }

    /**
     * 
     * @param integer $id_no id no of teacher
     * @param integer $tsc_no tsc no of teacher
     * @param string $name name of teacher
     * @param string $gender m: male, f: female
     * @param string $subject subject
     * @param boolean $current true - current posting
     * @param string $since1 yyyy-mm-dd
     * @param string $since2 yyyy-mm-dd
     * @param string $till1 yyyy-mm-dd
     * @param string $till2 yyyy-mm-dd
     * @return SchoolTeachers models
     */
    public static function searchTeachers($id_no, $tsc_no, $name, $gender, $subject, $current, $since1, $since2, $till1, $till2) {
        return static::find()->searchTeachers($id_no, $tsc_no, $name, $gender, $subject, $current, $since1, $since2, $till1, $till2);
    }

    /**
     * 
     * @param integer $id_no id no of teacher
     * @param integer $tsc_no tsc no of teacher
     * @return SchoolTeachers models
     */
    public static function currentPostings($id_no, $tsc_no) {
        return static::searchTeachers($id_no, $tsc_no, null, null, null, true, null, null, null, null);
    }

    /**
     * 
     * @param integer $id_no id no of teacher
     * @param integer $tsc_no tsc no of teacher
     * @return SchoolTeachers model
     */
    public static function teachersCurrentPosting($id_no, $tsc_no) {
        foreach (static::currentPostings($id_no, $tsc_no) as $teacher)
            return $teacher;
    }

    /**
     * 
     * @param integer $id_no id no
     * @return SchoolTeachers model
     */
    public static function byIDNo($id_no) {
        return static::find()->byIDNo($id_no);
    }

    /**
     * 
     * @param integer $tsc_no tsc no
     * @return SchoolTeachers model
     */
    public static function byTSCNo($tsc_no) {
        return static::find()->byTSCNo($tsc_no);
    }

    /**
     * 
     * @param integer $phone phone no
     * @return SchoolTeachers model
     */
    public static function byPhone($phone) {
        return static::find()->byPhone($phone);
    }

    /**
     * 
     * @param integer $email email address
     * @return SchoolTeachers model
     */
    public static function byEmail($email) {
        return static::find()->byEmail($email);
    }

    /**
     * 
     * @param integer $id_no id no of teacher
     * @param integer $tsc_no tsc no of teacher
     * @return SchoolTeachers model
     */
    public static function newTeacher($id_no, $tsc_no) {
        $model = new SchoolTeachers;
        
        $model->id_no = $id_no;
        
        $model->tsc_no = $tsc_no;

        $model->dob = date('Y') - self::min_age . '-01-01';

        $model->since = StaticMethods::now();

        $model->created_by = Yii::$app->user->identity->name;

        return $model;
    }

    /**
     * 
     * @param integer $id teacher id
     * @param integer $id_no id no of teacher
     * @param integer $tsc_no tsc no of teacher
     * @return SchoolTeachers model
     */
    public static function teacherToLoad($id, $id_no, $tsc_no) {
        return is_object($model = static::returnTeacher($id)) || is_object($model = static::teachersCurrentPosting($id_no, $tsc_no)) ? $model : static::newTeacher($id_no, $tsc_no);
    }
    
    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord)
            $this->created_at = StaticMethods::now();
        else {
            $this->updated_by = Yii::$app->user->identity->name;
            $this->updated_at = StaticMethods::now();
        }
        
        $this->till > 0 ? '' : $this->till = null;

        return $this->save();
    }

}
