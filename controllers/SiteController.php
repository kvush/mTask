<?php
namespace kvush\controllers;


use kvush\core\Controller;
use kvush\models\Task;
use kvush\models\User;

/**
 * Class SiteController
 *
 * @package kvush\controllers
 */
class SiteController extends Controller
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $page = $_GET['page'] ?? 1;
        $tasksData = Task::getAllTasks($page);
        return $this->render("index", [
            'tasksData' => $tasksData
        ]);
    }

    /**
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render("about");
    }


    /**
     * @return \kvush\core\Response|mixed
     */
    public function actionLogin()
    {
        if (!empty($_POST)) {
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            User::login($login, $pass);
            return $this->redirect("/");
        }
        return $this->renderAjax("login_form");
    }

    /**
     * @return \kvush\core\Response
     */
    public function actionLogout()
    {
        User::logout();
        return $this->redirect("/");
    }
}
