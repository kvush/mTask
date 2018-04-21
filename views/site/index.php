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
                $('#submit-add-task-form').trigger('click')
                return false;
            });
        }
    );
    return false;
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
        <div class="row">
            <?php foreach ($tasks as $task):?>
                <div class="col-md-4">
                    <?php $badge = $task['status'] == \kvush\models\Task::STATUS_NEW ? "<span class='badge badge-warning'>new</span>" : "<span class='badge badge-secondary'>done</span>"?>
                    <h3>
                        <small>ответственный</small> <?=$badge?><br>
                        <?=$task['user_name']?>
                    </h3>
                    <div style="min-height: 200px">
                        <p class="lead" style="word-wrap: break-word"><?=$task['message']?></p>
                    </div>
                    <?php if (!empty($task['image'])){
                        echo "<img src='$task[image]' class='img-fluid img-thumbnail' alt='task image'>";
                    }?>
                    <?php if (\kvush\models\User::isAdmin()):?>
                        <p><a class="btn btn-secondary" href="/task/switch-status/<?=$task['id']?>" role="button">Сменить статус</a></p>
                    <?php endif;?>
                </div>
            <?php endforeach;?>
        </div>
        <?php if ($pagination['last_page'] > 1):?>
            <nav aria-label="Page navigation" style="margin-top: 50px;">
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
        <a class="btn btn-primary add-task float-right" href="#" role="button">Добавить задачу</a>
        <div class="clearfix"></div>
    <?php endif;?>
</div> <!-- /container -->