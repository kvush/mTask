<?php
namespace kvush\models;


use kvush\core\DB;

/**
 * Class Task
 *
 * @package kvush\models
 */
class Task
{
    const STATUS_NEW = 1;
    const STATUS_DONE = 2;

    const ROW_PER_PAGE = 3;

    /**
     * @param int $page номер страницы (для пагинации)
     *
     * @return mixed
     */
    public static function getAllTasks($page)
    {
        $pagination = static::getPagination($page);
        $rows = static::ROW_PER_PAGE;
        $sql = "SELECT * FROM tasks LIMIT $pagination[start_pages], $rows";
        $tasks = DB::getInstance()->select($sql)->all();
        return ["tasks" => $tasks, "pagination" => $pagination];
    }

    /**
     * @param array $data
     */
    public static function saveData(array $data)
    {
        $name = $data['name'] ?? "Для всех";
        $email = $data['email'] ?? "admin@example.com";
        $message = $data['message'] ?? "";
        $image = $data['image'] ?? "";

        DB::getInstance()
            ->insert("tasks", [
                "user_name" => $name,
                "user_email" => $email,
                "message" => $message,
                "image" => $image,
                "status" => self::STATUS_NEW
            ])->execute();
    }

    /**
     * @param int $page текущая страница
     *
     * @return array
     */
    public static function getPagination($page)
    {
        $total_rows = DB::getInstance()->select("SELECT COUNT(*) FROM `tasks`")->all();
        //todo: требуется доработка DB для выдачи нормальных результатов
        $total_rows = $total_rows[0][0];
        $last_page = ceil($total_rows/static::ROW_PER_PAGE); //общее кол-во страниц
        $last_page = $last_page < 1 ? 1 : $last_page;
        $start_page = ($page-1) * static::ROW_PER_PAGE; // страница с которой начнется запрос к БД
        return ["total_messages" => $total_rows, "start_pages" => $start_page, "page" => $page, "last_page" => $last_page];
    }

    /**
     * @param int $id
     *
     * @return int
     */
    public static function switchStatus(int $id)
    {
        $curStatus =  DB::getInstance()->select("SELECT `status` FROM `tasks` WHERE id='$id'")->all();
        $curStatus = $curStatus[0]['status'];
        $newStatus = $curStatus == self::STATUS_NEW ? self::STATUS_DONE : self::STATUS_NEW;
        if (DB::getInstance()->update('tasks', ['status' => $newStatus], ['id' => $id])->execute())
        {
            return $newStatus;
        }
        else {
            return $curStatus;
        }
    }
}