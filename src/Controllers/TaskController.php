<?php
// src/Controllers/TaskController.php
namespace App\Controllers;

use App\Models\Task;
use PDO;

class TaskController
{
    public function __construct(private PDO $db) {}

    public function index(): void
    {
        $model = new Task($this->db);
        $q = $_GET['q'] ?? null;
        $status = isset($_GET['status']) ? (int)$_GET['status'] : 0;
        $tasks = $model->all($q, $status);
        require __DIR__ . '/../../views/tasks/index.php';
    }

    public function store(): void
    {
        $model = new Task($this->db);
        $id = $model->create([
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'status' => (int)($_POST['status'] ?? 0),
            'due_date' => $_POST['due_date'] ?? null,
        ]);
        redirect(''); // back to list
    }

    public function update(): void
    {
        $model = new Task($this->db);
        $id = (int)($_POST['id'] ?? 0);
        $model->update($id, [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'status' => (int)($_POST['status'] ?? 0),
            'due_date' => $_POST['due_date'] ?? null,
        ]);
        redirect('');
    }

    public function destroy(): void
    {
        $model = new Task($this->db);
        $id = (int)($_POST['id'] ?? 0);
        $model->delete($id);
        redirect('');
    }

    public function toggle(): void
    {
        $model = new Task($this->db);
        $id = (int)($_POST['id'] ?? 0);
        $model->toggleDone($id);
        redirect('');
    }

    public function complete(): void
    {
        $model = new Task($this->db);
        $id = (int)($_POST['id'] ?? 0);
        $spent = (int)($_POST['spent_minutes'] ?? 0);

        // hardening minimal: non-negative
        if ($id > 0) {
            $model->complete($id, max(0, $spent));
        }
        redirect('');
    }

    public function reopen(): void
    {
        $model = new Task($this->db);
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $model->reopen($id);
        }
        redirect('');
    }
}
