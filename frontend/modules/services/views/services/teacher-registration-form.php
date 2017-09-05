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
/* @var $teachers common\models\Teachers */
/* @var $model common\models\Teachers */
/* @var $level string */
/* @var $auth_key string */
/* @var $sync boolean */
/* @var $clientCreateNew boolean|string */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form" style="height: 100%; overflow: hidden">

    <div class="rgstr-tchr-lst">
        <table class="table-striped">

            <?php foreach ($teachers as $i => $teacher): ?>

                <tr class="kasa-pointa" onclick="loadTeacherRegistration('<?= $teacher->id ?>')">
                    <td><b><?= $i + 1 ?>.</b></td>
                    <td class="td-left td-pdg-lft"><b><?= "$teacher->fname $teacher->mname $teacher->lname" ?></b></td>
                </tr>

                <?php $teacher->id == $model->id ? $isPostedHere = true : '' ?>

            <?php endforeach; ?>

        </table>
    </div>

    <div class="rgstr-tchr-srch-fm">

        <div class="rgstr-tchr-srch">
            <div class="input-group pull-right" style="width: 45%">
                <span class="input-group-btn">
                    <button class="btn btn-primary" onclick="toggleTeacherSearchBy()">
                        <span id="srch-by-txt"><?= $searchBy = empty($searchBy) ? Teachers::byID : $searchBy ?></span> <span class="caret"></span>
                    </button>
                </span>

                <input class="form-control td-center" id="ticha-id" type="text"  minlength="6" maxlength="8" value="<?= empty($searchByVal) ? '' : $searchByVal ?>" step="1" placeholder="<?= $searchBy ?>"/>

                <span class="input-group-btn">
                    <button class="btn btn-primary" onclick="loadTeacherByIDorTSCNo($('#ticha-id').attr('placeholder'), $('#ticha-id').val())">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </span>
            </div>
        </div>

        <div class="rgstr-tchr-fm">

            <?php $form = ActiveForm::begin(['id' => 'form-teacher-registration', 'action' => ['register-teacher'], 'enableAjaxValidation' => true]); ?>

            <input type="hidden" name="auth_key" value="<?= $auth_key ?>" />

            <?= Html::activeHiddenInput($model, 'id') ?>

            <?php $disabled = !$model->isNewRecord && empty($isPostedHere) ?>

            <table>
                <tr>
                    <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'fname')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                    <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'mname')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                    <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'lname')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                </tr>

                <tr>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'id_no')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'tsc_no')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                </tr>

                <tr>
                    <td class="td-pdg-rgt-lft">
                        <?=
                        $form->field($model, 'dob')->widget(DatePicker::className(), [
                            'options' => ['placeholder' => 'yyyy-mm-dd', 'disabled' => $disabled],
                            'type' => DatePicker::TYPE_INPUT,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                                ]
                        );
                        ?>
                    </td>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'gender')->dropDownList(Teachers::genders(), ['prompt' => '-- Gender --', 'disabled' => $disabled]) ?></td>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'email')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'subject_one')->dropDownList(StaticMethods::subjectsForDropDown($level, []), ['prompt' => '-- Subject One --', 'disabled' => $disabled, 'onchange' => "dynamicServerTeacherSubjects($(this).val(), $('#teachers-subject_two').val(), $('#teachers-subject_two'))"]) ?></td>
                    <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'subject_two')->dropDownList(StaticMethods::subjectsForDropDown($level, [$model->subject_one]), ['prompt' => '-- Subject Two --', 'disabled' => $disabled]) ?></td>
                </tr>

                <tr>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'postal_no')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'postal_code')->dropDownList(StaticMethods::modelsToArray(PostalCodes::allCodes(), 'id', 'town', false), ['prompt' => '-- Select Town --', 'disabled' => $disabled]) ?></td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'county')->dropDownList(StaticMethods::modelsToArray(Counties::allCounties(), 'id', 'name', false), ['prompt' => '-- Select County --', 'disabled' => $disabled, 'onchange' => "dynamicConstituencies($(this).val(), $('#teachers-constituency').val(), $('#teachers-constituency'), 'dynamic-server-constituencies')"]) ?></td>
                    <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'constituency')->dropDownList(StaticMethods::modelsToArray(Constituencies::constituenciesForCounty($model->county), 'id', 'name', false), ['prompt' => '-- Select Constituency --', 'disabled' => $disabled, 'onchange' => "dynamicWards($(this).val(), $('#teachers-ward').val(), $('#teachers-ward'), 'dynamic-server-wards')"]) ?></td>
                    <td class="td-pdg-rgt-lft" style="width: 33.333%"><?= $form->field($model, 'ward')->dropDownList(StaticMethods::modelsToArray(Wards::wardsForConstituency($model->constituency), 'id', 'name', false), ['prompt' => '-- Select Ward --', 'disabled' => $disabled]) ?></td>
                </tr>

                <tr>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'location')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'sub_location')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                    <td class="td-pdg-rgt-lft"><?= $form->field($model, 'village')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?></td>
                </tr>
            </table>

            <?php if (!$disabled && $sync): ?>
                <style onload=
                       "
                                   commitTeacherRegistration('<?= $model->fname ?>', '<?= $model->mname ?>', '<?= $model->lname ?>', '<?= $model->dob ?>', '<?= $model->gender ?>', '<?= $model->id_no ?>', '<?= $model->tsc_no ?>', '<?= $model->phone ?>', '<?= $model->email ?>', '<?= $model->subject_one ?>', '<?= $model->subject_two ?>', '<?= $model->postal_no ?>', '<?= $model->postal_code ?>', '<?= $model->county ?>', '<?= $model->constituency ?>', '<?= $model->ward ?>', '<?= $model->location ?>', '<?= $model->sub_location ?>', '<?= $model->village ?>', '<?= $model->created_at ?>', '<?= $clientCreateNew ? $clientCreateNew : 'null' ?>');

                       <?php if ($clientCreateNew): ?>

                                       commitTeacherRegistration('<?= $model->fname ?>', '<?= $model->mname ?>', '<?= $model->lname ?>', '<?= $model->dob ?>', '<?= $model->gender ?>', '<?= $model->id_no ?>', '<?= $model->tsc_no ?>', '<?= $model->phone ?>', '<?= $model->email ?>', '<?= $model->subject_one ?>', '<?= $model->subject_two ?>', '<?= $model->postal_no ?>', '<?= $model->postal_code ?>', '<?= $model->county ?>', '<?= $model->constituency ?>', '<?= $model->ward ?>', '<?= $model->location ?>', '<?= $model->sub_location ?>', '<?= $model->village ?>', '<?= $model->created_at ?>', null);

                       <?php endif; ?>

                                   $(this).remove();
                       "
                ></style>
            <?php endif; ?>

            <?php ActiveForm::end(); ?>
        </div>

        <div style="height: 6%; padding-top: 5px">
            <?php if (!$disabled): ?>
                <div class="btn btn-success pull-left" onclick="pushTeacherRegistration()">Save</div>
            <?php endif; ?>

            <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
        </div>

    </div>

</div>

<script>
    function toggleTeacherSearchBy() {
        $('#srch-by-txt').text(txt = $('#srch-by-txt').text() === '<?= Teachers::byID ?>' ? '<?= Teachers::byTSC ?>' : '<?= Teachers::byID ?>');

        $('#ticha-id').attr('placeholder', txt);
    }
</script>