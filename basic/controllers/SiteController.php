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
                    'rememberpass' => ['get'],  //Quitar GET (MAM)
                    'sendforgotpass' => ['post'],  //Quitar GET (MAM)
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
        return $this->render('recupera_pass/rememberPass.tpl', [
        'vendor_path' => Yii::getAlias('@web').'/../vendor']); 
        

    }
    
      public function actionForgotpass()
    {
  
        return $this->render('recupera_pass/forgotPass.tpl'); 

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
    
    public function actionSendforgotpass()
    {
        $email_enviado = mysql_escape_string($_POST["email"]);
        
        $usuario = \app\models\Usuarios::find()
        ->where(['email' => $email_enviado])
        ->one();
        if(empty($usuario))
        {
              return $this->render('recupera_pass/change_pass_fail.tpl', 
            ['motivo' => 'email']);
        }
        

        
        $securimage = new \Securimage();
        if ($securimage->check($_POST['captcha_code']) == false) {
           return $this->render('recupera_pass/change_pass_fail.tpl', 
            ['motivo' => 'captcha']);
        }
        
        $token = sha1(time()+$usuario->id);
        $usuario->token = $token;
        $usuario-> save();
        
        if(!Yii::$app->mailer->compose()
        ->setFrom('notreply@virtualcarecorp.com')
        ->setTo($email_enviado)
        ->setSubject('Test')
        ->setHtmlBody($this->render('@app/mail/remember-pass.tpl', [
        'token' => $token,'email'=>$_POST["email"]]))
        ->send())
        {
            return $this->render('recupera_pass/change_pass_fail.tpl', 
            ['motivo' => 'email_server',
                'home' => Yii::getAlias('@web')
            ]);
        }
        
         return $this->render('plantillas/email_enviado.tpl');
        
        
    }
    
    public function actionChangepass()
    {
        
        $usuario = \app\models\Usuarios::find()
        ->where(['email' => $_POST["email"],'token'=>$_POST["token"]])
        ->one();
        if(empty($usuario))
        {
            return $this->render('change_pass_fail.tpl', 
            ['motivo' => 'token',
                'home' => Yii::getAlias('@web')
            ]);
        }
        
        $usuario->password = sha1(mysql_escape_string( $_POST["pass1"]));
        $usuario->save();
        
        return $this->render('recupera_pass/change_pass_fail.tpl', 
            ['motivo' => 'ok',
                'home' => Yii::getAlias('@web')
            ]);
        
     
        
        
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
