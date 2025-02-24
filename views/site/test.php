
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
            <?php $form = ActiveForm::begin([ 'id' => 'my-ajax-form']); ?>

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
    document.addEventListener('DOMContentLoaded', function() {
        let form = document.getElementById('my-ajax-form');
        let textarea = document.getElementById('ajax-textarea');
        let isSaved = <?= Yii::$app->request->isPost ? 'true' : 'false' ?>;
        let notification = document.getElementById('notification');

        // Функция для проверки строки на сервере
        function checkStr(withSave = false) {
            // Создаем новый XMLHttpRequest объект
            let xhr = new XMLHttpRequest();
            // Открываем POST-запрос к указанному URL
            xhr.open('POST', '<?= yii\helpers\Url::to(['site/check-str']) ?>', true);
            // Устанавливаем заголовок запроса
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            // Получаем текст из текстовой области и удаляем лишние пробелы
            let inputText = textarea.value.trim();

            // Обрабатываем ответ от сервера
            xhr.onload = () => {
                // Парсим ответ JSON
                let response = JSON.parse(xhr.responseText);
               notification.innerHTML = response.message;
                notification.className = response.success ? 'alert alert-success' : 'alert alert-danger';
            };

            // Обрабатываем ошибку сети
            xhr.onerror = () => {
                notification.innerHTML = 'Ошибка сети.';
                notification.className = 'alert alert-danger';
            };

            // Отправляем данные на сервер, включая текст и CSRF-токен
            xhr.send(
                'text=' + encodeURIComponent(inputText)
                + '&<?= Yii::$app->request->csrfParam ?>=<?= Yii::$app->request->csrfToken ?>'
                + '&withSave=' + (withSave ? '1' : '0') // Указываем, нужно ли сохранять данные
            );
        }

        // Обработчик события ввода текста в текстовую область
        textarea.addEventListener('input', () => {
            let inputText = textarea.value.trim(); 
            if (inputText === '') { 
                notification.innerHTML = 'Заполните текст'; 
                notification.className = 'alert alert-danger';
                return; 
            }
            if (isSaved === false) return; 
            checkStr(); 
        });

        // Обработчик события отправки формы
        form.addEventListener('submit', (e) => {
            e.preventDefault(); 
            isSaved = true; 
            checkStr(true);
            
        });
    });
</script>
