<?php
namespace kvush\core;

/**
 * Class DB - реализует работу с БД.
 *
 * @package kvush\core
 */
class DB extends BaseObject
{
    /** @var  string адрес хоста, обычно localhost - задается в конфиге*/
    private $_host = "localhost";
    /** @var  string имя базы данных - задается в конфиге*/
    private $_db_name = "task_manager";
    /** @var  string имя юзера - задается в конфиге*/
    private $_user = "root";
    /** @var  string пароль юзера - задается в конфиге*/
    private $_password = "";
    /** @var \PDO соединение с БД */
    private $_dbh;
    /** @var  \PDOStatement */
    private $_result;
    /** @var  array значения параметров прикрепляемых к запросу */
    private $_params;

    /**
     * @param $sql
     *
     * @return $this
     */
    public function select($sql)
    {
        $this->_result = $this->_dbh->query($sql);
        return $this;
    }

    /**
     * @return array
     */
    public function all() {
        $result = $this->_result->fetchAll();
        $this->_result->closeCursor();
        return $result;
    }

    /**
     * @param string $table
     * @param array  $data
     *
     * @return $this
     */
    public function insert(string $table, array $data)
    {
        $keys = array_map(function ($k) {return "$k";}, array_keys($data));
        $data = array_map(function ($v) {
            $this->_params[] = $v;
            return "?";
        }, $data);
        $sql = "INSERT INTO `$table` (" . join(', ', $keys) . ") VALUES (" . join(', ', $data) . ")";
        $this->_result = $this->_dbh->prepare($sql);

        return $this;
    }

    /**
     * @param string $table
     * @param array  $data
     * @param array  $where
     *
     * @return $this
     */
    public function update(string $table, array $data, array $where)
    {
        $tmp = [];
        foreach ($data as $k => $v)
        {
            $tmp[] = '`'.$k.'` = ?';
            $this->_params[] = $v;
        }
        $data = join(', ', $tmp);

        $w = $where;
        if (is_array($where)) {
            $tmp2 = [];
            foreach ($where as $k => $v)
            {
                $tmp2[] = '`'.$k.'` = ?';
                $this->_params[] = $v;
            }
            $w = join(' AND ', $tmp2);
        }
        $w = 'WHERE '.$w;

        $sql = "UPDATE `$table` SET ".$data . " $w";
        $this->_result = $this->_dbh->prepare($sql);

        return $this;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        return $this->_result->execute($this->_params);
    }

    /**********************************************************************************************************************
     * SINGLETON
     **********************************************************************************************************************/

    /** Запрет на вызов new */
    private function __construct(){
        $this->_dbh = new \PDO("mysql:host=$this->_host;dbname=$this->_db_name", $this->_user, $this->_password);
    }

    /** Запрет на клонирование */
    private function __clone(){}

    /** @var DB $_instance единственный экземпляр приложения. */
    private static $_instance;

    /**
     * Получаем единственный экземпляр
     *
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
}
