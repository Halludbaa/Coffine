<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Hallax\Clone\Route;
use Hallax\Clone\Services\Env; new Env;
use Hallax\Clone\Controller\MainController;
use Hallax\Clone\Controller\PostController;
use Hallax\Clone\Controller\UserController;
use Hallax\Clone\Middleware\AuthMiddleware;
use Hallax\Clone\Middleware\GuestMiddleware;


Route::resources();
// Route::add('GET', '/@([a-z][A-Z][0-9]*)/([a-z][A-Z][0-9]*)', UserController::class, 'test');
Route::add('GET', '/', PostController::class, 'index', [AuthMiddleware::class]);
Route::add('GET', '/@([0-9a-zA-Z_\.]*)', UserController::class, 'profile', [AuthMiddleware::class]);
Route::add('GET', '/@([0-9a-zA-Z_\.]*)/([0-9a-zA-Z]*)', PostController::class, 'getPost', [AuthMiddleware::class]);

Route::add('GET', '/media', PostController::class, 'media', [AuthMiddleware::class]);

Route::add('POST', '/reply/create', PostController::class, 'createReply', [AuthMiddleware::class]);
Route::add('POST', '/post/create', PostController::class, 'createPost', [AuthMiddleware::class]);
Route::add('POST', '/post/destroy', PostController::class, 'delete', [AuthMiddleware::class]);

Route::add('POST', '/post/patch', PostController::class, 'patch', [AuthMiddleware::class]);
Route::add('POST', '/create/save', PostController::class, 'save', [AuthMiddleware::class]);
Route::add('POST', '/save/like', PostController::class, 'like', [AuthMiddleware::class]);

Route::add('GET', '/search', PostController::class, 'search', [AuthMiddleware::class]);
Route::add('GET', '/save', PostController::class, 'save', [AuthMiddleware::class]);
Route::add('GET', '/like', PostController::class, 'like', [AuthMiddleware::class]);
// Route::add('GET', '/profile', UserController::class, 'profile');

#for Authentication
Route::add('GET', '/options', UserController::class, 'options', [AuthMiddleware::class]);
Route::add('POST', '/save/follow', UserController::class, 'followSystem', [AuthMiddleware::class]);
Route::add('POST', '/save/profile', UserController::class, 'saveProfile');
Route::add('GET', '/register', UserController::class, 'register', [GuestMiddleware::class]);
Route::add('POST', '/register', UserController::class, 'processRegister', [GuestMiddleware::class]);
Route::add('GET', '/login', UserController::class, 'login', [GuestMiddleware::class]);
Route::add('POST', '/login', UserController::class, 'processLogin', [GuestMiddleware::class]);
Route::add('GET', '/logout', UserController::class, 'logout', [AuthMiddleware::class]);
#end Authentication


Route::add('GET', '/test/hello', MainController::class, 'index');

Route::run();
