<?php
/** @var $tasksData array */
/** @var $this \kvush\core\View  */

$this->title = "Добро пожаловать в менеджер задач TaskM";

$this->registerJs(<<<js
$(".add-task").on('click', function() {
    $.post(
        "/task/add",
        null,
        function(result) {
            var myModal = $('#commonModal');
            myModal.html(result);
            myModal.modal({backdrop: 'static', keyboard: false});
            myModal.modal('show');
            myModal.find(".add-task").on('click', function() {
                $('#submit-add-task-form').trigger('click');
                return false;
            });
        }
    );
    return false;
});

function getUrlParams(prop) {
    var params = {};
    var search = decodeURIComponent(window.location.href.slice(window.location.href.indexOf('?') + 1));
    var definitions = search.split('&');

    definitions.forEach(function (val, key) {
        var parts = val.split('=', 2);
        params[parts[0]] = parts[1];
    });

    return (prop && prop in params) ? params[prop] : undefined;
}

function sorting() {
    var sortView = $(".sorting-tasks");
    if (typeof(Storage) !== "undefined") {
        var selected = localStorage.getItem("sort");
        if (selected !== null) {
            sortView.val(selected);
        }

    }
    sortView.change(function () {
        var sort = $(this).val();
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem("sort", sort);
        }
        var url = "?sort=" + sort;
        var page = getUrlParams('page');
        if (page !== undefined) {
            url += "&page=" + page;
        }
        window.location.assign(url);
    });
}

$('.edit-task-save').on('click', function() {
    var id = $(this).data("id");
    var url = $(this).attr("href");
    var text = $('#' + id).val();
    $.post(
        url,
        {"message": text},
        function() {
            alert("Данные успешно сохранены");
        }
    );
    return false;
});

$(document).ready(function() {
    sorting();
});
js
);

$tasks = $tasksData['tasks'];
$pagination = $tasksData['pagination'];
?>

<div class="container" style="margin-top: 70px;">
    <?php if (empty($tasks)):?>
        <h1 class="mt-5">Нет созданных задач</h1>
        <p class="lead">Воспользуйтесь меню или нажмите кнопку ниже чтобы создать задачу</p>
        <a class="btn btn-primary add-task" href="#" role="button">Добавить задачу</a>
    <?php else:?>
        <select class="custom-select sorting-tasks" title="сортировать по">
            <option value="" disabled>Выберете вид сортировки</option>
            <option value="id">Отсортировать по порядку добавления</option>
            <option value="user_name">Отсортировать по имени</option>
            <option value="user_email">Отсортировать по email</option>
            <option value="status">Отсортировать по статусу</option>
        </select>
        <br>
        <div class="row" style="height: 460px; overflow-y: hidden">
            <?php foreach ($tasks as $task):?>
                <div class="col-md-4">
                    <?php $badge = $task['status'] == \kvush\models\Task::STATUS_NEW ? "<span class='badge badge-warning'>new</span>" : "<span class='badge badge-secondary'>done</span>"?>
                    <h3>
                        <small>ответственный</small> <?=$badge?><br>
                        <?=htmlspecialchars($task['user_name'])?>
                    </h3>
                    <div style="max-height: 250px; overflow-y: hidden">
                        <p><?=htmlspecialchars($task['user_email'])?></p>
                        <?php if (\kvush\models\User::isAdmin()):?>
                            <div class="form-group">
                                <textarea class="form-control edit-task" rows="3" title="изменить задачу" id="<?=$task['id']?>"><?=htmlspecialchars($task['message'])?></textarea>
                            </div>
                        <?php else:?>
                            <p class="lead" style="word-wrap: break-word"><?=htmlspecialchars($task['message'])?></p>
                        <?php endif;?>
                    </div>
                    <?php if (!empty($task['image'])){
                        echo "<img src='/images/$task[image]' class='img-fluid img-thumbnail' alt='task image' style='margin-bottom: 10px;'>";
                    }?>
                    <?php if (\kvush\models\User::isAdmin()):?>
                        <p>
                            <a class="btn btn-secondary" href="/task/switch-status/<?=$task['id']?>" role="button">Сменить статус</a>
                            <a class="btn btn-primary edit-task-save" data-id="<?=$task['id']?>" href="/task/update-task/<?=$task['id']?>" role="button">Сохранить</a>
                        </p>
                    <?php endif;?>
                </div>
            <?php endforeach;?>
        </div>
        <?php if ($pagination['last_page'] > 1):?>
            <nav aria-label="Page navigation" style="margin-top: 10px;">
                <ul class="pagination">
                    <?php
                    $disabled_pr = "";
                    if ($pagination['page'] == 1) {
                        $disabled_pr = "disabled";
                    }
                    ?>
                    <li class="page-item <?=$disabled_pr?>">
                        <a class="page-link" href="/?page=<?=($pagination['page']-1)?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                    </li>
                    <?php
                    for ($p = 1; $p <= $pagination['last_page']; $p++) {
                        $active = "";
                        if ($pagination['page'] == $p) {
                            $active = "active";
                        }
                        echo "<li class='page-item $active'><a class='page-link' href='/?page=$p'>$p</a></li>";
                    }
                    ?>
                    <?php
                    $disabled_nx = "";
                    if ($pagination['page'] == $pagination['last_page']) {
                        $disabled_nx = "disabled";
                    }
                    ?>
                    <li class="page-item <?=$disabled_nx?>">
                        <a class="page-link" href="/?page=<?=($pagination['page']+1)?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                    </li>
                </ul>
            </nav>
        <?php endif;?>
        <a class="btn btn-primary add-task float-right" href="#" role="button">Быстро добавить задачу</a>
        <div class="clearfix"></div>
    <?php endif;?>
</div> <!-- /container -->