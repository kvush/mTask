<?php
namespace kvush\core;

/**
 * Компонент Request - отвечает за запрос.
 * Содержит методы получающие различную информацию из запроса.
 *
 * @package kvush\core
 */
class Request
{
    /** @var  string|null часть URL-адреса запроса, которая находится после скрипта ввода и перед вопросительным знаком. */
    private $_pathInfo;

    /**
     * Возвращает информацию о пути запрашиваемого URL.
     *
     * @return string часть URL-адреса запроса, которая находится после скрипта ввода и перед вопросительным знаком.
     */
    public function getPathInfo()
    {
        if ($this->_pathInfo === null) {
            $pathInfo = $_SERVER['REQUEST_URI'];
            //уберем "/" с обеих сторон
            $pathInfo = trim($pathInfo, "/");
            //отсечем лишние GET параметры
            if (($pos = strpos($pathInfo, '?')) !== false) {
                $pathInfo = substr($pathInfo, 0, $pos);
            }
            $this->_pathInfo = $pathInfo;
        }
        return $this->_pathInfo;
    }

    /**
     * Является ли пришедший запрос ajax-ом
     * @return bool
     */
    public function getIsAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**********************************************************************************************************************
     * SINGLETON
     **********************************************************************************************************************/

    /** Запрет на вызов new */
    private function __construct(){}

    /** Запрет на клонирование */
    private function __clone(){}

    /** @var Request $_instance единственный экземпляр приложения. */
    private static $_instance;

    /**
     * Получаем единственный экземпляр
     *
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Request();
        }
        return self::$_instance;
    }
}
