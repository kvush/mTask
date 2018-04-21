<?php
namespace kvush\core;


use kvush\core\exceptions\ViewNotFoundException;

/**
 * Базовый класс для всех видов в системе
 *
 * @package kvush\core
 */
class View
{
    /** @var string  */
    public $layout;
    /** @var string */
    public $title = 'Менеджер задач';

    /** @var array массив js скриптов подключенных в различных видах и выводящихся в layout/main */
    private $js = [];

    /**
     * Метод рендерит вид. Вызывается в контроллерах
     *
     * @param string $viewFile полный путь к файлу вида
     * @param array $params передаваемые параметры
     *
     * @return string
     */
    public function renderFile($viewFile, $params = [])
    {
        if (!is_file($viewFile)) {
            throw new ViewNotFoundException("Файл с видом не существует: $viewFile");
        }

        $output = $this->renderPhpFile($viewFile, $params);

        return $output;
    }

    /**
     * Метод рендерит шаблон из папки layouts с отрендеренным видом (параметр $content)
     *
     * @param string $content отрендеренный вид из папки modules папки views
     *
     * @return mixed
     */
    public function renderLayout($content)
    {
        return $this->renderFile($this->layout, ['content' => $content]);
    }

    /**
     * Публикует в главном виде все зарегестрированные скрипты
     */
    public function publicJsScripts()
    {
        foreach ($this->js as $js) {
            echo "<script>$js</script>\n";
        }
        $this->js=[];
    }

    /**
     * Регистрирует скрипт в массив скриптов для публикации в главном виде
     *
     * @param string $js
     */
    public function registerJs($js)
    {
        $key = md5($js);
        if (!key_exists($key, $this->js)) {
            $this->js[$key] = $js;
        }
    }

    /**
     * @param string $_file_ полный путь к файлу вида
     * @param array $_params_ передаваемые параметры
     *
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    private function renderPhpFile($_file_, $_params_ = [])
    {
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($_params_, EXTR_OVERWRITE);
        try {
            require($_file_);
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }

    /**********************************************************************************************************************
     * SINGLETON
     **********************************************************************************************************************/

    /** Запрет на вызов new */
    private function __construct(){
        $this->layout = dirname(__DIR__) . '/views/layouts/main.php';
    }

    /** Запрет на клонирование */
    private function __clone(){}

    /** @var View $_instance единственный экземпляр приложения. */
    private static $_instance;

    /**
     * Получаем единственный экземпляр
     *
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new View();
        }
        return self::$_instance;
    }
}