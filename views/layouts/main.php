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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ilya Shashilov">
    <meta name="description" content="Менеджер задач">
    <meta name="keywords" content="задачи, напоминание">
    <title><?=htmlspecialchars($this->title)?></title>
    <!-- Bootstrap 4.1.0 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="/css/sticky-footer.css" rel="stylesheet">
</head>
<body>
<?= $this->renderFile(__DIR__ . DIRECTORY_SEPARATOR . 'header.php')?>

<main role="main" style="margin-top: 50px;">
    <?=$content?>
</main>

<footer class="footer">
    <div class="container">
        <span class="text-muted">© Ilya Shashilov <?=date("Y", time())?></span>
    </div>
</footer>

<!--Container for modal -->
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

</div>

<!-- Bootstrap 4.1.0 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script>
    $(".login-btn").on('click', function() {
        $.post(
            "/site/login",
            null,
            function(result) {
                var myModal = $('#commonModal');
                myModal.html(result);
                myModal.modal({backdrop: 'static', keyboard: false});
                myModal.modal('show');
            }
        );
        return false;
    });
</script>
<?php $this->publicJsScripts()?>
</body>
</html>