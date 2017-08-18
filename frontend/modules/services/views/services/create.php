<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SchemesOfWork */

$this->title = Yii::t('app', 'Create Schemes Of Work');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schemes Of Works'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schemes-of-work-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
