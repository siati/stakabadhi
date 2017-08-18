<?php

namespace common\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SchemesOfWork;

/**
 * SchemesOfWorkSearch represents the model behind the search form about `common\models\SchemesOfWork`.
 */
class SchemesOfWorkSearch extends SchemesOfWork
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'school', 'year', 'term', 'class', 'stream', 'subject', 'subject_teacher_tsc_no', 'received_by'], 'integer'],
            [['notes', 'submitted_as', 'location', 'subject_teacher', 'subject_head', 'subject_head_tsc_no', 'dept_head', 'dept_head_tsc_no', 'school_head', 'school_head_tsc_no', 'submitted_by', 'submitted_at', 'received', 'received_at', 'remarks'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SchemesOfWork::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'school' => $this->school,
            'year' => $this->year,
            'term' => $this->term,
            'class' => $this->class,
            'stream' => $this->stream,
            'subject' => $this->subject,
            'subject_teacher_tsc_no' => $this->subject_teacher_tsc_no,
            'submitted_at' => $this->submitted_at,
            'received_by' => $this->received_by,
            'received_at' => $this->received_at,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'submitted_as', $this->submitted_as])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'subject_teacher', $this->subject_teacher])
            ->andFilterWhere(['like', 'subject_head', $this->subject_head])
            ->andFilterWhere(['like', 'subject_head_tsc_no', $this->subject_head_tsc_no])
            ->andFilterWhere(['like', 'dept_head', $this->dept_head])
            ->andFilterWhere(['like', 'dept_head_tsc_no', $this->dept_head_tsc_no])
            ->andFilterWhere(['like', 'school_head', $this->school_head])
            ->andFilterWhere(['like', 'school_head_tsc_no', $this->school_head_tsc_no])
            ->andFilterWhere(['like', 'submitted_by', $this->submitted_by])
            ->andFilterWhere(['like', 'received', $this->received])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
