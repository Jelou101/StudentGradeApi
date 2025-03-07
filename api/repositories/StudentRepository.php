<?php

require_once "config/Database.php";
require_once "models/Student.php";
require_once "contracts/IBaseRepository.php";

class StudentRepository implements IBaseRepository {
    protected $databaseContext;
    protected $table;

    public function __construct($databaseContext, $table = 'students') {
        $this->databaseContext = $databaseContext;
        $this->table = $table;
    }

    public function GetAllList() : array {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->ExecuteSqlQuery($query, []);
        return $this->BuildResultList($result);
    }

    public function GetById(int $id) : ?object {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $result = $this->ExecuteSqlQuery($query, [$id]);
        return $result ? $this->BuildResult($result[0]) : null;
    }

    public function Add(object $entity) : bool {
        $query = "INSERT INTO {$this->table} (name, midterm_score, final_score, final_grade, status) VALUES (?, ?, ?, ?, ?)";
        $params = [
            $entity->name,
            $entity->midterm_score,
            $entity->final_score,
            $entity->final_grade,
            $entity->status
        ];
        return $this->ExecuteSqlNonQuery($query, $params);
    }

    public function Update(object $entity) : bool {
        $query = "UPDATE {$this->table} SET name = ?, midterm_score = ?, final_score = ?, final_grade = ?, status = ? WHERE id = ?";
        $params = [
            $entity->name,
            $entity->midterm_score,
            $entity->final_score,
            $entity->final_grade,
            $entity->status,
            $entity->id
        ];
        return $this->ExecuteSqlNonQuery($query, $params);
    }

    public function Delete(int $id) : bool {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->ExecuteSqlNonQuery($query, [$id]);
    }

    protected function ExecuteSqlQuery(string $query, array $params) : array {
        $stmt = $this->databaseContext->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function ExecuteSqlNonQuery(string $query, array $params) : bool {
        $stmt = $this->databaseContext->prepare($query);
        return $stmt->execute($params);
    }

    protected function BuildResult(array $row) : object {
        return new Student(
            $row['id'],
            $row['name'],
            $row['midterm_score'],
            $row['final_score'],
            $row['final_grade'],
            $row['status']
        );
    }

    protected function BuildResultList(array $rows) : array {
        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->BuildResult($row);
        }
        return $result;
    }
}
?>
