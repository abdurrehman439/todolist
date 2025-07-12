<?php

declare(strict_types=1);

namespace Controllers;

use  Models\Task;

class TaskController
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function index(): void
    {
        $result = $this->task->getAll();
        if(isset($result))
        {
            $response =['status'=>true,'message'=>'record found','data'=>$result];
        }
        else
        {
            $response =['status'=>false, 'message'=>'record not found'];
        }

        $this->response($response);
    }

    public function show(int $id): void
    {
        $result = $this->task->getById($id);
        if(isset($result))
        {
            $response =['status'=>true,'message'=>'record found','data'=>$result];
        }
        else
        {
            $response =['status'=>false, 'message'=>'record not found'];
        }


        $this->response($response);
    }

    public function store(array $input): void
    {
        if (!isset($input['title'])) 
        {
            $this->response(['status'=>false, 'message'=>'Title is required']);
            return;
        }

        $input['description'] = $input['description'] ?? '';

        $result = $this->task->create($input);
        if($result)
        {
            $response =['status'=>true,'message'=>'Task created'];
        }
        else
        {
            $response =['status'=>false, 'message'=>'Failed to create task'];
        }

        $this->response($response);
    }

    public function update(int $id, array $input): void
    {
        if (!isset($input['title'])) {
            $this->response(['status'=>false, 'message'=>'Title is required']);
            return;
        }

        $input['description'] = $input['description'] ?$input['description']: '';

        $result = $this->task->update($id, $input);
        if($result)
        {
            $response =['status'=>true,'message'=>'Task updated'];
        }
        else
        {
            $response =['status'=>false, 'message'=>'Failed to update task'];
        }

        $this->response($response);
    }

    public function destroy(int $id): void
    {
        $result = $this->task->delete($id);
        if($result)
        {
            $response =['status'=>true,'message'=>'Task deleted'];
        }
        else
        {
            $response =['status'=>false, 'message'=>'Failed to delete task'];
        }

        $this->response($response);
    }

    public function status(int $id, string $status): void
    {
        if (!in_array($status, ['open','in_progress','cancel','complete'])) 
        {
            $response =['status'=>false, 'message'=>'Invalid action. Use "open" or "in_progress" or "cancel" or "complete"'];
        }
       
        $result = $this->task->markStatus($id,$status);
        if($result)
        {
            $response =['status'=>true,'message'=>'Task marked '.$status];
        }
        else
        {
            $response =['status'=>false, 'message'=>'Failed to mark '.$status];
        }
    

        $this->response($response);
    }
    
    public function response($data): void
    {
        echo json_encode($data);
    }
    
}
