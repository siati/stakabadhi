<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\Teachers;
use common\models\StaticMethods;
use common\models\Counties;
use common\models\Constituencies;
use common\models\Wards;
use common\models\PostalCodes;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Teachers */
/* @var $level string */
/* @var $auth_key string */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form" style="height: 90%; overflow-x: hidden">

    <?php $form = ActiveForm::begin(['id' => 'form-teacher-registration', 'enableAjaxValidation' => true]); ?>

    <input type="hidden" name="auth_key" value="<?= $auth_key ?>" />

    <?= Html::activeHiddenInput($model, 'id') ?>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?></td>
        </tr>

        <tr>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'id_no')->textInput(['maxlength' => true]) ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'tsc_no')->textInput(['maxlength' => true]) ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?></td>
        </tr>

        <tr>
            <td class="td-pdg-rgt-lft">
                <?=
                $form->field($model, 'dob')->widget(DatePicker::className(), [
                    'options' => ['placeholder' => 'yyyy-mm-dd'],
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                        ]
                );
                ?>
            </td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'gender')->dropDownList(Teachers::genders(), ['prompt' => '-- Gender --']) ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'subject_one')->dropDownList(StaticMethods::subjectsForDropDown($level, []), ['prompt' => '-- Subject One --', 'onchange' => "dynamicServerTeacherSubjects($(this).val(), $('#teachers-subject_two').val(), $('#teachers-subject_two'))"]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'subject_two')->dropDownList(StaticMethods::subjectsForDropDown($level, [$model->subject_one]), ['prompt' => '-- Subject Two --']) ?></td>
        </tr>

        <tr>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'postal_no')->textInput(['maxlength' => true]) ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'postal_code')->dropDownList(StaticMethods::modelsToArray(PostalCodes::allCodes(), 'id', 'town', false), ['prompt' => '-- Select Town --']) ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'county')->dropDownList(StaticMethods::modelsToArray(Counties::allCounties(), 'id', 'name', false), ['prompt' => '-- Select County --', 'onchange' => "dynamicConstituencies($(this).val(), $('#teachers-constituency').val(), $('#teachers-constituency'), 'dynamic-server-constituencies')"]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'constituency')->dropDownList(StaticMethods::modelsToArray(Constituencies::constituenciesForCounty($model->county), 'id', 'name', false), ['prompt' => '-- Select Constituency --', 'onchange' => "dynamicWards($(this).val(), $('#teachers-ward').val(), $('#teachers-ward'), 'dynamic-server-wards')"]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'ward')->dropDownList(StaticMethods::modelsToArray(Wards::wardsForConstituency($model->constituency), 'id', 'name', false), ['prompt' => '-- Select Ward --']) ?></td>
        </tr>

        <tr>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'sub_location')->textInput(['maxlength' => true]) ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'village')->textInput(['maxlength' => true]) ?></td>
        </tr>
    </table>

    <?php if ($sync): ?>
        <style onload=
               "
                       commitTeacherRegistration('<?= $model->fname ?>', '<?= $model->mname ?>', '<?= $model->lname ?>', '<?= $model->dob ?>', '<?= $model->gender ?>', '<?= $model->id_no ?>', '<?= $model->tsc_no ?>', '<?= $model->phone ?>', '<?= $model->email ?>', '<?= $model->subject_one ?>', '<?= $model->subject_two ?>', '<?= $model->postal_no ?>', '<?= $model->postal_code ?>', '<?= $model->county ?>', '<?= $model->constituency ?>', '<?= $model->ward ?>', '<?= $model->location ?>', '<?= $model->sub_location ?>', '<?= $model->village ?>', '<?= $model->created_at ?>', null);
                       $(this).remove();
               "
        ></style>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 10%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="pushTeacherRegistration()">Save</div>

    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>