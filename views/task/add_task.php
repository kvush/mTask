<?php
/**
 * @var $this \kvush\core\View
 */
?>
<div class="container" style="padding-top: 20px;">
    <?= $this->renderFile(__DIR__ . DIRECTORY_SEPARATOR . '_adding_form.php')?>
    <a class="btn btn-secondary" href="/" role="button">Вернуться назад</a>
    <button type="button" class="btn btn-primary" onclick="$('#submit-add-task-form').trigger('click')">Создать</button>
</div>