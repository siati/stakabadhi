<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\SchoolRegistrations;
use common\models\Teachers;
use common\models\Classes;
use common\models\Subjects;
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
                    'register-school', 'school-classes', 'school-subjects', 'register-teacher', 'teacher-by-id-or-tsc-no', 'receive-schemes-of-work', 'dynamic-teacher-subjects', 'dynamic-streams', 'dynamic-subjects', 'dynamic-constituencies', 'dynamic-wards'
                ],
                'rules' => [
                    [
                        'actions' => ['register-school', 'school-classes', 'school-subjects', 'register-teacher', 'teacher-by-id-or-tsc-no', 'receive-schemes-of-work', 'dynamic-teacher-subjects', 'dynamic-streams', 'dynamic-subjects', 'dynamic-constituencies', 'dynamic-wards'],
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
     * @return boolean true - action can be run without verifying the requesting user
     */
    public function isAnOpenAction() {
        return in_array($this->action->id, ['register-school', 'dynamic-constituencies', 'dynamic-wards']);
    }

    /**
     * 
     * @return boolean true - action can be run on verifying the requesting user
     */
    public function isASecureAction() {
        return in_array($this->action->id, ['school-classes', 'school-subjects', 'register-teacher', 'teacher-by-id-or-tsc-no', 'receive-schemes-of-work', 'dynamic-teacher-subjects', 'dynamic-streams', 'dynamic-subjects']);
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
        if (Yii::$app->request->isAjax)
            return parent::beforeAction($action);

        $this->isAnOpenAction() || $this->isASecureAction() ? $this->enableCsrfValidation = false : '';

        return parent::beforeAction($action);
    }

    /**
     * 
     * load interface to and receive registration details from clients
     */
    public function actionRegisterSchool() {

        $model = SchoolRegistrations::schoolToLoad(empty($_POST['SchoolRegistrations']['id']) ? '' : $_POST['SchoolRegistrations']['id'], empty($_POST['auth_key']) ? '' : $_POST['auth_key'], empty($_POST['SchoolRegistrations']['level']) ? '' : $_POST['SchoolRegistrations']['level'], empty($_POST['SchoolRegistrations']['code']) ? '' : $_POST['SchoolRegistrations']['code'], empty($_POST['SchoolRegistrations']['name']) ? '' : $_POST['SchoolRegistrations']['name'], empty($_POST['SchoolRegistrations']['created_by']) ? '' : $_POST['SchoolRegistrations']['created_by']);

        if (isset($_POST['SchoolRegistrations']['name']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $wasNew = $model->isNewRecord;

            $model->modelSave();

            $auth = $wasNew && !$model->isNewRecord;
        }

        return $this->renderAjax('school-registration-form', ['model' => $model, 'auth' => !empty($auth)]);
    }

    /**
     * load interface to and receive classes from clients
     */
    public function actionSchoolClasses() {

        $school = SchoolRegistrations::byAuthKey($_POST['auth_key']);

        if (empty($_POST['Classes']))
            $models = Classes::forSchool($school->id, null);
        else {

            foreach ($_POST['Classes'] as $id => $post)
                $models[$id] = Classes::classToLoad($id, $school->id, $school->level, empty($post['class']) ? '' : $post['class'], empty($post['stream']) ? '' : $post['stream']);

            $ajaxes = [];

            if (Classes::loadMultiple($models, Yii::$app->request->post()))
                foreach ($models as $id => $model)
                    !isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0) ?
                                    ($ajaxes[$id] = is_array($ajax) ? $ajax : []) :
                                    (($model->modelSave() ? $saved[] = $id : $notLoadNew = true));

            if (!empty($ajaxes))
                return is_array($ajax) ? $ajax : [];
        }

        empty($notLoadNew) ? array_push($models, Classes::classToLoad(null, $school->id, $school->level, null, null)) : '';

        return $this->renderAjax('school-classes-form', ['models' => $models, 'auth_key' => $school->auth_key, 'saved' => empty($saved) ? [] : $saved]);
    }

    /**
     * load interface to and receive subjects from clients
     */
    public function actionSchoolSubjects() {

        $school = SchoolRegistrations::byAuthKey($_POST['auth_key']);

        $models = Subjects::subjectsToLoad($school->id, $school->level, Subjects::active);

        if (!empty($_POST['Subjects']['subject'])) {
            foreach ($models as $model)
                if ($model->class == $_POST['Subjects']['class'] && $model->subject == $_POST['Subjects']['subject'])
                    if ($model->load(Yii::$app->request->post()) && $model->modelSave())
                        echo $model->active;

            Yii::$app->end();
        }

        return $this->renderAjax('school-subjects-form', ['models' => $models]);
    }

    /**
     * load teacher onto view by ID. No. or TSC No.
     */
    public function actionTeacherByIdOrTscNo() {
        $teacher = $_POST['nm'] == Teachers::byID ? (Teachers::byIDNo($_POST['val'])) : ($_POST['nm'] == Teachers::byTSC ? Teachers::byTSCNo($_POST['val']) : '');

        isset($teacher->id) ? $_POST['Teachers']['id'] = $teacher->id : '';

        return $this->actionRegisterTeacher();
    }

    /**
     * 
     * load interface to and receive teacher registration details from clients
     */
    public function actionRegisterTeacher() {

        $school = SchoolRegistrations::byAuthKey($_POST['auth_key']);

        $model = Teachers::teacherToLoad(empty($_POST['Teachers']['id']) ? '' : $_POST['Teachers']['id']);

        if (isset($_POST['Teachers']['tsc_no']) && $model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $model->isNewRecord ? $model->author_school = $school->id : $model->updater_school = $school->id;

            ($sync = $model->modelSave()) && ($clientCreateNew = is_object($posting = $model->teacherIsCurrentlyPostedInThisSchool($school->id)) ? $posting->teacherMovedToAnotherSchool() : false);
        }

        return $this->renderAjax('teacher-registration-form', [
                    'model' => $model,
                    'teachers' => Teachers::currentTeachersInSchool($school->id),
                    'level' => $school->level,
                    'auth_key' => $school->auth_key,
                    'sync' => !empty($sync),
                    'clientCreateNew' => empty($clientCreateNew) ? false : $clientCreateNew,
                    'searchBy' => empty($_POST['nm']) ?  Teachers::byID : $_POST['nm'],
                    'searchByVal' => empty($_POST['val']) ?  '' : $_POST['val']
                        ]
        );
    }

    /**
     * render interface to and receive documents sent from clients
     */
    public function actionReceiveSchemesOfWork() {

        $school = SchoolRegistrations::byAuthKey($_POST['auth_key']);

        $model = SchemesOfWork::schemeToLoad(empty($_POST['SchemesOfWork']['id']) ? '' : $_POST['SchemesOfWork']['id'], empty($_POST['SchemesOfWork']['school']) ? '' : $_POST['SchemesOfWork']['school'], empty($_POST['SchemesOfWork']['year']) ? '' : $_POST['SchemesOfWork']['year'], empty($_POST['SchemesOfWork']['term']) ? '' : $_POST['SchemesOfWork']['term'], empty($_POST['SchemesOfWork']['class']) ? '' : $_POST['SchemesOfWork']['class'], empty($_POST['SchemesOfWork']['stream']) ? '' : $_POST['SchemesOfWork']['stream'], empty($_POST['SchemesOfWork']['subject']) ? '' : $_POST['SchemesOfWork']['subject']);

        if ($model->load(Yii::$app->request->post()) && isset($_POST['SchemesOfWork']['subject'])) {

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            if ($instance = UploadedFile::getInstance($model, 'location')) {
                StaticMethods::saveUploadedFile($model, 'location', $instance, StaticMethods::uploadsFolder(), '', StaticMethods::stripNonNumeric(StaticMethods::now()));

                !$model->hasErrors('location') && $model->modelSave();

                $model->hasErrors() ? $model->modelDelete() : '';

                $model->modelSave();
            }
        }

        return $this->renderAjax('scheme-of-work-form', ['model' => $model, 'auth_key' => $school->auth_key, 'level' => $school->level]);
    }

    /**
     * load dynamic subjects
     */
    public function actionDynamicTeacherSubjects() {
        $school = SchoolRegistrations::byAuthKey($_POST['auth_key']);

        StaticMethods::populateDropDown(StaticMethods::subjectsForDropDown($school->level, [$_POST['subject1']]), 'Subject Two', $_POST['subject2']);
    }

    /**
     * load dynamic streams
     */
    public function actionDynamicStreams() {
        $school = SchoolRegistrations::byAuthKey($_POST['auth_key']);

        StaticMethods::populateDropDown(StaticMethods::modelsToArray(Classes::forSchoolLevelAndClass($school->id, $school->level, $_POST['class'], $_POST['active']), 'id', 'name', false), null, $_POST['stream']);
    }

    /**
     * load dynamic subjects
     */
    public function actionDynamicSubjects() {
        $school = SchoolRegistrations::byAuthKey($_POST['auth_key']);

        StaticMethods::populateDropDown(StaticMethods::modelsToArray(Subjects::forSchoolLevelDeptAndClass($school->id, $school->level, null, $_POST['class'], $_POST['active']), 'id', 'name', true), null, $_POST['subject']);
    }

    /**
     * load dynamic constituencies
     */
    public function actionDynamicConstituencies() {
        StaticMethods::populateDropDown(StaticMethods::modelsToArray(Constituencies::constituenciesForCounty($_POST['county']), 'id', 'name', false), 'Select Constituency', $_POST['constituency']);
    }

    /**
     * load dynamic wards
     */
    public function actionDynamicWards() {
        StaticMethods::populateDropDown(StaticMethods::modelsToArray(Wards::wardsForConstituency($_POST['constituency']), 'id', 'name', false), 'Select Ward', $_POST['ward']);
    }

}
