<?php
namespace kvush\models;

/**
 * Class User
 *
 * @package kvush\models
 */
class User
{
    /**
     * @return bool
     */
    public static function isAdmin() {
        session_start();
        return isset($_SESSION['admin']);
    }

    /**
     * Простая авторизация ерез сессии
     */
    public static function login($login, $pass) {
        session_start();
        if ($login == "admin" && $pass == "123")
        {
            $_SESSION['admin'] = true;
        }
        else {
            $_SESSION['flash'] = "Неверно задан пароль или логин";
        }
    }

    /**
     * Удаляем сессию отвечающую за автроизованного пользователя
     */
    public static function logout()
    {
        session_start();
        unset($_SESSION['admin']);
    }
}
