<?php


class Router{

    private $routes;

    public function __construct(){                      //подключаем наши руты в переменную $routesPath
        $routesPath= ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
}
    //метод возращает строку  запроса
    private function GetURI(){
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'],'/');
        }


}
    public function run(){

       // Получить строку запроса
        $uri = $this->GetURI();

        //проверить наличие такого маршрута в routes.php
         foreach($this->routes as $uriPattern => $path){

             //сравниваем $uriPattern и $uri (данные которые содержатся в роутах)
             if (preg_match("`$uriPattern`",$uri)){

                 //получаем внутренний путь из в нешнего согласно этому правилу
                 $internalRoute = preg_replace("`$uriPattern`", $path, $uri );


                 //определить какой контроллер и action обрабатывает запрос
                 $segments = explode('/',$internalRoute);     //разделяем строкузапроса на две части

                 $controllerName = array_shift($segments).'Controller';
                 $controllerName = ucfirst($controllerName);
                 $actionName = 'action'.ucfirst(array_shift($segments));

                 $parameters = $segments;

                 //подключить файл класса контроллера
                 $controllerFile= ROOT.'/controllers/'.$controllerName.'.php';
                 if (file_exists($controllerFile)){
                     include_once ($controllerFile);
                 }

                 //создать объект, вызвать метод(т.е. action)
                 $controllerObject = new $controllerName;
                 $result = call_user_func_array(array($controllerObject,$actionName), $parameters);
                 if ($result != null){
                     break;
                 }


             }
         }




}


}