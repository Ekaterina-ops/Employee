<?php
require 'config.php';
require 'database.php';
require 'controllers/EmployeeController.php';

// Определяем, какой контроллер и действие должны быть выполнены на основе параметров URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'employee'; // Если параметр 'controller' не задан, используется значение 'employee' по умолчанию
$action = isset($_GET['action']) ? $_GET['action'] : 'index'; // Если параметр 'action' не задан, используется значение 'index' по умолчанию

// Выполняем действие в зависимости от значения контроллера
switch ($controller) {
    case 'employee':
        $employeeController = new EmployeeController(); // Создаем экземпляр класса EmployeeController для управления действиями сотрудников
        if ($action == 'index') {
            $employeeController->index(); // Вызов метода index для отображения списка сотрудников
        } elseif ($action == 'create') {
            $employeeController->create(); // Вызов метода create для отображения формы создания нового сотрудника
        } elseif ($action == 'store') {
            $employeeController->store(); // Вызов метода store для сохранения нового сотрудника в базе данных
        } elseif ($action == 'edit') {
            $id = $_GET['id'];
            $employeeController->edit($id); // Вызов метода edit для отображения формы редактирования данных сотрудника
        } elseif ($action == 'update') {
            $id = $_GET['id'];
            $employeeController->update($id); // Вызов метода update для обновления данных сотрудника в базе данных
        } elseif ($action == 'destroy') {
            $id = $_GET['id'];
            $employeeController->destroy($id); // Вызов метода destroy для удаления сотрудника из базы данных
        }elseif ($action == 'addJob') {
            $employee_id = $_GET['employee_id'];
            $employeeController->addJob($employee_id); // Вызов метода addJob для добавления нового места работы сотруднику
        } elseif ($action == 'deleteJob') {
            $job_id = $_GET['job_id'];
            $employee_id = $_GET['employee_id'];
            $employeeController->deleteJob($job_id, $employee_id); // Вызов метода deleteJob для удаления места работы сотрудника
        } elseif ($action == 'getJobs') {
            $employee_id = $_GET['employee_id'];
            $employeeController->getJobs($employee_id); // Вызов метода getJobs для получения всех мест работы сотрудника
        } elseif ($action == 'getJobDetails') {
            $job_id = $_GET['job_id'];
            $employeeController->getJobDetails($job_id); // Вызов метода getJobDetails для получения данных о конкретном месте работы
        } elseif ($action == 'updateJob') {
            $job_id = $_GET['job_id'];
            $employeeController->updateJob($job_id); // Вызов метода updateJob для обновления данных о месте работы
        }
        break;
}