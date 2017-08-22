<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\SchoolRegistrations;
use common\models\SchemesOfWork;
use common\models\StaticMethods;
use common\models\Constituencies;
use common\models\Wards;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ServicesController implements the CRUD actions for SchemesOfWork model.
 */
class ServicesController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'register-school', 'receive-schemes-of-work', 'dynamic-constituencies', 'dynamic-wards'
                ],
                'rules' => [
                    [
                        'actions' => ['register-school', 'receive-schemes-of-work', 'dynamic-constituencies', 'dynamic-wards'],
                        'allow' => (empty($_POST['auth_key']) && $this->isAnOpenAction()) || $this->isAuthenticRequest(),
                        'roles' => ['*'],
                        'verbs' => ['post']
                    ]
                ],
            ],
        ];
    }
    
    /**
     * 
     * @return boolean true - action can be run without verifying user identity
     */
    public function isAnOpenAction() {
        return in_array($this->action->id, ['register-school', 'dynamic-constituencies', 'dynamic-wards']);
    }
    
    /**
     * 
     * @return boolean true - request has been duly authenticated
     */
    public function isAuthenticRequest() {
        return is_object($registration = SchoolRegistrations::byAuthKey($_POST['auth_key'])) && $registration->verifyRequestIP();
    }

    /**
     * 
     * @param string $action action name
     * @return boolean true - action should continue to run
     */
    public function beforeAction($action) {
        $this->isAnOpenAction() || in_array($this->action->id, ['receive-schemes-of-work']) ? $this->enableCsrfValidation = false : '';

        return parent::beforeAction($action);
    }

    public function actionRegisterSchool() {

        $model = SchoolRegistrations::schoolToLoad(empty($_POST['SchoolRegistrations']['id']) ? '' : $_POST['SchoolRegistrations']['id'], empty($_POST['auth_key']) ? '' : $_POST['auth_key'], empty($_POST['SchoolRegistrations']['level']) ? '' : $_POST['SchoolRegistrations']['level'], empty($_POST['SchoolRegistrations']['code']) ? '' : $_POST['SchoolRegistrations']['code'], empty($_POST['SchoolRegistrations']['name']) ? '' : $_POST['SchoolRegistrations']['name'], empty($_POST['SchoolRegistrations']['created_by']) ? '' : $_POST['SchoolRegistrations']['created_by']);

        $model->load(Yii::$app->request->post());

        if (isset($_POST['SchoolRegistrations']['name'])) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $wasNew = $model->isNewRecord;

            $model->modelSave();

            $auth = $wasNew && !$model->isNewRecord;
        }

        return $this->renderAjax('school-registration-form', ['model' => $model, 'auth' => !empty($auth)]);
    }

    /**
     * receive documents sent from clients
     */
    public function actionReceiveSchemesOfWork() {

        $model = SchemesOfWork::schemeToLoad(empty($_POST['SchemesOfWork']['id']) ? '' : $_POST['SchemesOfWork']['id'], empty($_POST['SchemesOfWork']['school']) ? '' : $_POST['SchemesOfWork']['school'], empty($_POST['SchemesOfWork']['year']) ? '' : $_POST['SchemesOfWork']['year'], empty($_POST['SchemesOfWork']['term']) ? '' : $_POST['SchemesOfWork']['term'], empty($_POST['SchemesOfWork']['class']) ? '' : $_POST['SchemesOfWork']['class'], empty($_POST['SchemesOfWork']['stream']) ? '' : $_POST['SchemesOfWork']['stream'], empty($_POST['SchemesOfWork']['subject']) ? '' : $_POST['SchemesOfWork']['subject']);

        $model->load(Yii::$app->request->post());

        if (isset($_POST['SchemesOfWork']['subject'])) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            if ($instance = UploadedFile::getInstance($model, 'location')) {
                StaticMethods::saveUploadedFile($model, 'location', $instance, StaticMethods::uploadsFolder(), '', StaticMethods::stripNonNumeric(StaticMethods::now()));

                !$model->hasErrors('location') && $model->modelSave();

                $model->hasErrors() ? $model->modelDelete() : '';

                $model->modelSave();
            }
        }

        return $this->renderAjax('sceheme-of-work-form', ['model' => $model]);
    }

    /**
     * load dynamic constituencies
     */
    public function actionDynamicConstituencies() {
        StaticMethods::populateDropDown(StaticMethods::modelsToArray(Constituencies::constituenciesForCounty($_POST['county']), 'id', 'name'), 'Select Constituency', $_POST['constituency']);
    }

    /**
     * load dynamic wards
     */
    public function actionDynamicWards() {
        StaticMethods::populateDropDown(StaticMethods::modelsToArray(Wards::wardsForConstituency($_POST['constituency']), 'id', 'name'), 'Select Ward', $_POST['ward']);
    }

}
