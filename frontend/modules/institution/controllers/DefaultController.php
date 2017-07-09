<?php

namespace frontend\modules\institution\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Documents;

/**
 * Default controller for the `institution` module
 */
class DefaultController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => !Yii::$app->user->isGuest,
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        
        Documents::launchDirectories();
        
        return
                $this->render('index', [
                    'navigation' => $this->directoryNavigationTree($level = Documents::min_root_document_level, $status = Documents::FILE_STATUS_AVAILABLE, $location = Documents::subRootLocation($status)),
                    'files_and_folders' => $this->renderPartial('../sections/directory-content-pane', ['folders' => null, 'files' => null]),
                    'properties' => $this->renderPartial('../sections/document-properties', ['propertyDetails' => $this->documentProperties($location, $status, $level)]),
                    'privileges' => $this->renderPartial('../sections/document-properties-privileges', [
                        'writeDocuments' => $this->documentsUserHasRightTo($user = Yii::$app->user->identity->id, Documents::file_alter),
                        'updateDocuments' => $this->openedForUpdate($user)
                            ]
                    ),
                    'branding' => $this->renderPartial('../sections/document-properties-branding', ['items' => $this->slideImages()])
                        ]
        );
    }

}
