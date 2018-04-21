<?php
namespace kvush\controllers;


use kvush\core\Controller;


/**
 * ErrorController часть системы по красивому выводу ошибок.
 * Этот контроллер используется ядром для красивого вывода исключений и ошибок.
 *
 * @package kvush\controllers
 */
class ErrorController extends Controller
{

    /**
     * @param $message
     * @param $status
     *
     * @return mixed
     */
    public function actionIndex($message, $status)
    {
        return $this->render('index', [
            'message' => $message,
            'status' => $status
        ]);
    }
}
