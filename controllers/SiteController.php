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
        session_start();
        if (isset($_GET['page'])) {
            $_SESSION['page'] = $_GET['page'];
        }
        if (isset($_GET['sort'])) {
            $_SESSION['sort'] = $_GET['sort'];
        }

        $page = $_SESSION['page'] ?? 1;
        $sort = $_SESSION['sort'] ?? '';
        $tasksData = Task::getAllTasks($page, $sort);
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

    /**
     * @return mixed
     */
    public function actionPreview()
    {
        return $this->renderAjax("_preview", [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'message' => $_POST['message']
        ]);
    }
}
