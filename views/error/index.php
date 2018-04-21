<?php
/**
 * @var $this \kvush\core\View
 * @var $message string
 * @var $status int
 */

$this->title =  $status . ' ' . $message;
?>

<div class="jumbotron" style="text-align: center">
    <h1>Ошибка <?=$status?></h1>
    <h2><?=$message?></h2>
</div>