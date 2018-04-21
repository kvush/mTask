<?php
namespace kvush\core\exceptions;

/**
 * Class ViewNotFoundException
 *
 * @package kvush\core\exceptions
 */
class ViewNotFoundException extends \BadMethodCallException
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'View not Found';
    }
}
