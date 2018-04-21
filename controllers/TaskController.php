<?php
namespace kvush\controllers;


use kvush\core\Application;
use kvush\core\Controller;
use kvush\core\DB;
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
            $filename = "";
            if ($_FILES['image']['size'] !== 0) {
                $filename = Task::saveImage($_FILES['image']);
            }
            $data = $_POST;
            $data['image'] = $filename;
            Task::saveData($data);
            return $this->redirect("/");
        }
        if (Application::getInstance()->request->getIsAjax()) {
            return $this->renderAjax("modal_add_task");
        }
        else {
            return $this->render("add_task");
        }
    }

    /**
     * @param int $id
     *
     * @return \kvush\core\Response|string
     */
    public function actionSwitchStatus($id)
    {
        $newStatus = Task::switchStatus((int)$id);
        if (Application::getInstance()->request->getIsAjax()) {
            return json_encode(['status' => $newStatus]);
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionUpdateTask($id)
    {
        $message = $_POST['message'] ?? false;
        if ($message) {
            DB::getInstance()->update('tasks', ['message' => $message], ['id' => $id])->execute();
        }
        return json_encode(['success' => true]);
    }
}
