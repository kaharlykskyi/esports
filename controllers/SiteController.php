<?php

namespace app\controllers;

use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;
use yii\helpers\Html;

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
                    'logout' => ['get'],
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
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
         }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->login()) {
                return $this->goBack('profile');
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'error' => isset($model->getErrors()['password'][0]) ? $model->getErrors()['password'][0] : ''
        ]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegisterForm();
        if($model->load(Yii::$app->request->post())) {
            if($model->register()) {
                $email = Yii::$app->user->identity->email;
                $tokin = (string)bin2hex(random_bytes(24));
                $user = $user = User::findOne(['email' => $email]);
                $user->tokin_conf = $tokin;
                if ($user->save()) {
                    $this->sendEmail($email,$tokin);
                    return $this->redirect('profile/index');
                }
            }
        }
        return $this->render('register',[
            'errors' => $model->getErrors()
        ]);
    }

    public function actionRecovery()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $email = $request->post('email');
            $result = User::emailRecovery($email);
            return $this->render('recovery', [
                'status' => $result['status'],
                'message' => $result['message']
            ]);
        }

        return $this->render('recovery',[
            'message' => null
        ]);
    }

    public function actionRecoveryCheck($token = null)
    {
        if(!$token) {
            throw new \HttpException(404 ,'Page not found');
        }

        $user = User::findOne(['restore_token' => $token]);
        if(!$user) {
            throw new \HttpException(401 ,'Wrong token');
        }

        return $this->render('change-password', [
            'token' => $token
            //'error' => isset($model->getErrors()['password'][0]) ? $model->getErrors()['password'][0] : ''
        ]);
    }

    public function actionChangePassword()
    {
        $token = Yii::$app->request->post('token');
        $password = Yii::$app->request->post('password');

        $user = User::findOne(['restore_token' => $token]);
        if(!$user) {
            return $this->redirect('/');
        }

        $user->restore_token = null;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($password);
        $user->save();

        Yii::$app->user->login($user);

        return $this->redirect('/');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('/');
    }

    public function actionConfirmation($confirmation_tokin = false, $email = false)
    {
        if ($confirmation_tokin) {
            if ($email) {
                $user = User::findOne(['tokin_conf' => $confirmation_tokin,'email' => $email]);
                if(!is_object($user)) {
                    return $this->redirect('/');
                }
                $user->is_verified = 1;
                $user->save();
                return $this->redirect('profile');
            }
       }
       return $this->redirect('/');  
    }

    private function sendEmail($email,$stringTokin)
    {
        $url = Url::toRoute(
            ['site/confirmation',
                'confirmation_tokin'=> $stringTokin,'email' => $email,
            ], true);
        $a = Html::a('<b>Follow the link to confirm your email</b>',$url);
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($email)
            ->setSubject('<p>registration</p>')
            ->setTextBody('<p>Confirmation of registration</p>')
            ->setHtmlBody($a)
            ->send();
    }
}



