<?php
/**
 * @var $this \kvush\core\View
 * @var $content string
 */
?>

<!DOCTYPE html>
<html lang="ru_RU">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ilya Shashilov">
    <meta name="description" content="Менеджер задач">
    <meta name="keywords" content="задачи, напоминание">

    <title><?=htmlspecialchars($this->title)?></title>
</head>
<body>
    <?=$content?>
</body>
</html>