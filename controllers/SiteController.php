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


    
   // Метод отображает историю проверок
 
        public function actionIndex()
    {
        return $this->render('index', ['history' => History::find()->all()]);
    }
    
   // Отображает представление проверки с новым экземпляром модели History.
    public function actionTest()
    {
    
        $model = new History();
        
       
        return $this->render('test', [
            'model' => $model,
        ]);
    }
    
    // Метод для обнаружения ошибок в тексте и определения языка
    public function errorDetection(&$model)
    {
        // Подсчитываем количество английских/русских букв в тексте
        $enCount = preg_match_all('/[A-Za-z]/u', $model->text, $matchesEn);
        $rusCount = preg_match_all('/[А-ЯЁа-яё]/u', $model->text, $matchesRus);
        
        $lang = 'Английский';
        $matches = $matchesRus;
        
        if ($rusCount >= $enCount) {
            $lang = 'Русский';
            $matches = $matchesEn; 
        }
    
        $msg = 'Язык, на котором был введен текст: ' . $lang . '.  ';
        $model->lang = $lang;
        
        // Если найдены ошибки 
        if (!empty($matches[0])) {
            // Удаляем дубликаты ошибок
            $errors = array_unique($matches[0]);
            $replacements = [];
            
            // Формируем массив замен для отображения ошибок
            foreach ($errors as $error) {
                $replacements[$error] = '<span style="color: red; font-weight: bold;">' . $error . '</span>';
            }
            
            // Заменяем ошибки в исходном тексте на выделенные
            $name = strtr($model->text, $replacements);
            
            // Формируем список ошибок и сохраняем их 
            $errorList = implode(', ', $errors);
            $model->list_error = implode(', ', $errors);
            
            return [
                'success' => false,
                'message' => $msg
                    . '<br>Найдены ошибки: ' . $errorList . '<br>Введенный текст: ' . $name
            ];
        }
        return [
            'success' => true,
            'message' => $msg . 'Ошибок не найдено'
        ];
    }
    
    // Метод для проверки строки
    public function actionCheckStr(): Response
    {
        // Начальное состояние результата с сообщением об ошибке
        $result = [
            'success' => false,
            'message' => 'Заполните текст'
        ];
        if (Yii::$app->request->isPost) {
            $model = new History();
            $model->text = Yii::$app->request->post('text');
            
            // Получаем флаг сохранения из запроса
            $withSave = (int)Yii::$app->request->post('withSave');
            
            // Если текст не пустой, выполняем проверку на ошибки
            if ($model->text) {
                $result = $this->errorDetection($model);
                // Если флаг сохранения установлен, сохраняем модель в базе данных
                if ($withSave && $model->save()){
                        $result['message'].='<br><b> Успешно сохранено!';}
                
            }
        }
        return $this->asJson($result);
    }
    
}