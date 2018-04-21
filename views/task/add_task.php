<?php
/**
 * @var $this \kvush\core\View
 */

$this->registerJs(<<<js
function showTaskPreview(name, email, message) {
   var data = $('#add-task-form').serialize();
   $.post(
        "/site/preview",
        data,
        function(result) {
            var myModal = $('#commonModal');
            myModal.html(result);
            myModal.modal({backdrop: 'static', keyboard: false});
            myModal.modal('show');
        }
    );
}
js
);
?>
<div class="container" style="padding-top: 20px;">
    <?= $this->renderFile(__DIR__ . DIRECTORY_SEPARATOR . '_adding_form.php')?>
    <a class="btn btn-secondary" href="/" role="button">Вернуться назад</a>
    <button type="button" class="btn btn-primary" onclick="showTaskPreview()">перд.просмотр</button>
    <button type="button" class="btn btn-primary" onclick="$('#submit-add-task-form').trigger('click')">Создать</button>
</div>