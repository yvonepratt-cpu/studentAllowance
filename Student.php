<?php
class Student {
    private $conn;
    private $table = "students"; 
    public $id;
    public $name;   
    public $course;
    public $year_level;
    public $allowance;

    public function __construct($db){

        if (!($db instanceof PDO)) {
            throw new InvalidArgumentException('Student::__construct expects a PDO instance. Given: ' . gettype($db));
        }
        $this->conn = $db;

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    private function prepareStatement(string $sql): PDOStatement {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            $err = $this->conn->errorInfo();
            throw new RuntimeException("Failed to prepare SQL: {$sql} | SQLSTATE: {$err[0]} | Code: {$err[1]} | Msg: {$err[2]}");
        }
        return $stmt;
    }


    public function create(): bool {

        $sql = "INSERT INTO {$this->table} (name, course, year_level, allowance)
                VALUES (:name, :course, :year_level, :allowance)";
        try {
            $stmt = $this->prepareStatement($sql);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->course = htmlspecialchars(strip_tags($this->course));
            $this->year_level = htmlspecialchars(strip_tags($this->year_level));
            $this->allowance = is_numeric($this->allowance) ? (float)$this->allowance : 0.0;

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':course', $this->course);
            $stmt->bindParam(':year_level', $this->year_level);
            $stmt->bindParam(':allowance', $this->allowance);

            return $stmt->execute();
        } catch (Exception $e) {
            throw new RuntimeException("Student::create failed: " . $e->getMessage(), 0, $e);
        }
    }

    public function readAll(): PDOStatement {
        $sql = "SELECT * FROM {$this->table} ORDER BY date_added DESC";
        try {
            $stmt = $this->prepareStatement($sql);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new RuntimeException("Student::readAll failed: " . $e->getMessage(), 0, $e);
        }
    }

    public function readOne() {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        try {
            $stmt = $this->prepareStatement($sql);
            $this->id = intval($this->id);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new RuntimeException("Student::readOne failed: " . $e->getMessage(), 0, $e);
        }
    }

    public function update(): bool {

        $sql = "UPDATE {$this->table}
                SET name = :name, course = :course, year_level = :year_level, allowance = :allowance
                WHERE id = :id";
        try {
            $stmt = $this->prepareStatement($sql);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->course = htmlspecialchars(strip_tags($this->course));
            $this->year_level = htmlspecialchars(strip_tags($this->year_level));
            $this->allowance = is_numeric($this->allowance) ? (float)$this->allowance : 0.0;
            $this->id = intval($this->id);

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':course', $this->course);
            $stmt->bindParam(':year_level', $this->year_level);
            $stmt->bindParam(':allowance', $this->allowance);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (Exception $e) {
            throw new RuntimeException("Student::update failed: " . $e->getMessage(), 0, $e);
        }
    }

    public function delete(): bool {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        try {
            $stmt = $this->prepareStatement($sql);
            $this->id = intval($this->id);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            throw new RuntimeException("Student::delete failed: " . $e->getMessage(), 0, $e);
        }
    }

    public function totalAllowance(): float {
        $sql = "SELECT SUM(allowance) AS total FROM {$this->table}";
        try {
            $stmt = $this->prepareStatement($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return isset($row['total']) ? (float)$row['total'] : 0.0;
        } catch (Exception $e) {
            throw new RuntimeException("Student::totalAllowance failed: " . $e->getMessage(), 0, $e);
        }
    }
}
?>
