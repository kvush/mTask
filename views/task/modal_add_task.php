<?php
/**
 * @var $this \kvush\core\View
 */
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Новя задача</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <?= $this->renderFile(__DIR__ . DIRECTORY_SEPARATOR . '_adding_form.php')?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">закрыть</button>
            <button type="button" class="btn btn-primary add-task">создать</button>
        </div>
    </div>
</div>