<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SchemesOfWork */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Schemes Of Work',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schemes Of Works'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="schemes-of-work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
