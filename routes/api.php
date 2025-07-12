<?php

use Config\Database;
use Controllers\TaskController;
use Models\Task;

$db             = (new Database())->conn;
$taskModel      = new Task($db);
$taskController = new TaskController($taskModel);

$method = $_SERVER['REQUEST_METHOD'];
$uri    = trim(str_replace(dirname($_SERVER['SCRIPT_NAME']), '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');


if ($uri === 'tasks' && $method === 'GET') 
{
    $taskController->index();

} 
elseif ($uri === 'tasks' && $method === 'POST') 
{
    $input = json_decode(file_get_contents('php://input'), true);
    $taskController->store($input);

} 
elseif (preg_match('#^tasks/(\d+)$#', $uri, $matches)) 
{
    $id = (int)$matches[1];

    if ($method === 'GET') 
    {
        $taskController->show($id);
    } 
    elseif ($method === 'PUT') 
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $taskController->update($id, $input);
    } 
    elseif ($method === 'DELETE') 
    {
        $taskController->destroy($id);
    }

} 
elseif (preg_match('#^tasks/(\d+)/(open|in_progress|cancel|complete)$#', $uri, $matches) && $method === 'PATCH') 
{
    $id = (int)$matches[1];
    $status = $matches[2];
    $taskController->status($id, $status);

} 
else 
{
    echo json_encode(['status'=>false, 'message' => 'Route not found']);
}
