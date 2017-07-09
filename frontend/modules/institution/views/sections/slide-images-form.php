<?php
/* @var $this yii\web\View */
/* @var $model common\models\SlideImages */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use common\models\SlideImages;
?>

<?php $form = ActiveForm::begin(['id' => 'form-slide-images', 'enableAjaxValidation' => true, 'validationUrl' => ['update-slide-image'], 'options' => ['enctype' => 'multipart/form-data'], 'fieldConfig' => ['options' => ['class' => 'form-group-sm']]]); ?>

<?= Html::activeHiddenInput($model, 'id') ?>

<?= Html::activeHiddenInput($model, 'active') ?>

<?= Html::activeHiddenInput($model, 'name_visible') ?>

<?= Html::activeHiddenInput($model, 'caption_visible') ?>

<input id="slideimages-location" type="file" name="SlideImages[location]" onchange="previewSlideImage(this)" style="display: none">

<?php $vsbl = $model->name_visible == SlideImages::name_visible ? 'glyphicon-eye-open' : 'glyphicon-eye-close' ?>

<?= $form->field($model, 'name', ['addon' => ['append' => ['content' => "<i class='glyphicon $vsbl' onclick='toggleImageNameVisible($(this))' style='cursor: pointer'></i>"]]])->textInput()->label('<small>Name Of Image</small>') ?>

<?= $form->field($model, 'url_to')->textInput()->label('<small>Hyperlink</small>') ?>

<?php $vsbl = $model->caption_visible == SlideImages::caption_visible ? 'glyphicon-eye-open' : 'glyphicon-eye-close' ?>

<?= $form->field($model, 'caption', ['addon' => ['append' => ['content' => "<i class='glyphicon $vsbl' onclick='toggleImageCaptionVisible($(this))' style='cursor: pointer'></i>"]]])->textarea(['rows' => 2, 'style' => 'resize: none'])->label('<small>Caption</small>') ?>

<?= $form->field($model, 'location', ['template' => '{error}'])->fileInput() ?>

<?php ActiveForm::end(); ?>

<style
    onload="

    <?php if (is_file($model->imageLocation())): ?>
                $('#img-chg-pic').attr('src', '<?= $model->imageLocationUrl() ?>').attr('width', $('#img-chg-pic-pn').parent().width() + 'px');
                
                fitSlideImage();
    <?php else: ?>
                $('#img-chg-pic-pn').hide();
                $('#img-chg').show();
    <?php endif; ?>
        
        imageActiveButtonChecked('<?= $model->active == SlideImages::active ?>');
        
            $(this).remove();
    "
></style>