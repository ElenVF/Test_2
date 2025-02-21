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

            <div id="notification"></div>
                <?php $form = ActiveForm::begin(); ?>

               

                    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'text','id'=>'text']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>


</div>

