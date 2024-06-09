<?php
// Класс Employee для работы с данными сотрудников
class Employee {
    // Публичные свойства для хранения информации о сотруднике
    public $id;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $birth_date;
    public $gender;

    // Конструктор для инициализации объекта Employee
    public function __construct($id, $last_name, $first_name, $middle_name, $birth_date, $gender) {
        $this->id = $id;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->middle_name = $middle_name;
        $this->birth_date = $birth_date;
        $this->gender = $gender;
    }

    // Статический метод для получения всех сотрудников из базы данных
    public static function all() {
        $connection = connectDB();
        $sql = "SELECT * FROM employees";
        $result = $connection->query($sql);
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = new Employee($row['id'], $row['last_name'], $row['first_name'], $row['middle_name'], $row['birth_date'], $row['gender']);
        }
        return $employees;
    }

    // Статический метод для создания нового сотрудника в базе данных
    public static function create($last_name, $first_name, $middle_name, $birth_date, $gender) {
        $connection = connectDB();
        $stmt = $connection->prepare("INSERT INTO employees (last_name, first_name, middle_name, birth_date, gender) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $last_name, $first_name, $middle_name, $birth_date, $gender);
        $stmt->execute();
    }

    // Статический метод для получения данных о конкретном сотруднике по его ID
    public static function find($id) {
        $connection = connectDB();
        $stmt = $connection->prepare("SELECT * FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return new Employee($row['id'], $row['last_name'], $row['first_name'], $row['middle_name'], $row['birth_date'], $row['gender']);
    }

    // Статический метод для обновления данных сотрудника
    public static function update($id, $last_name, $first_name, $middle_name, $birth_date, $gender) {
        $connection = connectDB();
        $stmt = $connection->prepare("UPDATE employees SET last_name = ?, first_name = ?, middle_name = ?, birth_date = ?, gender = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $last_name, $first_name, $middle_name, $birth_date, $gender, $id);
        $stmt->execute();
    }

    // Статический метод для удаления сотрудника из базы данных
    public static function delete($id) {
        $connection = connectDB();
        $stmt = $connection->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}