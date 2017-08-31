<?php

namespace common\activeQueries;

/**
 * This is the ActiveQuery class for [[\common\models\SchoolTeachers]].
 *
 * @see \common\models\SchoolTeachers
 */
class SchoolTeachersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\SchoolTeachers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SchoolTeachers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
