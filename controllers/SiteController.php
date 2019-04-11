<?php

namespace app\controllers;

use app\models\RegisterForm;
use app\models\User;
use Yii;
use app\models\Games;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\servises\FlagServis;
use yii\data\Pagination;
use app\modules\admin\models\News;
use app\models\ResultsStatisticUsers;
use app\models\servises\SearchResultsStatisticsUsers;
use app\models\servises\SerchTournaments;
use app\models\Tournaments;
use app\models\ScheduleTeams;

class SiteController extends Controller
{

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

    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $alias = Yii::$app->params['domains'];
        $game = Games::findOne(['alias' => $alias]);
        $query = News::find()->where(['state' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(), 
            'pageSize' => 6
        ]);
        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)->orderBy("created_at DESC")->all();

        $matches_qeury = ScheduleTeams::find()
            ->innerJoin('`tournaments`', '`tournaments`.`id` = `schedule_teams`.`tournament_id`')
            ->innerJoin('`games`', '`games`.`id` = `tournaments`.`game_id`');

        if (is_object($game)) {
            $matches_qeury->where(['`games`.alias' => $alias]);
        }

        $matches = $matches_qeury->orderBy(['id' => SORT_DESC])->limit(4)->all();

        if (!is_object($game)) {
            $searchModel = new SerchTournaments();
            $dataProvider = $searchModel->search($params); 
            return $this->render('home', compact('models','pages','dataProvider' ,'searchModel', 'params', 'matches'));
        }

        $searchModel = new SearchResultsStatisticsUsers();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$alias);
        
        return $this->render(
            'index',
            compact('dataProvider','searchModel','models','pages','alias','matches','params')
        );
    }

    public function actionTranslations($lang)
    {
        $cookies = Yii::$app->response->cookies;
        if(($lang != 'en-EN')&&($lang != 'fr-FR')&&($lang != 'es-ES')) {
            return $this->goBack();
        }   

        $cookies->add(new \yii\web\Cookie([
            'name' => 'language',
            'value' => $lang,
            'expire' => time() + 86400 * 365,
        ]));

        if(Yii::$app->user->returnUrl != '/') 
            return $this->goBack();
        else return Yii::$app->request->referrer ? $this
            ->redirect(Yii::$app->request->referrer) : $this->goHome();
    }

    public function actionReferal ($id)
    {
        $user = User::findOne($id);
        if (is_object($user) && Yii::$app->user->isGuest) {
            $cookies = Yii::$app->request->cookies;

            if ( !$cookies->has('refiral') ) {
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'refiral',
                    'value' => 'refiral',
                    'expire' => time() + 86400 * 365,
                ]));
               $user->addBall(9);
            }
        }
        return $this->redirect(['index']);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
         }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->login()) {
                return $this->goBack(['profile/index']);
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
            'all_flag' => FlagServis::getAllflag(),
            'errors' => $model->getErrors() ]);
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

        return $this->render('change-password', [ 'token' => $token ]);
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

    public function actionResend () {
        $user = Yii::$app->user->identity;
        $tokin = (string)bin2hex(random_bytes(24));
        $user->tokin_conf = $tokin;
        if ($user->save()) {
            $this->sendEmail($user->email,$tokin);
        }
        return $this->goBack('profile');
    }

    private function sendEmail($email,$stringTokin)
    {
        $url = Url::toRoute(
            ['site/confirmation',
                'confirmation_tokin'=> $stringTokin,'email' => $email,
            ], true);
        $a = Html::a('<b>'.Yii::t('app','Follow the link to confirm your email').'</b>',$url);
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($email)
            ->setSubject(Yii::t('app','Registration'))
            ->setTextBody('<p>'.Yii::t('app','Confirmation of registration').'</p>')
            ->setHtmlBody($a)
            ->send();
    }
}



