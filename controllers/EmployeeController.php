<?php
require_once 'models/Employee.php'; // Модель Employee для работы с сотрудниками
require_once 'models/PreviousJob.php'; // Модель PreviousJob для работы с предыдущими местами работы сотрудников

// Контроллер EmployeeController для управления действиями, связанными с сотрудниками
class EmployeeController {
    // Метод для отображения списка сотрудников
    public function index() {
        $employees = Employee::all();
        require 'views/employees/index.php';
    }

    // Метод для отображения формы создания нового сотрудника
    public function create() {
        require 'views/employees/create.php';
    }

    // Метод для сохранения нового сотрудника в базе данных
    public function store() {
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $birth_date = $_POST['birth_date'];
        $gender = $_POST['gender'];

        error_log("Storing new employee: $last_name, $first_name, $middle_name, $birth_date, $gender"); // Отладочная информация

        // Проверка на наличие обязательных полей
        if (empty($last_name) || empty($first_name) || empty($birth_date) || !isset($gender)) {
            http_response_code(400);
            echo json_encode(['error' => 'Required fields are missing.']);
            return;
        }

        // Создаем нового сотрудника через модель Employee
        $employee_id = Employee::create($last_name, $first_name, $middle_name, $birth_date, $gender);
        $new_employee = Employee::find($employee_id);

        error_log("New employee stored: " . print_r($new_employee, true)); // Отладочная информация

        header('Content-Type: application/json');
        echo json_encode($new_employee);
    }

    // Метод для получения данных о сотруднике для редактирования
    public function edit($id) {
        $employee = Employee::find($id);
        echo json_encode($employee);
    }

    // Метод для обновления данных сотрудника
    public function update($id) {
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $birth_date = $_POST['birth_date'];
        $gender = $_POST['gender'];

        if (empty($last_name) || empty($first_name) || empty($birth_date) || !isset($gender)) {
            http_response_code(400);
            echo json_encode(['error' => 'Required fields are missing.']);
            return;
        }

        // Обновляем данные сотрудника через модель Employee
        Employee::update($id, $last_name, $first_name, $middle_name, $birth_date, $gender);
        $updated_employee = Employee::find($id);

        header('Content-Type: application/json');
        echo json_encode($updated_employee);
    }

    // Метод для удаления сотрудника
    public function destroy($id) {
        Employee::delete($id);
        echo 'Success';
    }

    // Метод для добавления нового места работы для сотрудника
    public function addJob($employee_id) {
        // Получаем данные из POST-запроса
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $organization_name = $_POST['organization_name'];

        // Проверка на наличие обязательных полей
        if (empty($start_date) || empty($organization_name)) {
            http_response_code(400);
            echo json_encode(['error' => 'Required fields are missing.']);
            return;
        }

        // Создаем новое место работы через модель PreviousJob
        $job_id = PreviousJob::create($start_date, $end_date, $organization_name, $employee_id);
        $new_job = PreviousJob::find($job_id);
    
        header('Content-Type: application/json');
        echo json_encode($new_job);
    }

    // Метод для удаления места работы сотрудника
    public function deleteJob($job_id, $employee_id) {
        PreviousJob::delete($job_id);
        echo 'Success';
    }

    // Метод для получения всех мест работы сотрудника
    public function getJobs($employee_id) {
        $jobs = PreviousJob::all($employee_id);
        header('Content-Type: application/json');
        // Проверка, что данные корректно сериализуются в JSON
        error_log("Jobs data to return: " . print_r($jobs, true));
        // Отправляем данные клиенту
        echo json_encode($jobs);
    }

    // Метод для получения данных о конкретном месте работы
    public function getJobDetails($job_id) {
        $job = PreviousJob::find($job_id);
        header('Content-Type: application/json');
        echo json_encode($job);
    }

    // Метод для обновления данных о месте работы
    public function updateJob($job_id) {
        // Получаем данные из POST-запроса
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $organization_name = $_POST['organization_name'];

        // Проверка на наличие обязательных полей
        if (empty($start_date) || empty($organization_name)) {
            http_response_code(400);
            echo json_encode(['error' => 'Required fields are missing.']);
            return;
        }

        // Обновляем данные о месте работы через модель PreviousJob
        PreviousJob::update($job_id, $start_date, $end_date, $organization_name);
        $updated_job = PreviousJob::find($job_id);

        header('Content-Type: application/json');
        echo json_encode($updated_job);
    }


}