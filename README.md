Database config 
C:\wamp64\www\todolist\config\Database.php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'todolist_task'; 


Php version : 8.2

Folder Structure :

C:\wamp64\www\todolist


    config/autoload.php
    config/Database.php
    controllers/TaskController.php
    models/Task.php
    routes/api.php
    views/
    db/todolist_task.sql
    public
    .htaccess
    index.php
    README.md


How to test the API (via Postman )

# todolist

Api for todo list 

## Api Endpoints

- GET /tasks
- GET /tasks/{id}
- POST /tasks
- PUT /tasks/{id}
- DELETE /tasks/{id}
- PATCH /tasks/{id}/{status}

## Api Response

- GET /tasks
- GET /tasks/{id}
- POST /tasks
- PUT /tasks/{id}
- DELETE /tasks/{id}
- PATCH /tasks/{id}/{status}


## Api Request

Method: POST
URL: http://localhost/todolist/tasks

Body (raw JSON) :
{
    "title": "Task Title",
    "description": "Task Description"
}

/////////////////////////////////////

Method: GET
URL: http://localhost/todolist/tasks

Response :
{"status":true,
"message":"record found",
"data":{"id":"2","title":"Read a book","description":"Read 'Clean Code' today","status":"open","created_at":"2025-07-12 15:41:56","updated_at":"2025-07-12 17:02:27"}}

////////////////////////////////////

Method: GET
URL: http://localhost/todolist/tasks/2

Response :
{"status":true,
"message":"record found",
"data":{"id":"2","title":"Read a book","description":"Read 'Clean Code' today","status":"open","created_at":"2025-07-12 15:41:56","updated_at":"2025-07-12 17:02:27"}}

///////////////////////////

Method: PUT
URL: http://localhost/todolist/tasks/2

Body (raw JSON) :
{
    "title": "Task Title",
    "description": "Task Description"
}

/////////////////////////////////////

Method: DELETE
URL: http://localhost/todolist/tasks/2

Response :
{"status":true,
"message":"record deleted"}


///////////////////////////

Method: PATCH
URL: http://localhost/todolist/tasks/2

Body (raw JSON) :
{
    "status": "open"
}

Response :
{"status":true,
"message":"record updated"}

////////////////////////////////////

Method: PATCH
URL : http://localhost/todolist/tasks/2/complete

Response :
{"status":true,"message":"Task marked complete"}

////////////////////////////////////

Method: PATCH
URL : http://localhost/todolist/tasks/2/open

Response :
{"status":true,"message":"Task marked open"}

////////////////////////////////////
