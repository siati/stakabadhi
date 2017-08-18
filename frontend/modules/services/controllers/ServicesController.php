<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\SchemesOfWork;
use common\models\StaticMethods;
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
                    'receive-schemes-of-work'
                ],
                'rules' => [
                    [
                        'actions' => ['receive-schemes-of-work'],
                        'allow' => true,
                        'roles' => ['*'],
                        'verbs' => ['post']
                    ]
                ],
            ],
        ];
    }

    /**
     * 
     * @param string $action action name
     * @return boolean true - action should continue to run
     */
    public function beforeAction($action) {
        in_array($this->action->id, ['receive-schemes-of-work']) ? $this->enableCsrfValidation = false : '';
        return parent::beforeAction($action);
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

}
