<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\StaticMethods;
use common\models\Counties;
use common\models\Constituencies;
use common\models\Wards;
use common\models\PostalCodes;

/* @var $this yii\web\View */
/* @var $model common\models\SchoolRegistrations */
/* @var $auth boolean */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form" style="height: 90%; overflow-x: hidden">

    <?php $form = ActiveForm::begin(['id' => 'form-school-registration', 'enableAjaxValidation' => true]); ?>

    <?= Html::activeHiddenInput($model, 'id') ?>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'name')->textInput() ?></td>
            <td class="td-pdg-rgt-lft" style="width: 25%"><?= $form->field($model, 'code')->textInput() ?></td>
            <td class="td-pdg-rgt-lft" style="width: 25%"><?= $form->field($model, 'level')->dropDownList(StaticMethods::schoolLevels()) ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 40%"><?= $form->field($model, 'phone')->textInput() ?></td>
            <td class="td-pdg-rgt-lft" style="width: 60%"><?= $form->field($model, 'email')->textInput() ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 40%"><?= $form->field($model, 'postal_no')->textInput() ?></td>
            <td class="td-pdg-rgt-lft" style="width: 60%"><?= $form->field($model, 'postal_town')->dropDownList(StaticMethods::modelsToArray(PostalCodes::allCodes(), 'id', 'town', false), ['prompt' => '-- Select Town --']) ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'county')->dropDownList(StaticMethods::modelsToArray(Counties::allCounties(), 'id', 'name', false), ['prompt' => '-- Select County --', 'onchange' => "dynamicConstituencies($(this).val(), $('#schoolregistrations-constituency').val(), $('#schoolregistrations-constituency'), 'dynamic-server-constituencies')"]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'constituency')->dropDownList(StaticMethods::modelsToArray(Constituencies::constituenciesForCounty($model->county), 'id', 'name', false), ['prompt' => '-- Select Constituency --', 'onchange' => "dynamicWards($(this).val(), $('#schoolregistrations-ward').val(), $('#schoolregistrations-ward'), 'dynamic-server-wards')"]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'ward')->dropDownList(StaticMethods::modelsToArray(Wards::wardsForConstituency($model->constituency), 'id', 'name', false), ['prompt' => '-- Select Ward --']) ?></td>
        </tr>
    </table>

    <?php ActiveForm::end(); ?>

</div>

<?php if ($auth): ?>
    <style onload="commitRegistration('<?= $model->auth_key ?>'); $(this).remove();"></style>
<?php endif; ?>

<div style="height: 10%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="pushRegistration()">Save</div>

    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>