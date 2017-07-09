<?php
/* @var $this yii\web\View */
/* @var $model common\models\Documents */
/* @var $user integer */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$is_admin = Yii::$app->user->identity->userStillHasRights([\common\models\User::USER_SUPER_ADMIN, \common\models\User::USER_ADMIN]);

$disabled = !$is_admin && $model->userPreferredDocumentPrivilege($user, false, true, false, \common\models\Documents::file_deny) != common\models\Documents::file_alter;

$desc = $disabled ? '' : "<small style='font-weight: normal'><i> - sentence case e.g. Staff in the finance department</i></small>";

?>

<div>
    <?php $form = ActiveForm::begin(['id' => 'form-documents', 'enableAjaxValidation' => true]); ?>

    <?= Html::activeHiddenInput($model, 'id') ?>

    <?= $form->field($model, 'description', ['addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-align-justify"></i>']]])->textarea(['rows' => 10, 'disabled' => $disabled, 'style' => 'text-align: justify; resize: none'])->label("Document Description$desc") ?>

    <?php ActiveForm::end(); ?>
</div>