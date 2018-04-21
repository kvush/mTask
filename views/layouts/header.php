<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="/">TaskM</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/site/about">О чем это</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/task/add">Добавить задачу</a>
            </li>
            <li class="nav-item active">
                <?php if (\kvush\models\User::isAdmin()):?>
                    <a class="nav-link" href="/site/logout">Выход</a>
                <?php else:?>
                    <a class="nav-link login-btn" href="/site/login">Вход администратора</a>
                <?php endif;?>
            </li>
        </ul>
    </div>
</nav>