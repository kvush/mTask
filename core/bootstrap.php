<?php

/**
 * Функция автозагрузки классов с namespace \kvush\core
 *
 * @param string $class полное имя класса \kvush\core\Bar\Baz\Qux
 * @return void
 */
function registerKvushCore($class) {
    // конкретно для этого случая префикс для namespace
    $prefix = 'kvush\\core\\';

    // базовая дериктория для этого namespace префикса
    $base_dir = __DIR__ . DIRECTORY_SEPARATOR;

    // Содержет ли $class заданный namespace префикс?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // нет, идем сразу к следующему зарегестрированому autoloader-у
        return;
    }

    // получаем имя класса без namespace префикса
    $relative_class = substr($class, $len);

    // получаем путь до файла (вместо namespace префикса вставляем базовую директорию), на конце добавляем .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
}

/**
 * Функция автозагрузки классов с namespace \kvush\core
 *
 * @param string $class полное имя класса \kvush\core\Bar\Baz\Qux
 * @return void
 */
function registerKvushControllers($class) {
    // конкретно для этого случая префикс для namespace
    $prefix = 'kvush\\controllers\\';

    // базовая дериктория для этого namespace префикса
    $base_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;

    // Содержет ли $class заданный namespace префикс?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // нет, идем сразу к следующему зарегестрированому autoloader-у
        return;
    }

    // получаем имя класса без namespace префикса
    $relative_class = substr($class, $len);

    // получаем путь до файла (вместо namespace префикса вставляем базовую директорию), на конце добавляем .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('registerKvushCore');
spl_autoload_register('registerKvushControllers');
