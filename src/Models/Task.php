<?php
// src/Models/Task.php
namespace App\Models;

use PDO;

class Task
{
    public function __construct(private PDO $db) {}

    public function all(?string $q = null, ?int $status = null): array
    {
        $sql = "SELECT * FROM tasks WHERE 1=1";
        $params = [];

        if ($q !== null && $q !== '') {
            $sql .= " AND (title LIKE :q OR description LIKE :q)";
            $params[':q'] = "%{$q}%";
        }
        if ($status !== null && $status !== -1) {
            if ((int)$status === 99) {
                $sql .= " AND status <> 2"; // Not done
            } else {
                $sql .= " AND status = :status";
                $params[':status'] = $status;
            }
        }

        $sql .= " ORDER BY due_date IS NULL, due_date ASC, created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO tasks (title, description, status, due_date)
            VALUES (:title, :description, :status, :due_date)
        ");
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':status' => (int)($data['status'] ?? 0),
            ':due_date' => $data['due_date'] ?: null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE tasks
            SET title=:title, description=:description, status=:status, due_date=:due_date
            WHERE id=:id
        ");
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':status' => (int)($data['status'] ?? 0),
            ':due_date' => $data['due_date'] ?: null,
            ':id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id=:id");
        return $stmt->execute([':id' => $id]);
    }

    public function toggleDone(int $id): bool
    {
        $task = $this->find($id);
        if (!$task) return false;
        $new = ((int)$task['status'] === 2) ? 0 : 2; // 2=done
        $stmt = $this->db->prepare("UPDATE tasks SET status=:s WHERE id=:id");
        return $stmt->execute([':s' => $new, ':id' => $id]);
    }

        /** Označi task dovršenim: status=2, closed_at=NOW(), upisuje spent_minutes */
        public function complete(int $id, int $spentMinutes): bool
        {
            $spent = max(0, $spentMinutes);
            $stmt = $this->db->prepare("
                UPDATE tasks
                SET status = 2,
                    spent_minutes = :spent,
                    closed_at = NOW()
                WHERE id = :id
            ");
            return $stmt->execute([':spent' => $spent, ':id' => $id]);
        }
    
        /** Ponovno otvori task: status=0, poništi closed_at i spent_minutes */
        public function reopen(int $id): bool
        {
            $stmt = $this->db->prepare("
                UPDATE tasks
                SET status = 0,
                    spent_minutes = NULL,
                    closed_at = NULL
                WHERE id = :id
            ");
            return $stmt->execute([':id' => $id]);
        }
}
