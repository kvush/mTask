<?php
namespace kvush\core;


use kvush\core\exceptions\HttpNotFoundException;


/**
 * Базовый класс для всех конроллеров в системе
 *
 * @package kvush\core
 */
class Controller
{

    /**
     * Возвращает полное имя класса контроллера
     *
     * @param string $controller
     * @return string
     */
    public static function getControllerClassName($controller)
    {
        $controllerClassName = str_replace(' ', '', ucwords(implode(' ', explode('-', $controller)))) . 'Controller';
        $className = "kvush\\controllers\\$controllerClassName";
        return $className;
    }

    /**
     * Возвращает имя функции контроллера
     *
     * @param string $action
     * @return string
     */
    public static function getActionName(string $action)
    {
        return 'action' . str_replace(' ', '', ucwords(implode(' ', explode('-', $action))));
    }

    /**
     * Проверим соответсиве переданых параметров параметрам которые принимает действие контроллера
     * Выбрасим исключение HttpNotFoundException в случае ошибки
     *
     * @param string $controller
     * @param string $action
     * @param array  $params
     *
     * @throws HttpNotFoundException
     */
    public static function checkActionParams(string $controller, string $action, array $params)
    {
        $method = new \ReflectionMethod($controller, $action);
        $methodParams = $method->getParameters();

        //если передали больше параметров чем действие контроллера может принять
        if (sizeof($params) > sizeof($methodParams)) {
            throw new HttpNotFoundException();
        }
        //если передали меньше параметров чем действие контроллера должно принять
        foreach ($methodParams as $methodParam) {
            $paramName = $methodParam->getName();
            $paramPos = $methodParam->getPosition();
            $isOptional = $methodParam->isOptional();
            if (!key_exists($paramName, $params) && !key_exists($paramPos, $params) && !$isOptional) {
                throw new HttpNotFoundException();
            }
        }
    }

    /**
     * Отображение вида с использованием видов из папки views/layout
     *
     * @param string $view
     * @param array $params
     *
     * @return mixed
     */
    protected function render(string $view, $params = [])
    {
        return $this->renderView($view, $params, false);
    }

    /**
     * Отображение вида без layout
     *
     * @param string $view
     * @param array $params
     *
     * @return mixed
     */
    protected function renderAjax(string $view, $params = [])
    {
        return $this->renderView($view, $params, true);
    }

    /**
     * Метод определяет путь к файлу вида и вызывает метод View::renderFile чтобы отобразить заданный вид с переданными параметрами
     *
     * @param string $view имя файла с видом без .php на конце
     * @param array $params передаваемые параметры
     *
     * @param bool $ajax
     *
     * @return mixed
     */
    private function renderView(string $view, $params = [], bool $ajax)
    {
        $class = new \ReflectionClass($this);

        $folder = end(explode(DIRECTORY_SEPARATOR, $class->getFileName()));
        $folder = str_ireplace('Controller.php', '', $folder);
        $folder = preg_replace('/([a-z0-9])([A-Z])/', "$1-$2", $folder);
        $folder = strtolower($folder);

        $view = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $view . '.php';

        $viewObj = Application::getInstance()->getView();
        $content = $viewObj->renderFile($view, $params);
        if ($ajax) {
            return $content;
        }
        return $viewObj->renderLayout($content);
    }
}
