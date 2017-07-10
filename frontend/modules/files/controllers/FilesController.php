<?php

namespace frontend\modules\files\controllers;

use Yii;
use common\searchModels\FilesSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\StaticMethods;
use common\models\StoreLevels;
use common\models\Stores;
use common\models\Compartments;
use common\models\SubCompartments;
use common\models\SubSubCompartments;
use common\models\Shelves;
use common\models\Drawers;
use common\models\Batches;
use common\models\Folders;
use common\models\Files;
use common\models\FilePermissions;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'section-name', 'dynamic-storages', 'the-files', 'stores', 'compartments', 'sections', 'subsections', 'shelves', 'drawers', 'batches', 'folders', 'files',
                    'move-compartments', 'move-sections', 'move-subsections', 'move-shelves', 'move-drawers', 'move-batches', 'move-folders', 'move-files', 'file-permission',
                    'delete-stores', 'delete-compartments', 'delete-sections', 'delete-subsections', 'delete-shelves', 'delete-drawers', 'delete-batches', 'delete-folders', 'delete-files', 'create', 'update', 'index', 'delete', 'view'
                ],
                'rules' => [
                    [
                        'actions' => [
                            'section-name', 'dynamic-storages', 'the-files', 'stores', 'compartments', 'sections', 'subsections', 'shelves', 'drawers', 'batches', 'folders', 'files',
                            'move-compartments', 'move-sections', 'move-subsections', 'move-shelves', 'move-drawers', 'move-batches', 'move-folders', 'move-files', 'file-permission',
                            'delete-stores', 'delete-compartments', 'delete-sections', 'delete-subsections', 'delete-shelves', 'delete-drawers', 'delete-batches', 'delete-folders', 'delete-files'
                        ],
                        'allow' => !Yii::$app->user->isGuest,
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                    [
                        'actions' => ['create', 'update', 'index', 'delete', 'view'],
                        'allow' => false,
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                ],
            ],
        ];
    }

    /**
     * rename name of store level
     */
    public function actionSectionName() {
        foreach ($_POST['StoreLevels'] as $id => $post) {
            $model = StoreLevels::levelToLoad($id, $id, $post['name'], StoreLevels::defaultLevelsOrder()[$id][1]);

            $name = $model->name;

            $model->attributes = $post;

            echo $model->modelSave() ? $model->name : $name;
        }
    }

    /**
     * populate level stores
     */
    public function actionDynamicStorages() {
        StaticMethods::populateDropDown(StaticMethods::modelsToArray(StoreLevels::defaultStoragesToLoad($_POST['level'], $_POST['id'], true), 'id', 'name'), empty($_POST['prompt']) ? '' : 'Select', $_POST['value']);
    }

    /**
     * load files onto view
     */
    public function actionTheFiles() {
        return $this->renderPartial('the-files', ['files' => Files::searchFiles(null, null, null, null, null, null, null, $_POST['folder'], true, StoreLevels::all)]);
    }

    /**
     * render interface for and capture store
     */
    public function actionStores() {
        $model = Stores::storeToLoad(empty($_POST['Stores']['id']) ? '' : $_POST['Stores']['id']);

        if (isset($_POST['Stores']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = Stores::storeToLoad(null) : '';
        }

        return $this->renderAjax('store-form', ['model' => $model]);
    }

    /**
     * render interface for and capture compartments
     */
    public function actionCompartments() {
        $model = Compartments::compartmentToLoad(empty($_POST['Compartments']['id']) ? '' : $_POST['Compartments']['id'], empty($_POST['Compartments']['store']) ? '' : $_POST['Compartments']['store']);

        if (isset($_POST['Compartments']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = Compartments::compartmentToLoad(null, $model->store) : '';
        }

        return $this->renderAjax('compartment-form', ['model' => $model]);
    }

    /**
     * render interface for and capture sub-compartments
     */
    public function actionSections() {
        $model = SubCompartments::subcompartmentToLoad(empty($_POST['SubCompartments']['id']) ? '' : $_POST['SubCompartments']['id'], empty($_POST['SubCompartments']['store']) ? '' : $_POST['SubCompartments']['store'], empty($_POST['SubCompartments']['compartment']) ? '' : $_POST['SubCompartments']['compartment']);

        if (isset($_POST['SubCompartments']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = SubCompartments::subcompartmentToLoad(null, $model->store, $model->compartment) : '';
        }

        return $this->renderAjax('sub-compartment-form', ['model' => $model]);
    }

    /**
     * render interface for and capture sub-sub-compartments
     */
    public function actionSubsections() {
        $model = SubSubCompartments::subsubcompartmentToLoad(empty($_POST['SubSubCompartments']['id']) ? '' : $_POST['SubSubCompartments']['id'], empty($_POST['SubSubCompartments']['store']) ? '' : $_POST['SubSubCompartments']['store'], empty($_POST['SubSubCompartments']['compartment']) ? '' : $_POST['SubSubCompartments']['compartment'], empty($_POST['SubSubCompartments']['sub_compartment']) ? '' : $_POST['SubSubCompartments']['sub_compartment']);

        if (isset($_POST['SubSubCompartments']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = SubSubCompartments::subsubcompartmentToLoad(null, $model->store, $model->compartment, $model->sub_compartment) : '';
        }

        return $this->renderAjax('sub-sub-compartment-form', ['model' => $model]);
    }

    /**
     * render interface for and capture shelves
     */
    public function actionShelves() {
        $model = Shelves::shelfToLoad(empty($_POST['Shelves']['id']) ? '' : $_POST['Shelves']['id'], empty($_POST['Shelves']['store']) ? '' : $_POST['Shelves']['store'], empty($_POST['Shelves']['compartment']) ? '' : $_POST['Shelves']['compartment'], empty($_POST['Shelves']['sub_compartment']) ? '' : $_POST['Shelves']['sub_compartment'], empty($_POST['Shelves']['sub_sub_compartment']) ? '' : $_POST['Shelves']['sub_sub_compartment']);

        if (isset($_POST['Shelves']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = Shelves::shelfToLoad(null, $model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment) : '';
        }

        return $this->renderAjax('shelf-form', ['model' => $model]);
    }

    /**
     * render interface for and capture drawers
     */
    public function actionDrawers() {
        $model = Drawers::drawerToLoad(empty($_POST['Drawers']['id']) ? '' : $_POST['Drawers']['id'], empty($_POST['Drawers']['store']) ? '' : $_POST['Drawers']['store'], empty($_POST['Drawers']['compartment']) ? '' : $_POST['Drawers']['compartment'], empty($_POST['Drawers']['sub_compartment']) ? '' : $_POST['Drawers']['sub_compartment'], empty($_POST['Drawers']['sub_sub_compartment']) ? '' : $_POST['Drawers']['sub_sub_compartment'], empty($_POST['Drawers']['shelf']) ? '' : $_POST['Drawers']['shelf']);

        if (isset($_POST['Drawers']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = Drawers::drawerToLoad(null, $model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment, $model->shelf) : '';
        }

        return $this->renderAjax('drawer-form', ['model' => $model]);
    }

    /**
     * render interface for and capture batches
     */
    public function actionBatches() {
        $model = Batches::batchToLoad(empty($_POST['Batches']['id']) ? '' : $_POST['Batches']['id'], empty($_POST['Batches']['store']) ? '' : $_POST['Batches']['store'], empty($_POST['Batches']['compartment']) ? '' : $_POST['Batches']['compartment'], empty($_POST['Batches']['sub_compartment']) ? '' : $_POST['Batches']['sub_compartment'], empty($_POST['Batches']['sub_sub_compartment']) ? '' : $_POST['Batches']['sub_sub_compartment'], empty($_POST['Batches']['shelf']) ? '' : $_POST['Batches']['shelf'], empty($_POST['Batches']['drawer']) ? '' : $_POST['Batches']['drawer']);

        if (isset($_POST['Batches']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = Batches::batchToLoad(null, $model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment, $model->shelf, $model->drawer) : '';
        }

        return $this->renderAjax('batch-form', ['model' => $model]);
    }

    /**
     * render interface for and capture folders
     */
    public function actionFolders() {
        $model = Folders::folderToLoad(empty($_POST['Folders']['id']) ? '' : $_POST['Folders']['id'], empty($_POST['Folders']['store']) ? '' : $_POST['Folders']['store'], empty($_POST['Folders']['compartment']) ? '' : $_POST['Folders']['compartment'], empty($_POST['Folders']['sub_compartment']) ? '' : $_POST['Folders']['sub_compartment'], empty($_POST['Folders']['sub_sub_compartment']) ? '' : $_POST['Folders']['sub_sub_compartment'], empty($_POST['Folders']['shelf']) ? '' : $_POST['Folders']['shelf'], empty($_POST['Folders']['drawer']) ? '' : $_POST['Folders']['drawer'], empty($_POST['Folders']['batch']) ? '' : $_POST['Folders']['batch']);

        if (isset($_POST['Folders']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = Folders::folderToLoad(null, $model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment, $model->shelf, $model->drawer, $model->batch) : '';
        }

        return $this->renderAjax('folder-form', ['model' => $model]);
    }

    /**
     * render interface for and capture files
     */
    public function actionFiles() {
        $model = Files::fileToLoad(empty($_POST['Files']['id']) ? '' : $_POST['Files']['id'], empty($_POST['Files']['store']) ? '' : $_POST['Files']['store'], empty($_POST['Files']['compartment']) ? '' : $_POST['Files']['compartment'], empty($_POST['Files']['sub_compartment']) ? '' : $_POST['Files']['sub_compartment'], empty($_POST['Files']['sub_sub_compartment']) ? '' : $_POST['Files']['sub_sub_compartment'], empty($_POST['Files']['shelf']) ? '' : $_POST['Files']['shelf'], empty($_POST['Files']['drawer']) ? '' : $_POST['Files']['drawer'], empty($_POST['Files']['batch']) ? '' : $_POST['Files']['batch'], empty($_POST['Files']['folder']) ? '' : $_POST['Files']['folder']);

        if (isset($_POST['Files']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $isNew = $model->isNewRecord;

            $model->modelSave() && $isNew ? $model = Files::fileToLoad(null, $model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment, $model->shelf, $model->drawer, $model->batch, $model->folder) : '';
        }

        return $this->renderAjax('file-form', ['model' => $model]);
    }

    /**
     * 
     * render interface moving compartments
     */
    public function actionMoveCompartments() {
        $model = Compartments::returnCompartment($_POST['Compartments']['id']);

        if (isset($_POST['mv']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            echo $model->moveCompartment($model->store);

            Yii::$app->end();
        }

        return $this->renderAjax('compartment-move-form', ['model' => $model]);
    }

    /**
     * 
     * render interface moving sub-compartments
     */
    public function actionMoveSections() {
        $model = SubCompartments::returnSubcompartment($_POST['SubCompartments']['id']);

        if (isset($_POST['mv']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            echo $model->moveSubcompartment($model->store, $model->compartment);

            Yii::$app->end();
        }

        return $this->renderAjax('sub-compartment-move-form', ['model' => $model]);
    }

    /**
     * 
     * render interface moving sub-sub-compartments
     */
    public function actionMoveSubsections() {
        $model = SubSubCompartments::returnSubsubcompartment($_POST['SubSubCompartments']['id']);

        if (isset($_POST['mv']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            echo $model->moveSubsubcompartment($model->store, $model->compartment, $model->sub_compartment);

            Yii::$app->end();
        }

        return $this->renderAjax('sub-sub-compartment-move-form', ['model' => $model]);
    }

    /**
     * 
     * render interface moving shelves
     */
    public function actionMoveShelves() {
        $model = Shelves::returnShelf($_POST['Shelves']['id']);

        if (isset($_POST['mv']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            echo $model->moveShelf($model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment);

            Yii::$app->end();
        }

        return $this->renderAjax('shelf-move-form', ['model' => $model]);
    }

    /**
     * 
     * render interface moving drawers
     */
    public function actionMoveDrawers() {
        $model = Drawers::returnDrawer($_POST['Drawers']['id']);

        if (isset($_POST['mv']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            echo $model->moveDrawer($model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment, $model->shelf);

            Yii::$app->end();
        }

        return $this->renderAjax('drawer-move-form', ['model' => $model]);
    }

    /**
     * 
     * render interface moving batches
     */
    public function actionMoveBatches() {
        $model = Batches::returnBatch($_POST['Batches']['id']);

        if (isset($_POST['mv']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            echo $model->moveBatch($model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment, $model->shelf, $model->drawer);

            Yii::$app->end();
        }

        return $this->renderAjax('batch-move-form', ['model' => $model]);
    }

    /**
     * 
     * render interface moving folders
     */
    public function actionMoveFolders() {
        $model = Folders::returnFolder($_POST['Folders']['id']);

        if (isset($_POST['mv']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            echo $model->moveFolder($model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment, $model->shelf, $model->drawer, $model->batch);

            Yii::$app->end();
        }

        return $this->renderAjax('folder-move-form', ['model' => $model]);
    }

    /**
     * 
     * render interface moving files
     */
    public function actionMoveFiles() {
        $model = Files::returnFile($_POST['Files']['id']);

        if (isset($_POST['mv']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            echo $model->moveFile($model->store, $model->compartment, $model->sub_compartment, $model->sub_sub_compartment, $model->shelf, $model->drawer, $model->batch, $model->folder);

            Yii::$app->end();
        }

        return $this->renderAjax('file-move-form', ['model' => $model]);
    }

    /**
     * 
     * render interface for reviewing user file rights
     */
    public function actionFilePermission() {
        $model = FilePermissions::permissionToLoad(empty($_POST['FilePermissions']['id']) ? '' : $_POST['FilePermissions']['id'], $_POST['FilePermissions']['store_level'], $_POST['FilePermissions']['store_id']);

        if (isset($_POST['user']) && isset($_POST['attribute']) && $model->load(Yii::$app->request->post())) {

            $model->theRightsTransaction($attribute = $_POST['attribute'], $user = $_POST['user']);
            
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            return [$model->userRight($user), $model->userSubjectiveRight($user)];
        }

        return $this->renderPartial('file-permissions-form', [
                    'model' => $model,
                    'users' => \common\models\User::activeUsers()
                        ]
        );
    }

    /**
     * 
     * delete stores
     */
    public function actionDeleteStores() {
        echo Stores::returnStore($_POST['Stores']['id'])->deleteStore();
    }

    /**
     * 
     * delete compartments
     */
    public function actionDeleteCompartments() {
        echo Compartments::returnCompartment($_POST['Compartments']['id'])->deleteCompartment();
    }

    /**
     * 
     * delete sub-compartments
     */
    public function actionDeleteSections() {
        echo SubCompartments::returnSubcompartment($_POST['SubCompartments']['id'])->deleteSubcompartment();
    }

    /**
     * 
     * delete sub-sub-compartments
     */
    public function actionDeleteSubsections() {
        echo SubSubCompartments::returnSubsubcompartment($_POST['SubSubCompartments']['id'])->deleteSubsubcompartment();
    }

    /**
     * 
     * delete shelves
     */
    public function actionDeleteShelves() {
        echo Shelves::returnShelf($_POST['Shelves']['id'])->deleteShelf();
    }

    /**
     * 
     * delete drawers
     */
    public function actionDeleteDrawers() {
        echo Drawers::returnDrawer($_POST['Drawers']['id'])->deleteDrawer();
    }

    /**
     * 
     * delete batches
     */
    public function actionDeleteBatches() {
        echo Batches::returnBatch($_POST['Batches']['id'])->deleteBatch();
    }

    /**
     * 
     * delete folders
     */
    public function actionDeleteFolders() {
        echo Folders::returnFolder($_POST['Folders']['id'])->deleteFolder();
    }

    /**
     * 
     * delete files
     */
    public function actionDeleteFiles() {
        echo Files::returnFile($_POST['Files']['id'])->deleteFile();
    }

    /**
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Files model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Files();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0)
                return is_array($ajax) ? $ajax : [];

            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Updates an existing Files model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0)
                return is_array($ajax) ? $ajax : [];

            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Files model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Files::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
