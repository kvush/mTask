<?php
/**
 * @var $this \kvush\core\View
 */
?>

<form enctype="multipart/form-data" id="add-task-form" method="post" action="/task/add">
    <div class="form-group">
        <label for="recipient-name" class="col-form-label">Имя исполнителя</label>
        <input type="text" class="form-control" id="recipient-name" name="name" required>
    </div>
    <div class="form-group">
        <label for="recipient-email" class="col-form-label">email исполнителя</label>
        <input type="email" class="form-control" id="recipient-email" name="email">
    </div>
    <div class="form-group">
        <label for="task-text" class="col-form-label">Текст задачи</label>
        <textarea class="form-control" id="task-text" name="message" required></textarea>
    </div>
    <div class="form-group">
        <label for="message-pic" class="col-form-label">Картинка:</label>
        <input type="file" accept="image/*" class="form-control" id="message-pic" name="image">
    </div>
    <button type="submit" id="submit-add-task-form" style="display: none"></button>
</form>