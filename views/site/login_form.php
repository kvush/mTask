<?php
/**
 * @var $this \kvush\core\View
 */
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Форма авторизации</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="login-form" method="post" action="/site/login">
                <div class="form-group">
                    <label for="login" class="col-form-label">Логин</label>
                    <input type="text" class="form-control" id="login" name="login" title="admin" required>
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="pass" title="123" required>
                </div>
                <button type="submit" id="submit-login-form" style="display: none"></button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">закрыть</button>
            <button type="button" class="btn btn-primary" onclick="$('#submit-login-form').trigger('click')">войти</button>
        </div>
    </div>
</div>