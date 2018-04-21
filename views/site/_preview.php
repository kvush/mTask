<?php
/**
 * @var $this \kvush\core\View
 * @var $name string
 * @var $email string
 * @var $message string
 */
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Предварительный просмотр</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <h3>
                    <small>ответственный</small> <span class='badge badge-warning'>new</span><br>
                    <?=htmlspecialchars($name)?>
                </h3>
                <div style="max-height: 250px; overflow-y: hidden">
                    <p><?=htmlspecialchars($email)?></p>
                    <p class="lead" style="word-wrap: break-word"><?=htmlspecialchars($message)?></p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">закрыть</button>
        </div>
    </div>
</div>
