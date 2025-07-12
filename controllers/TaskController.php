<?php

declare(strict_types=1);

namespace Controllers;

use Models\Task;

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

        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Record(s) found',
                'data' => $result
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No records found'
            ], 404);
        }
    }

    public function show(int $id): void
    {
        $result = $this->task->getById($id);

        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Record found',
                'data' => $result
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Task not found'
            ], 404);
        }
    }

    public function store(array $input): void
    {
        if (empty($input['title'])) {
            $this->response([
                'status' => false,
                'message' => 'Title is required'
            ], 400);
            return;
        }

        $input['description'] = $input['description'] ?? '';

        if ($this->task->create($input)) {
            $this->response([
                'status' => true,
                'message' => 'Task created'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to create task'
            ], 500);
        }
    }

    public function update(int $id, array $input): void
    {
        if (empty($input['title'])) {
            $this->response([
                'status' => false,
                'message' => 'Title is required'
            ], 400);
            return;
        }

        $input['description'] = $input['description'] ? $input['description'] : '';

        if ($this->task->update($id, $input)) {
            $this->response([
                'status' => true,
                'message' => 'Task updated'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to update task'
            ], 500);
        }
    }

    public function destroy(int $id): void
    {
        if ($this->task->delete($id)) {
            $this->response([
                'status' => true,
                'message' => 'Task deleted'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to delete task'
            ], 500);
        }
    }

    public function status(int $id, string $status): void
    {
        $validStatuses = ['open', 'in_progress', 'cancel', 'complete'];

        if (!in_array($status, $validStatuses)) {
            $this->response([
                'status' => false,
                'message' => 'Invalid status. Use: ' . implode(', ', $validStatuses)
            ], 400);
            return;
        }

        if ($this->task->markStatus($id, $status)) {
            $this->response([
                'status' => true,
                'message' => "Task marked as $status"
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => "Failed to mark task as $status"
            ], 500);
        }
    }

    private function response(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
