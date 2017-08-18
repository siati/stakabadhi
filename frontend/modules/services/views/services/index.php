<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\searchModels\SchemesOfWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Schemes Of Works');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schemes-of-work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Schemes Of Work'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'school',
            'year',
            'term',
            'class',
            // 'stream',
            // 'subject',
            // 'notes:ntext',
            // 'submitted_as',
            // 'location',
            // 'subject_teacher',
            // 'subject_teacher_tsc_no',
            // 'subject_head',
            // 'subject_head_tsc_no',
            // 'dept_head',
            // 'dept_head_tsc_no',
            // 'school_head',
            // 'school_head_tsc_no',
            // 'submitted_by',
            // 'submitted_at',
            // 'received',
            // 'received_by',
            // 'received_at',
            // 'remarks:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
