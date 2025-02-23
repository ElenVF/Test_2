<?php

namespace app\controllers;

use Yii;
use yii\bootstrap5\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

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
        // Получаем все записи из таблицы History и передаем их в представление index

        return $this->render('index', ['history' => History::find()->all()]);
    }

 

    public function actionTest()
    {
        // Создаем новый экземпляр модели History
        $model = new History();
        
        // Рендерим представление  
        return $this->render('test', [
            'model' => $model, 
        ]);
    }
    public function languageDetection($name)
    {
        // Подсчитываем количество английских и русских букв в строке
        $enCount = preg_match_all('/[A-Za-z]/u', $name);
        $rusCount = preg_match_all('/[А-ЯЁа-яё]/u', $name);
        
        // Определяем язык на основе количества найденных букв
        if ($rusCount >= $enCount) {
            return 'Русский';
        } else {
            return 'Английский';
        }
    }
    
    public function errorDetection($name, $lang, &$model)
    {
       
        if ($lang == 'Русский') {
            preg_match_all('/[A-Za-z]/u', $name, $matches); // Ищем английские буквы, если язык русский
        } else {
            preg_match_all('/[А-ЯЁа-яё]/u', $name, $matches); // Ищем русские буквы, если язык английский
        }
        
        // Если найдены ошибки, обрабатываем их
        if (!empty($matches[0])) {
            $errors = array_unique($matches[0]); // Убираем дубликаты ошибок
            $replacements = [];
            
            // Подсвечиваем найденные ошибки
            foreach ($errors as $error) {
                $replacements[$error] = '<span style="color: red; font-weight: bold;">' . $error . '</span>';
            }
            
            // Заменяем ошибки в исходном тексте на подсвеченные
            $name = strtr($name, $replacements);
            
            // Создаем список ошибок для отображения
            $errorList = implode(', ', $errors);
            $model->list_error = implode(', ', $errors); // Сохраняем список ошибок в модели
            
            return '<br>Найдены ошибки: ' . $errorList . '<br>Введенный текст: ' . $name;
        } else {
            return 'Ошибок не найдено'; 
        }
    }
    public function actionCheckStr()
    {
        
        $result = [];
        
        if (Yii::$app->request->isPost) {
           
            $model = new History();
            
            // Получаем текст из POST запроса и сохраняем его в модели
            $model->text = Yii::$app->request->post('text');
            
            // Получаем значение withSave и преобразуем его в целое число
            $withSave = (int)Yii::$app->request->post('withSave');
            
            // Проверяем, что текст не пустой
            if ($model->text) {
                // Вызываем метод checkStr для проверки строки и получаем результат
                $result = $this->checkStr($model);
                
                // Если withSave равно 1 , сохраняем модель в бд
                if ($withSave) {
                    $model->save();
                }
            }
        }
        
        // Возвращаем результат в формате JSON
        return $this->asJson($result);
    }
    public function checkStr(History &$model) :array {
        // Определяем язык текста
        $lang = $this->languageDetection($model->text);
        $model->lang = $lang; // Сохраняем язык в модели
        
        // Проверяем текст на наличие ошибок
        $matches = $this->errorDetection($model->text, $lang, $model);
        
        // Устанавливаем флаг успеха в зависимости от наличия ошибок
        $success = false;
        if ($matches == 'Ошибок не найдено') {
            $success = true;
        }
        
        // Возвращаем результат проверки в виде массива
        return [
            'success' => $success,
            'message' => 'Язык, на котором был введен текст: ' . $lang . '.  ' . $matches
        ];
    }
}    
    
   

