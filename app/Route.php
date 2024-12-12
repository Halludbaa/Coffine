<?php

namespace Hallax\Clone;

class Route
{
    public static array $routes = [];
    public array $typeFile = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpg',
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
    ];

    public static function add(
        string $method,
        string $path,
        string $controller,
        string $function,
        array $middlewares = []
    ): void {

        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'function' => $function,
            'middleware' => $middlewares
        ];
    }


    public static function run(): void
    {
        session_start();
        if(isset($_COOKIE['user']) && !isset($_SESSION['user'])) $_SESSION['user'] = $_COOKIE['user'];

        $path = '/';
        if (isset($_SERVER['PATH_INFO'])) {
            $path = $_SERVER['PATH_INFO'];
        }

        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            $pattern = "#^" . $route['path'] . "$#";
            if (preg_match($pattern, $path, $variables)  && $method == $route['method']) {


                foreach ($route['middleware'] as $middleware) {
                    $check = new $middleware;
                    $check->before();
                }

                $controller = new $route['controller'];
                $function = $route['function'];

                array_shift($variables);
                call_user_func_array([$controller, $function], $variables);

                return;
            }
        }


        http_response_code(404);
        echo "<h1> Not Found </h1>";
    }
    public static function resources()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $staticFolders = ['js', 'css', 'img/uploads', 'img'];

        foreach ($staticFolders as $folder) {
            if (preg_match("#^/$folder/(.*)$#", $requestUri, $matches)) {
                $filePath = __DIR__ . "/../resources/$folder/" . $matches[1];
                if (file_exists($filePath) && is_file($filePath)) {
                    $extensionFile = pathinfo($filePath, PATHINFO_EXTENSION);
                    $fileTypes = [
                        'css' => 'text/css',
                        'js' => 'application/javascript',
                        'png' => 'image/png',
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'gif' => 'image/gif',
                        'svg' => 'image/svg+xml',
                    ];
                    $fileType = $fileTypes[$extensionFile] ?? 'application/octet-stream';

                    header("Content-Type: $fileType");
                    header("Content-Length: " . filesize($filePath));
                    readfile($filePath);
                    exit;
                } else {
                    http_response_code(404);
                    echo "File Not Found LOL.";
                    exit;
                }
            }
        }
    }
}
