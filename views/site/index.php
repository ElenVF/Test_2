<?php

/** @var yii\web\View $this */


use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
$this->title = 'Проверка';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">История проверок</h1>

        <p class="lead">Здесь вы можете увидеть все проверки,которые содержали ошибки</p>

        
    </div>
    <?php if($history) {?>
    <div class="body-content">

    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Текст</th>
      <th scope="col">Дата проверки</th>
      <th scope="col">Ошибки</th>
      <th scope="col">Язык</th>
    
    </tr>
  </thead>
  <tbody><?php foreach($history as $item) {?>
    <tr>
        
    <td><?= Html::encode($item->id) ?></td>
      <td><?= Html::encode($item->text) ?></td>
      <td><?= Html::encode($item->created_at) ?></td>
      <td><?= Html::encode($item->list_error) ?></td>
      <td><?= Html::encode($item->lang) ?></td>
    </tr><?php }?>
   
  </tbody>
</table>

    </div>
    <?php }?>
</div>



<script>
      $(document).ready(function() {
        $("table").DataTable({
          order: [0, 'desc'],
          language: {
            "sEmptyTable": "Нет данных в таблице",
            "sInfo": "Показано _START_ до _END_ из _TOTAL_ записей",
            "sInfoEmpty": "Показано 0 до 0 из 0 записей",
            "sInfoFiltered": "(отфильтровано из _MAX_ записей)",
            "sLengthMenu": "Показать _MENU_ записей",
            "sLoadingRecords": "Загрузка...",
            "sProcessing": "Обработка...",
            "sSearch": "Поиск:",
            "sZeroRecords": "Совпадений не найдено",
            "oPaginate": {
              "sPrevious": "<i class='fa fa-chevron-left'></i>", // Стрелка назад
              "sNext": "<i class='fa fa-chevron-right'></i>" // Стрелка вперед
            }
          }
        });
      });
    </script>