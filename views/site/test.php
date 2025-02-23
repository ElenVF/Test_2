

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


?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('my-ajax-form');
    var textarea = document.getElementById('ajax-textarea');
    var notification = document.getElementByСlassName('w3-danger-0');
  
    let flag =  <?=Yii::$app->request->isPost ? 'true' : 'false' ?>
   
    textarea.addEventListener('input', () => {
    var inputText = textarea.value.trim();
    if (inputText === '') return;
    if (flag === false) return; 

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= yii\helpers\Url::to(['site/two']) ?>', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = () => {
        var response = JSON.parse(xhr.responseText);
        notification.innerHTML = response.message;
        notification.className = response.success ? 'alert alert-success' : 'alert alert-danger';
    };

    xhr.onerror = () => {
        notification.innerHTML = 'Ошибка сети.';
        notification.className = 'alert alert-danger';
    };

    xhr.send('text=' + encodeURIComponent(inputText) + '&<?= Yii::$app->request->csrfParam ?>=<?= Yii::$app->request->csrfToken ?>');
});


    form.addEventListener('submit', function() {
        flag = true;
    });
});
</script>
