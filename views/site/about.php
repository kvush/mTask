<?php
/** @var $this \kvush\core\View  */

$this->title = "Описание менеджер задач TaskM"
?>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1 class="display-4">
            Добро пожаловать <small>в менеджер задач mTask</small>
        </h1>
        <br>
        <p><a class="btn btn-primary btn-lg" href="/task/add" role="button">Создать задачу?</a></p>
    </div>
</div>
<div class="container">
    <p class="lead">Это приложение реализует следующую задачу.</p>
    <p>
        Создать приложение-задачник.<br>
        Задачи состоят из:
    </p>
    <ul>
        <li>имени пользователя;</li>
        <li>е-mail;</li>
        <li>текста задачи;</li>
        <li>картинки;</li>
    </ul>
    <p>
        Стартовая страница - список задач с возможностью сортировки по имени пользователя, email и статусу.<br>
        Вывод задач нужно сделать страницами по 3 штуки (с пагинацией). Видеть список задач и создавать новые может любой посетитель без регистрации.<br>
        Перед сохранением новой задачи можно нажать "Предварительный просмотр", он должен работать без перезагрузки страницы.<br>
        К задаче можно прикрепить картинку. Требования к изображениям - формат JPG/GIF/PNG, не более 320х240 пикселей.<br>
        При попытке загрузить изображение большего размера, картинка должна быть пропорционально уменьшена до заданных размеров.<br>
        Сделайте вход для администратора (логин "admin", пароль "123"). Администратор имеет возможность редактировать текст задачи и поставить галочку о выполнении.
        Выполненные задачи в общем списке выводятся с соответствующей отметкой.<br>
        В приложении нужно с помощью чистого PHP реализовать модель MVC. Фреймворки PHP использовать нельзя, библиотеки - можно. Верстка на bootstrap. К дизайну особых требований нет, должно выглядеть аккуратно.
    </p>
</div>