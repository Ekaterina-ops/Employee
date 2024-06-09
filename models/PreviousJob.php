<?php
// Класс PreviousJob для работы с данными о предыдущих местах работы
class PreviousJob {
    // Публичные свойства для хранения информации о предыдущем месте работы
    public $id;
    public $start_date;
    public $end_date;
    public $organization_name;
    public $employee_id;

    // Конструктор для инициализации объекта PreviousJob
    public function __construct($id, $start_date, $end_date, $organization_name, $employee_id) {
        $this->id = $id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->organization_name = $organization_name;
        $this->employee_id = $employee_id;
    }

    // Статический метод для получения всех мест работы сотрудника по его ID
    public static function all($employee_id) {
        $connection = connectDB();
        $stmt = $connection->prepare("SELECT * FROM previous_jobs WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $previous_jobs = [];
        while ($row = $result->fetch_assoc()) {
            $previous_jobs[] = new PreviousJob($row['id'], $row['start_date'], $row['end_date'], $row['organization_name'], $row['employee_id']);
        }
        $stmt->close();
        $connection->close();

        // Запись отладочной информации
        error_log("Fetched jobs for employee_id $employee_id: " . print_r($previous_jobs, true));
        return $previous_jobs;
    }

    // Статический метод для создания нового места работы
    public static function create($start_date, $end_date, $organization_name, $employee_id) {
        $connection = connectDB();
        $stmt = $connection->prepare("INSERT INTO previous_jobs (start_date, end_date, organization_name, employee_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $start_date, $end_date, $organization_name, $employee_id);
        $stmt->execute();
        return $stmt->insert_id; // Возвращаем ID новой записи
    }

    // Статический метод для обновления данных о месте работы
    public static function update($id, $start_date, $end_date, $organization_name) {
        $connection = connectDB();
        $stmt = $connection->prepare("UPDATE previous_jobs SET start_date = ?, end_date = ?, organization_name = ? WHERE id = ?");
        $stmt->bind_param("sssi", $start_date, $end_date, $organization_name, $id);
        $stmt->execute();
    }

    // Статический метод для удаления места работы
    public static function delete($id) {
        $connection = connectDB();
        $stmt = $connection->prepare("DELETE FROM previous_jobs WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Статический метод для получения данных о конкретном месте работы по его ID
    public static function find($id) {
        $connection = connectDB();
        $stmt = $connection->prepare("SELECT * FROM previous_jobs WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Возвращаем массив с данными
    }



}