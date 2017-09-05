<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%teacher_movement_requests}}".
 *
 * @property integer $id
 * @property integer $teacher
 * @property integer $school
 * @property string $type
 * @property string $initiated_by
 * @property string $author_name
 * @property string $initiated_at
 * @property string $tsc_approved
 * @property string $tsc_approved_at
 * @property string $school_remark
 * @property string $tsc_remark
 */
class TeacherMovementRequests extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%teacher_movement_requests}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['teacher', 'initiated_by', 'author_name'], 'required'],
            [['teacher', 'school'], 'integer'],
            [['type', 'initiated_by', 'tsc_approved', 'school_remark', 'tsc_remark'], 'string'],
            [['initiated_at', 'tsc_approved_at'], 'safe'],
            [['author_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'teacher' => Yii::t('app', 'Teacher'),
            'school' => Yii::t('app', 'School'),
            'type' => Yii::t('app', 'Entry or Exit'),
            'initiated_by' => Yii::t('app', 'Initiated By'),
            'author_name' => Yii::t('app', 'Author Name'),
            'initiated_at' => Yii::t('app', 'Initiated At'),
            'tsc_approved' => Yii::t('app', 'TSC Approved'),
            'tsc_approved_at' => Yii::t('app', 'TSC Approved At'),
            'school_remark' => Yii::t('app', 'Remark By School'),
            'tsc_remark' => Yii::t('app', 'Remark By TSC'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\TeacherMovementRequestsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\TeacherMovementRequestsQuery(get_called_class());
    }

}
