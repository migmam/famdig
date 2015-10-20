<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
      // $this->layout = "main_old";

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
                    'logout' => ['post','get'],  //Quitar GET (MAM)
                    'rememberPass' => ['post','get'],  //Quitar GET (MAM)
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
        if (\Yii::$app->user->isGuest) {   //Si no está logado entonces a la pagina de login
           
             return $this->redirect('index.php?r=site/login');
        }else{
            //return $this->render('index');
            return $this->render('plantillas/axtel_inicio.tpl');
        }
    }
    
    public function actionRememberpass()
    {
        //aquí se genera token y se graba en el modelo.
        //dicho token se envía por correo.
        
      if(!Yii::$app->mailer->compose()
        ->setFrom('notreply@virtualcarecorp.com')
        ->setTo('mamartinez@somosvirtualcare.com')
        ->setSubject('Test')
        ->setHtmlBody($this->render('@app/mail/remember-pass.tpl', [
        'token' => '34343443008888']))
        ->send())
      {
          echo "falla"; exit;
      }
        
         return $this->render('plantillas/email_enviado.tpl');
        
        
        //Yii::$app->mailer->compose('greetings', [
        //'user' => Yii::$app->user->identity,
        //'advertisement' => $adContent,
        //]);
    }

    public function actionLogin()
    {
        
        if (!\Yii::$app->user->isGuest) {
           
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            return $this->goBack();
        }
        return $this->render('plantillas/axtel.tpl',['model' => $model,
        ]);
        //return $this->render('login', [
        //    'model' => $model,
        //]);
    }
    
    public function actionForgotpass()
    {
        return $this->render('forgotPass.tpl'); 
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
