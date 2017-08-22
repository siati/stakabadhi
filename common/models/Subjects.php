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
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subjects}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
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
    public static function find()
    {
        return new \common\activeQueries\SubjectsQuery(get_called_class());
    }
}
