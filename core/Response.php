<?php
namespace kvush\core;

/**
 * Компонент Response - отвечает за ответ.
 * Данный компонент содержит методы, которые подготавливают и отправляют ответ.
 *
 * @package kvush\core
 */
class Response
{
    /**
     * @var array HTTP статус код и сообщение
     */
    public static $httpStatuses = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        118 => 'Connection timed out',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        210 => 'Content Different',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        310 => 'Too many Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range unsatisfiable',
        417 => 'Expectation failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable entity',
        423 => 'Locked',
        424 => 'Method failure',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway or Proxy Error',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        507 => 'Insufficient storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /** @var mixed данные для ответа*/
    public $data;
    /** @var bool был ли отправлен ответ. Если это так, вызов [[send ()] ничего не сделает*/
    public $isSent = false;
    /** @var string версия HTTP протокола.*/
    public $version;

    /** @var int HTTP статус код для ответа.*/
    private $_statusCode = 200;
    /** @var null на будущее, если хотим отправить файл. Пока что просто null*/
    private $_stream = null;

    /**
     * Отправляет ответ клиенту
     */
    public function send()
    {
        if ($this->isSent) {
            return;
        }
        if ($this->_stream !== null) {
            return;
        }
        $this->sendHeaders();
        $this->sendContent();
        $this->isSent = true;
    }

    /**
     * Отправляет заголовки ответов клиенту.
     */
    protected function sendHeaders()
    {
        if (headers_sent()) {
            return;
        }
        //todo: реализовать класс контейнер HeaderCollection
        //todo: отправку cookies
        $status = $this->getStatusCode();
        $statusText = self::$httpStatuses[$status];

        header("HTTP/{$this->version} {$status} {$statusText}");
        header("Content-Type: text/html; charset=utf-8");
    }

    /**
     * Отправляет содержимое ответа клиенту.
     */
    protected function sendContent() {
        //на будущее, если хотим отправить файл.
        if ($this->_stream === null) {
            echo $this->data;

            return;
        }
    }

    /**
     * @return int HTTP статус код для отправки с ответом.
     */
    public function getStatusCode()
    {
        return $this->_statusCode;
    }

    /**
     * Установка статуса ответа сервера
     *
     * @param int $code
     *
     * @return $this
     */
    public function setStatusCode($code){
        $this->_statusCode = $code;
        return $this;
    }

    /**********************************************************************************************************************
     * SINGLETON
     **********************************************************************************************************************/

    /** Запрет на вызов new */
    private function __construct(){
        if ($this->version === null) {
            if (isset($_SERVER['SERVER_PROTOCOL']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.0') {
                $this->version = '1.0';
            } else {
                $this->version = '1.1';
            }
        }
    }

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
            self::$_instance = new Response();
        }
        return self::$_instance;
    }
}
