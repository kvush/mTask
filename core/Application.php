<?php
namespace kvush\core;


use kvush\core\exceptions\HttpNotFoundException;

/**
 * Класс приложения. Реализует паттерн Singleton.
 * Является контейнером для компонентов приложения таких как Request, Response, Route, View
 *
 * Единственный экземпляр приложения создается во входом скрипте и там же запускается, через вызов метода run()
 *
 * @property Request $request Компонент запроса. Это свойство доступно только для чтения.
 * @property Response $response Компонент ответа. Это свойство доступно только для чтения.
 * @property Route $route Компонент маршрутизатора. Это свойство доступно только для чтения.
 * @property View $view Компонент Вида. Это свойство доступно только для чтения.
 *
 * @package kvush\core
 */
class Application extends BaseObject
{
    /** @var bool метка было ли запущено приложение */
    private static $_started = false;

    /**
     * Входня точка в приложение
     */
    public function run()
    {
        if (self::$_started) {
            return;
        }
        self::$_started = true;

        //получаем ответ
        $response = $this->handleRequest($this->request);
        //отправляем ответ
        $response->send();
    }

    /**
     * Обработка исключений
     * @param \Exception $e
     */
    public function exceptionHandler(\Exception $e) {
        //запускаем контроллер
        $content = $this->runAction(["error", "index"], ['message' => $e->getMessage(), 'status' => $e->statusCode]);
        //подготавливаем ответ
        $response = $this->getResponse()->setStatusCode($e->statusCode);
        if ($content !== null) {
            $response->data = $content;
        }
        //отправляем ответ
        $response->send();
    }

    /**
     * Обработка ошибок
     * @param \Error $e
     */
    public function errorHandler(\Error $e) {
        echo "errorHandler";
        var_dump($e);
    }

    /**
     * Обрабатываем вхдящий запрос
     *
     * @param Request $request входящий запрос
     * @return Response ответ
     */
    private function handleRequest(Request $request)
    {
        list($route, $params) = $this->route->resolveRequest($request);

        $result = $this->runAction($route, $params);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $this->getResponse();
        if ($result !== null) {
            $response->data = $result;
        }

        return $response;
    }

    /**
     * Запускаем контроллер согласно пути
     *
     * @param array $route
     * @param array $params
     *
     * @return string
     * @throws HttpNotFoundException
     */
    private function runAction(array $route, array $params)
    {
        $controller = current($route);
        $action = next($route);
        unset($route);

        $controllerClassName = Controller::getControllerClassName($controller);
        if (!class_exists($controllerClassName)) {
            throw new HttpNotFoundException("Страница не найдена");
        }
        /** @var Controller $controller */
        $controllerObj = new $controllerClassName();
        $callableAction = Controller::getActionName($action);
        if (!method_exists($controllerObj, $callableAction)) {
            throw new HttpNotFoundException("Страница не найдена");
        }
        //проверим соответствие переданных параметров параматрем в методе, в случае ошибки выбросим исключение HttpNotFoundException
        Controller::checkActionParams($controllerClassName, $callableAction, $params);

        return call_user_func_array([$controllerObj, $callableAction], $params);
    }

    /**********************************************************************************************************************
     * GETTERS AND SETTERS
     **********************************************************************************************************************/

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::getInstance();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return Response::getInstance();
    }

    /**
     * @return Route
     */
    public function getRoute(): Route
    {
        return Route::getInstance();
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        return View::getInstance();
    }

    /**********************************************************************************************************************
     * SINGLETON
     **********************************************************************************************************************/

    /** Запрет на вызов new */
    private function __construct(){}

    /** Запрет на клонирование */
    private function __clone(){}

    /** @var Application $_instance единственный экземпляр приложения. */
    private static $_instance;

    /**
     * Получаем единственный экземпляр
     *
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Application();
        }
        return self::$_instance;
    }
}