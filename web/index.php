<?php
require(__DIR__ . '/../core/bootstrap.php');

try {
    \kvush\core\Application::getInstance()->run();
} catch (Exception $e) {
    \kvush\core\Application::getInstance()->exceptionHandler($e);
} catch (Error $e) {
    \kvush\core\Application::getInstance()->errorHandler($e);
}
