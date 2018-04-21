<?php
namespace kvush\core\exceptions;

/**
 * Class HttpNotFoundException
 *
 * @package kvush\core\exceptions
 */
class HttpNotFoundException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string     $message
     * @param int        $code     error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = 'страница не найдена', $code = 0, \Exception $previous = null)
    {
        parent::__construct(404, $message, $code, $previous);
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return parent::getName();
    }
}
