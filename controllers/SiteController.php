<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\UserToken;
use app\models\User;
use app\models\Page;
use app\models\search\PostSearch;
use yii\helpers\ArrayHelper;
use mdm\admin\components\UserStatus;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($category=null, $query=null)
    {
        $searchModel = new PostSearch();
        if ($category) {
            $searchModel->category_id = $category;
        }
        if ($query) {
            $searchModel->content = $query;
        }
        $dataProvider = $searchModel->search(null, true);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        Page::updateAllCounters(['count_view' => 1], ['id' => $id]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Signup new user
     * @return string
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                return $this->goHome();
            }
        }

        return $this->render('signup', [
                'model' => $model,
        ]);
    }

    /**
     * confirm Email
     * @return string
     */
    public function actionConfirmEmail($token)
    {

        if (empty($token) || !is_string($token)) {
            Yii::$app->getSession()->setFlash('error', Yii::t('yii','Confirm token cannot be blank.'));
        }
        $userToken = UserToken::findByToken($token,'confirm-email');
        if ($userToken==null) {
            Yii::$app->getSession()->setFlash('error', Yii::t('yii','Wrong confirm token.'));
        }else{
            User::updateAll(['status' => ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', UserStatus::ACTIVE)],['id'=>$userToken->user_id]);
            $userToken->deleteAll(['user_id' => $userToken->user_id]);
            Yii::$app->getSession()->setFlash('success', Yii::t('yii','Your email activated successfully.'));
        }

        return $this->render('message',['title'=>Yii::t('yii','Email Confirmation')]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    protected function findModel($id)
    {
        if (($model = Page::find()->where(['id' => $id, 'status' => 'active'])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
