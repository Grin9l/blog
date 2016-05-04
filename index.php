<?php
/*
 * //формат даты: dd - mm - yyyy
$string = '21-03-2016';
//год 2016, месяц 03, день 21;
$pattern = '/([0-9]{2})-([0-9]{2})-([0-9]{4})/';
$replacement = 'Год $3, Месяц $2, День $1';
echo preg_replace($pattern, $replacement,$string );
exit;
*/

                                //front controller

//общие настройки
ini_set('display_errors',1);                       //отображение всех ошибок
error_reporting(E_ALL);                            //включаем на время разработки, когда сайт готов удаляем


//подключение файлов
define('ROOT',dirname(__FILE__));
require_once(ROOT.'/components/Router.php');        // подключение роутера
require_once(ROOT.'/components/Db.php');            //установка соединения с БД


//вызов Router
$router = new Router();
$router->run();