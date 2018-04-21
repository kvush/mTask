<?php
namespace kvush\core\exceptions;

/**
 * Class InvalidCallException
 *
 * @package dnkControl\core\exceptions
 */
class InvalidCallException extends \BadMethodCallException
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Invalid Call';
    }
}
