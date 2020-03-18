<?php

namespace App\Controller;

use Exception;

class TaskController extends Controller
{
    public function index()
    {
        $data = require_once 'data.php';
        $this->render(["data" => $data]);
    }

    public function show()
    {
        $data = require_once "data.php";
        $id = $this->currentRoute['id'];
        if (!$id || !array_key_exists($id, $data)) {
            throw new Exception("La tâche demandée n'existe pas !");
        }
        $task = $data[$id];
        $this->render(["task" => $task]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->render(['data' => $_POST]);
            return;
        }
        $this->render();
    }
}
