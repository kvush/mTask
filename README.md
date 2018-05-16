WHAT IS IT што эта такое
------------------------
Это скромная попытка реализации мини MVC фреймворка,
где есть одна входная точка в приложение index.php,
далее запрос разбирается на составные части, вызывается нужный контроллер и поехали.

DEMO
----
[зацени mTask](http://mtask.kvushco.xyz/) демо приложение, построенное на базе этого супер фреймворка. 


INSTALLATION
------------
* download and unzip, а лучше git clone
 ```
 git clone https://github.com/kvush/mTask.git mTask
 ```
* ну и не забыть подтянуть vendor
```
composer install
```
Хотя там всего одна зависимость и она не касается фреймворка, 
но зато касается рассматриваемого примера "mTask" 

SQL TABLES INSTALLATION
-----------------------

Создайте новую БД и примените этот код

```
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `status` (`id`, `title`) VALUES
(1, 'новая'),
(2, 'выполнено');

-- --------------------------------------------------------

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);
 
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

```