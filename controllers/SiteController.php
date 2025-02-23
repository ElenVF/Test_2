<?php

namespace app\controllers;

use Yii;
use yii\bootstrap5\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\History;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
    public function actionIndex()
    {

        return $this->render('index', ['history' => History::find()->all()]);
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }



    public function actionTest()
    {
        $model = new History();
        
        if ($model->load(Yii::$app->request->post())) {
            $result = $this->checkStr($model);
       
            if ($model->save()) {
            return $result['message'];
            }
        }
        return $this->render('test', [
            'model' => $model,
        ]);
    }

    public function languageDetection($name)
    {
        $enCount =  preg_match_all('/[A-Za-z]/u', $name);
        $rusCount =  preg_match_all('/[А-ЯЁа-яё]/u', $name);
        if ($rusCount >= $enCount) {
            return 'Русский';
        } else {
            return 'Английский';
        }
    }

    public function errorDetection($name, $lang, &$model)
    {
        if ($lang == 'Русский') {
            preg_match_all('/[A-Za-z]/u', $name, $matches);
        } else {
            preg_match_all('/[А-ЯЁа-яё]/u', $name, $matches);
        }
        if (!empty($matches[0])) {
            $errors = array_unique($matches[0]);
            $replacements = [];
            foreach ($errors as $error) {
                $replacements[$error] = '<span style="color: red; font-weight: bold;">' . $error . '</span>';
            }
            $name = strtr($name, $replacements);
            $errorList = implode(', ', $errors);
            $model->list_error = implode(', ', $errors);
            return '<br>Найдены ошибки: ' . $errorList . '<br>Введенный текст: ' . $name;
        } else {
            return 'Ошибок не найдено';
        }
    }



    public function actionTwo()
    {
        $result = [];
        if (Yii::$app->request->isPost) {
            $model = new History();
            $model->text = Yii::$app->request->post('text');
            if ($model->text) {
                $result = $this->checkStr($model);
            }
        }
        return $this->asJson($result);
    }

    public function checkStr(History &$model) :array {
        $lang = $this->languageDetection($model->text);
        $model->lang = $lang;
        $matches = $this->errorDetection($model->text, $lang, $model);
        $success = false;
        if ($matches == 'Ошибок не найдено') {
            $success = true;
        }
        return [
            'success' => $success,
            'message' => 'Язык, на котором был введен текст: ' . $lang . '.  ' . $matches
        ];
    }
    }
    
     
    

