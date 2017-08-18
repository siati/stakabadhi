<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SchemesOfWork */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schemes Of Works'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schemes-of-work-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'school',
            'year',
            'term',
            'class',
            'stream',
            'subject',
            'notes:ntext',
            'submitted_as',
            'location',
            'subject_teacher',
            'subject_teacher_tsc_no',
            'subject_head',
            'subject_head_tsc_no',
            'dept_head',
            'dept_head_tsc_no',
            'school_head',
            'school_head_tsc_no',
            'submitted_by',
            'submitted_at',
            'received',
            'received_by',
            'received_at',
            'remarks:ntext',
        ],
    ]) ?>

</div>
