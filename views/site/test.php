

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

            <div id="w3-danger-0"></div>
                <?php $form = ActiveForm::begin([ 'id' => 'my-ajax-form',
  ]
               
                
            ); ?>

               

                    <?= $form->field($model, 'text')->textarea(['rows' => 6,'id' => 'ajax-textarea']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'text','id'=>'submit']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>


</div>
<?php


?><script>
document.addEventListener('DOMContentLoaded', function() {
    // Получаем элементы формы, текстового поля и уведомлений
    var form = document.getElementById('my-ajax-form');
    var textarea = document.getElementById('ajax-textarea');
    var notification = document.getElementById('w3-danger-0'); 

    // Устанавливаем флаг в зависимости от того, была ли отправлена форма
    let flag = <?= Yii::$app->request->isPost ? 'true' : 'false' ?>;

    // Обработчик события для текстового поля
    textarea.addEventListener('input', () => {
        var inputText = textarea.value.trim(); // Получаем текст из textarea и удаляем лишние пробелы
        if (inputText === '') return; // Если текст пустой, выходим из функции
        if (flag === false) return; // Если флаг не установлен, выходим из функции

        // Создаем новый XMLHttpRequest для отправки данных на сервер
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= yii\helpers\Url::to(['site/two']) ?>', true); // Указываем метод и URL для запроса
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Устанавливаем заголовок для отправки данных

        // Обработчик события при успешном завершении запроса
        xhr.onload = () => {
            var response = JSON.parse(xhr.responseText); // Парсим ответ от сервера
            notification.innerHTML = response.message; // Отображаем сообщение в элементе уведомления
            notification.className = response.success ? 'alert alert-success' : 'alert alert-danger'; // Устанавливаем класс в зависимости от успеха
        };

        // Обработчик события при ошибке запроса
        xhr.onerror = () => {
            notification.innerHTML = 'Ошибка сети.'; 
            notification.className = 'alert alert-danger'; // Устанавливаем класс для отображения ошибки
        };

        // Отправляем данные на сервер, включая CSRF-токен для безопасности
        xhr.send('text=' + encodeURIComponent(inputText) + '&<?= Yii::$app->request->csrfParam ?>=<?= Yii::$app->request->csrfToken ?>');
    });

    // Обработчик события для отправки формы
    form.addEventListener('submit', function() {
        flag = true; // Устанавливаем флаг в true, если форма отправляется
    });
});
</script>