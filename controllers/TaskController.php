<?php
namespace kvush\controllers;


use kvush\core\Application;
use kvush\core\Controller;
use kvush\models\Task;

/**
 * Class TaskController
 *
 * @package kvush\controllers
 */
class TaskController extends Controller
{
    /**
     * @return \kvush\core\Response|mixed
     */
    public function actionAdd()
    {
        if (!empty($_POST)) {
            Task::saveData($_POST);
            return $this->redirect("/");
        }
        if (Application::getInstance()->request->getIsAjax()) {
            return $this->renderAjax("modal_add_task");
        }
        else {
            return $this->render("add_task");
        }
    }
}
