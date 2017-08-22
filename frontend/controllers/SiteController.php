<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use common\models\Profiles;
use common\models\StaticMethods;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['user-management', 'profile-to-update', 'signup', 'logout', 'request-password-reset', 'request-password-reset-via-admin', 'account-status', 'user-profile'],
                'rules' => [
                    [
                        'actions' => ['user-management', 'request-password-reset-via-admin', 'reset-password-via-admin', 'profile-to-update', 'account-status', 'user-profile'],
                        'allow' => User::userHasRights(Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->profile, [User::USER_SUPER_ADMIN, User::USER_ADMIN]),
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => Yii::$app->user->isGuest,
                        'roles' => ['?'],
                        'verbs' => ['post']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => !Yii::$app->user->isGuest,
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                    [
                        'actions' => ['request-password-reset'],
                        'allow' => true,
                        'verbs' => ['post']
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 
     * @param string $action action name
     * @return boolean true - action should continue to run
     */
    public function beforeAction($action) {
        in_array($this->action->id, ['dynamic-server-constituencies', 'dynamic-server-wards']) ? $this->enableCsrfValidation = false : '';

        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 
     * @return mixed view for user management
     */
    public function actionUserManagement() {
        return $this->render('user-management', [
                    'usersList' => $this->renderPartial('users-list', ['users' => User::allUsers()]),
                    'profilesList' => $this->renderPartial('profiles-list', ['profiles' => Profiles::allProfiles()]),
                    'profileEditor' => $this->actionProfile()
        ]);
    }

    /**
     * 
     * @return mixed view for capturing profiles
     */
    public function actionProfile() {
        $model = Profiles::profileToLoad(
                        empty($_POST['Profiles']['id']) ? (empty($_POST['id']) ? '' : $_POST['id']) : ($_POST['Profiles']['id'])
                        , null //empty($_POST['Profiles']['profile']) ? (empty($_POST['profile']) ? '' : $_POST['profile']) : ($_POST['Profiles']['profile'])
        );

        if (isset($_POST['Profiles']['name']) && $model->load(Yii::$app->request->post())) {
            if (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0)
                return is_array($ajax) ? $ajax : [];

            if ($model->modelSave())
                $model = Profiles::profileToLoad(null, null);

            $model->hasErrors() ? Yii::$app->session->setFlash('error', 'Please correct the highlighted errors') : Yii::$app->session->setFlash('success', 'Profile saved successfully');
        }

        return $this->renderPartial('profile-editor', ['model' => $model]);
    }

    /**
     * 
     */
    public function actionProfileToUpdate() {
        $profile = Profiles::profileToLoad($_POST['id'], null);
        echo json_encode(['profiles-id' => $profile->id, 'profiles-profile' => $profile->profile, 'profiles-name' => $profile->name, 'profiles-status' => $profile->status, 'profiles-description' => $profile->description]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0)
                return is_array($ajax) ? $ajax : [];

            if ($model->signup())
                return $this->goHome();
        }

        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest)
            return $this->goBack();

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            if (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0)
                return is_array($ajax) ? $ajax : [];

            if ($model->login())
                return $this->goHome();
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post())) {
            if (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0)
                return is_array($ajax) ? $ajax : [];

            if ($model->validate()) {
                $model->sendEmail() ? Yii::$app->session->setFlash('success', 'Please check your email for further instructions') : Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided. You may retry');
                return $this->goHome();
            } else
                Yii::$app->session->setFlash('error', 'Please correct highlighted errors');
        }

        return $this->render('requestPasswordResetToken', ['model' => $model]);
    }

    /**
     * Admin requests password reset for user
     *
     * @return mixed
     */
    public function actionRequestPasswordResetViaAdmin() {
        $model = new PasswordResetRequestForm();

        $model->load(Yii::$app->request->post());

        echo User::profileCanUpdateOther(Yii::$app->user->identity->userProfile()->profile, is_object($profile = Profiles::returnProfile(User::userForPasswordResetRequest($model->email)->profile)) ? $profile->profile : User::NO_RIGHT_NAME) && $model->sendEmail();
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())) {

            if (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0)
                return is_array($ajax) ? $ajax : [];

            if ($model->validate())
                if ($model->resetPassword()) {
                    Yii::$app->session->setFlash('success', 'Password has been reset successfully');
                    return $this->goHome();
                } else
                    Yii::$app->session->setFlash('error', 'Password reset failed. If this error persists, please contact your system administrator');
            else
                Yii::$app->session->setFlash('error', 'Correct the highlighted errors');
        }

        return $this->render('resetPassword', ['model' => $model]);
    }

    /**
     * admin reset password for other user
     */
    public function actionResetPasswordViaAdmin() {
        $request = new PasswordResetRequestForm();

        $request->load(Yii::$app->request->post());

        if (User::profileCanUpdateOther(Yii::$app->user->identity->userProfile()->profile, is_object($profile = Profiles::returnProfile(User::userForPasswordResetRequest($request->email)->profile)) ? $profile->profile : User::NO_RIGHT_NAME) && (is_object($user = $request->userForPasswordResetRequest())))
            try {
                $reset = is_object($model = new ResetPasswordForm($user->password_reset_token)) && $model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword();
            } catch (\Exception $e) {
                
            }

        echo!empty($reset);
    }

    /**
     * change account status
     */
    public function actionAccountStatus() {
        $model = User::returnUser($_POST['User']['id']);

        $model->updateAccountStatus($_POST['User']['status']);

        echo $model->status == User::STATUS_ACTIVE ? User::STATUS_ACTIVE_NAME : User::STATUS_DELETED_NAME;
    }

    /**
     * change user profile
     */
    public function actionUserProfile() {
        $model = User::returnUser($_POST['User']['id']);

        $model->updateUserProfile($_POST['User']['profile']);

        $profile = Profiles::returnProfile($model->profile);

        echo empty($profile->profile) ? User::NO_RIGHT_NAME : $profile->profile;
    }

    /**
     * return desired constituencies from service
     */
    public function actionDynamicServerConstituencies() {
        echo StaticMethods::seekService('http://localhost/we@ss/frontend/web/services/services/dynamic-constituencies', $_POST);
    }

    /**
     * return desired wards from service
     */
    public function actionDynamicServerWards() {
        echo StaticMethods::seekService('http://localhost/we@ss/frontend/web/services/services/dynamic-wards', $_POST);
    }

}
