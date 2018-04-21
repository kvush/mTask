<?php
namespace kvush\core\exceptions;

/**
 * Class UnknownPropertyException
 *
 * @package kvush\core\exceptions
 */
class UnknownPropertyException extends \Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Unknown Property';
    }
}
