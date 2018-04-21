<?php
namespace kvush\core;

/**
 * Компонент Route - маршрутизатор.
 * Разбирает входящий запрос на составные части:
 * route - контроллер/действие
 * params - параметры, которые будут переданы в действие контроллера
 *
 * @package kvush\core
 */
class Route
{

    /**
     * Разбираем запрос на маршрут и допонительные параметры
     *
     * @param Request $request
     *
     * @return array
     */
    public function resolveRequest(Request $request)
    {
        $path = $request->getPathInfo();
        $path = explode('/', $path);

        $controller = '';
        $action = '';
        $params = [];
        while (sizeof($path) > 0) {
            if ($controller == '') {
                $controller = array_shift($path);
            }
            elseif ($action == '') {
                $action = array_shift($path);
            }
            else {
                $params[] = array_shift($path);
            }
        }
        $route['controller'] = $controller == '' ? 'site' : $controller;
        $route['action'] = $action == '' ? 'index' : $action;

        return [$route, $params];
    }

    /**********************************************************************************************************************
     * SINGLETON
     **********************************************************************************************************************/

    /** Запрет на вызов new */
    private function __construct(){}

    /** Запрет на клонирование */
    private function __clone(){}

    /** @var Route $_instance единственный экземпляр приложения. */
    private static $_instance;

    /**
     * Получаем единственный экземпляр
     *
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Route();
        }
        return self::$_instance;
    }
}
