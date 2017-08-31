<?php

namespace frontend\modules\files\controllers;

use yii\web\Controller;
use common\models\StoreLevels;
use common\models\StaticMethods;

/**
 * Default controller for the `files` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {

        StoreLevels::defaultLevels();

        return $this->render('index', [
                    'branding' => $this->renderPartial('../../../../modules/institution/views/sections/document-properties-branding', ['items' => $this->slideImages()]),
                    'storeLevels' => $this->renderPartial('../files/store-levels', ['storeLevels' => $storeLevels = StoreLevels::allLevels()]),
                    'levelDetails' => StoreLevels::defaultLevelsOrder(),
                    'levels' => StaticMethods::modelsToArray($storeLevels, 'level', 'name', false)
                        ]
        );
    }

}
