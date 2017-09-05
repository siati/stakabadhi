<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%teachers}}".
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
 * @property string $active
 * @property string $created_by
 * @property string $created_at
 * @property integer $author_school
 * @property string $updated_by
 * @property string $updated_at
 * @property integer $updater_school
 */
class Teachers extends \yii\db\ActiveRecord {

    const male = 'm';
    const female = 'f';
    const active = 'yes';
    const not_active = 'no';
    const min_age = 25;
    const byID = 'ID. No.';
    const byTSC = 'TSC No.';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%teachers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['fname', 'mname', 'lname', 'dob', 'gender', 'id_no', 'tsc_no', 'subject_one', 'postal_no', 'postal_code', 'county', 'constituency', 'ward', 'created_by', 'author_school'], 'required'],
            [['gender'], 'string'],
            [['id_no', 'tsc_no', 'phone', 'postal_no', 'postal_code', 'county', 'constituency', 'ward', 'author_school', 'updater_school'], 'integer'],
            [['fname', 'mname', 'lname'], 'string', 'max' => 15],
            [['fname', 'mname', 'lname', 'location', 'sub_location', 'village'], 'notNumerical'],
            [['id_no'], 'string', 'min' => 7, 'max' => 8],
            [['tsc_no'], 'string', 'min' => 6, 'max' => 7],
            [['phone'], 'string', 'min' => 9, 'max' => 13],
            [['email'], 'string', 'max' => 40],
            [['phone'], 'kenyaPhoneNumber'],
            [['dob'], 'atleastTwentyYears'],
            [['subject_one', 'subject_two', 'active'], 'string', 'max' => 3],
            [['postal_no'], 'string', 'max' => 6],
            [['location', 'sub_location', 'village', 'created_by', 'updated_by'], 'string', 'min' => 3, 'max' => 25],
            [['dob', 'created_at', 'updated_at'], 'safe'],
            [['id_no', 'tsc_no', 'phone', 'email'], 'unique'],
            [['email'], 'email'],
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
            'active' => Yii::t('app', 'Active'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'author_school' => Yii::t('app', 'Author School'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updater_school' => Yii::t('app', 'Updater School')
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\TeachersQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\TeachersQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk teacher id
     * @return Teachers model
     */
    public static function returnTeacher($pk) {
        return static::find()->byPk($pk);
    }

    /**
     * 
     * @return Teachers models
     */
    public static function allTeachers() {
        return static::find()->allTeachers();
    }
    
    /**
     * 
     * @param integer $school school id
     * @return Teachers models
     */
    public static function currentTeachersInSchool($school) {
        return static::find()->currentTeachersInSchool($school);
    }

    /**
     * 
     * @param string $name name of teacher
     * @param string $gender m: male, f: female
     * @param string $subject subject
     * @param string $active yes / no
     * @return Teachers models
     */
    public static function searchTeachers($name, $gender, $subject, $active) {
        return static::find()->searchTeachers($name, $gender, $subject, $active);
    }

    /**
     * 
     * @param integer $id_no id no
     * @return Teachers model
     */
    public static function byIDNo($id_no) {
        return static::find()->byIDNo($id_no);
    }

    /**
     * 
     * @param integer $tsc_no tsc no
     * @return Teachers model
     */
    public static function byTSCNo($tsc_no) {
        return static::find()->byTSCNo($tsc_no);
    }

    /**
     * 
     * @param integer $phone phone no
     * @return Teachers model
     */
    public static function byPhone($phone) {
        return static::find()->byPhone($phone);
    }

    /**
     * 
     * @param integer $email email address
     * @return Teachers model
     */
    public static function byEmail($email) {
        return static::find()->byEmail($email);
    }

    /**
     * 
     * @return Teachers model
     */
    public static function newTeacher() {
        $model = new Teachers;

        $model->dob = date('Y') - self::min_age . '-01-01';

        $model->active = self::active;

        return $model;
    }

    /**
     * 
     * @param integer $id teacher id
     * @return Teachers model
     */
    public static function teacherToLoad($id) {
        return is_object($model = static::returnTeacher($id)) ? $model : static::newTeacher();
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        $this->isNewRecord ? $this->created_at = StaticMethods:: now() : $this->updated_at = StaticMethods::now();
        
        $wasNew = $this->isNewRecord;
        
        return $this->save() && (!$wasNew || TeacherMovements::movementDerivedFromNewTeacher($this->id, $this->author_school, $this->created_at, $this->created_by) || true);
    }
    
    /**
     * @param integer $school school
     * @return TeacherMovements teacher (`$this->id`) is currently posted in `$this->school`
     */
    public function teacherIsCurrentlyPostedInThisSchool($school) {
        return TeacherMovements::teachersCurrentPostingInSchool($this->id, $school);
    }

    /**
     * 
     * @return array genders
     */
    public static function genders() {
        return [static::male => 'Male', static::female => 'Female'];
    }

}
