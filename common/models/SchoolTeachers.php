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
class SchoolTeachers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%school_teachers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fname', 'mname', 'lname', 'dob', 'gender', 'id_no', 'tsc_no', 'subject_one', 'postal_no', 'postal_code', 'county', 'constituency', 'ward', 'created_by'], 'required'],
            [['dob', 'since', 'till', 'created_at', 'updated_at'], 'safe'],
            [['gender'], 'string'],
            [['county', 'constituency', 'ward'], 'integer'],
            [['fname', 'mname', 'lname'], 'string', 'max' => 15],
            [['id_no'], 'string', 'max' => 8],
            [['tsc_no'], 'string', 'max' => 7],
            [['phone'], 'string', 'max' => 13],
            [['email'], 'string', 'max' => 40],
            [['subject_one', 'subject_two'], 'string', 'max' => 3],
            [['postal_no'], 'string', 'max' => 6],
            [['postal_code'], 'string', 'max' => 5],
            [['location', 'sub_location', 'village'], 'string', 'max' => 30],
            [['created_by', 'updated_by'], 'string', 'max' => 25],
            [['id_no'], 'unique'],
            [['tsc_no'], 'unique'],
            [['phone'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
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
    public static function find()
    {
        return new \common\activeQueries\SchoolTeachersQuery(get_called_class());
    }
}
