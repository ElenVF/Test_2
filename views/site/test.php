
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\History $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Проверка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-test">
    <h1><?= Html::encode($this->title) ?></h1>



    <p>
        Введите строку для проверки
    </p>

    <div class="row">
        <div class="col-lg-5">

        <div id="notification" class="alert"></div>
            <?php $form = ActiveForm::begin([ 'id' => 'my-ajax-form',
                ]


            ); ?>



            <?= $form->field($model, 'text')->textarea(['rows' => 6,'id' => 'ajax-textarea']) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'submit','id'=>'submit']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>


</div>
<?php


?>

<script>
    // Ждем, пока весь контент документа будет загружен
    document.addEventListener('DOMContentLoaded', function() {
     // Находим по айди форму и поле ввода
        let form = document.getElementById('my-ajax-form');
        let textarea = document.getElementById('ajax-textarea');
       
        let flag = <?= Yii::$app->request->isPost ? 'true' : 'false' ?>;

        // Функция для проверки строки
        function checkStr(withSave = false) {
            
            let xhr = new XMLHttpRequest();
            // Открываем асинхронный POST-запрос к указанному урлу
            xhr.open('POST', '<?= yii\helpers\Url::to(['site/check-str']) ?>', true);
            // Устанавливаем заголовок для отправки данных в формате URL-кодирования
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            // Получаем див для отображения уведомлений
            let notification = document.getElementById('notification');
            // Получаем и обрезаем текст из textarea
            let inputText = textarea.value.trim();

            // Обработчик события, вызываемый при успешном завершении запроса
            xhr.onload = () => {
                // Парсим ответ как JSON
                let response = JSON.parse(xhr.responseText);
                // Обновляем содержимое уведомления в зависимости от ответа
                notification.innerHTML = response.message;
                notification.className = response.success ? 'alert alert-success' : 'alert alert-danger';
            };

            // Обработчик события, вызываемый при ошибке сети
            xhr.onerror = () => {
                
                notification.innerHTML = 'Ошибка сети.';
                notification.className = 'alert alert-danger';
            };

            // Отправляем данные на сервер, включая текст и CSRF-токен
            xhr.send(
                'text=' + encodeURIComponent(inputText) +
                '&<?= Yii::$app->request->csrfParam ?>=<?= Yii::$app->request->csrfToken ?>' +
                '&withSave=' + (withSave ? '1' : '0')
            );
        }

        // Добавляем обработчик события для textarea при вводе текста
        textarea.addEventListener('input', () => {
            
            let inputText = textarea.value.trim();
          
            if (inputText === '') return;
            
            if (flag === false) return;
       
            checkStr();
        });

        // Добавляем обработчик события для отправки формы
        form.addEventListener('submit', (e) => {
            
            e.preventDefault();
           
            flag = true;
           
            checkStr(true);
        });
    });
</script>

