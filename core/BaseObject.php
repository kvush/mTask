<?php
namespace kvush\core;


use kvush\core\exceptions\InvalidCallException;
use kvush\core\exceptions\UnknownPropertyException;

/**
 * Добавим не много магии
 *
 * @package kvush\core
 */
class BaseObject
{
    /**
     * Магический метод. Позволяет вызывать методы типа getAttribute() как простое свойство класса
     *
     * @param $_name
     *
     * @return
     * @throws UnknownPropertyException
     */
    public function __get($_name)
    {
        $name = str_replace(' ', '', ucwords(implode(' ', explode('_', $_name))));
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            // read property, e.g. getName()
            return $this->$getter();
        }

        if (method_exists($this, 'set' . $name)) {
            throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $_name);
        }

        throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $_name);
    }

    /**
     * Магический метод. Позволяет записывать значения в привтаные свойства если для них есть метод setAttribute()
     *
     * @param $_name
     * @param $value
     *
     * @throws UnknownPropertyException
     */
    public function __set($_name, $value)
    {
        $name = str_replace(' ', '', ucwords(implode(' ', explode('_', $_name))));
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            // set property
            $this->$setter($value);

            return;
        }

        if (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $_name);
        }

        throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $_name);
    }
}
