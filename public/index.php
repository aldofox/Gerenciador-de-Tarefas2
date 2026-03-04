<?php 

session_start();

require_once '../core/Router.php';
require_once '../app/AuthController.php';
require_once '../controllers/TarefaController.php';

$router = new Router();

/*Rotas AUTH */
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

/*Rotas TAREFAS */
$router->get('/tarefas', [TarefaController::class, 'index'], 'AuthMiddleware');
$router->get('/tarefas/create',[TarefaController::class,'create'], 'AuthMiddleware');
$router->post('/tarefas/store', [TarefaController::class, 'store'], 'AuthMiddleware');
$router->get('/tarefas/edit', [TarefaController::class, 'edit'], 'AuthMiddleware');
$router->post('/tarefas/update', [TarefaController::class, 'update'], 'AuthMiddleware');
$router->get('/tarefas/delete', [TarefaController::class, 'delete'], 'AuthMiddleware');
$router->get('/', [AuthController::class, 'homeRedirect']);
$router->run();
