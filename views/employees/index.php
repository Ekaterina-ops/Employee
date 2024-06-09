<?php require 'views/layout/header.php'; ?>
<h1>Сотрудники</h1>
<button class="btn btn-primary" onclick="openModal('#employeeModal', '/index.php?controller=employee&action=store')">Добавить сотрудника</button> <!-- Вызов функции openModal для открытия модального окна с формой добавления сотрудника -->
    <!-- Таблица для отображения списка сотрудников -->
<table class="table">
    <thead>
        <tr>
            <th>ФИО сотрудника</th>
            <th>Дата рождения</th>
            <th>Пол</th>
            <th>Опыт работы</th>
            <th>Изменить</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $employee): ?>
        <tr>
            <td><?= $employee->last_name ?> <?= $employee->first_name ?> <?= $employee->middle_name ?></td>
            <td><?= $employee->birth_date ?></td>
            <td><?= $employee->gender ? 'Мужской' : 'Женский' ?></td>
            <td>
                <button class="btn btn-info" onclick="openJobsModal(<?= $employee->id ?>)">Опыт работы</button>
            </td>
            <td>
                <button class="btn btn-warning" onclick="openEditModal(<?= $employee->id ?>)">Изменить</button>
                <button class="btn btn-danger" onclick="deleteEmployee(<?= $employee->id ?>)">Удалить</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <!-- Модальное окно для добавления и редактирования данных сотрудника -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModalLabel">Сотрудник</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Форма для добавления или редактирования данных сотрудника -->
                <form id="employeeForm">
                    <div class="form-group">
                        <label for="last_name">Фамилия</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="first_name">Имя</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="middle_name">Отчество</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Дата рождения</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                    </div>
                    <div class="form-group">
                        <label>Gender</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="male" name="gender" value="1" required>
                            <label class="form-check-label" for="male">Мужской</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="female" name="gender" value="0" required>
                            <label class="form-check-label" for="female">Женский</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Модальное окно для отображения опыта работы сотрудника -->
<div class="modal fade" id="jobsModal" tabindex="-1" aria-labelledby="jobsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobsModalLabel">Опыт работы</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary mb-3" onclick="openAddJobForm()">Добавить</button>
                <div id="jobForm" class="d-none">
                    <!-- Форма для добавления нового места работы -->
                    <form id="addJobForm">
                        <div class="form-group">
                            <label for="start_date">Дата начала</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Дата окончания</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                        <div class="form-group">
                            <label for="organization_name">Название организации</label>
                            <input type="text" class="form-control" id="organization_name" name="organization_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
                <!-- Таблица для отображения мест работы сотрудника -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Дата начала</th>
                            <th>Дата окончания</th>
                            <th>Название организации</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="jobsTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Модальное окно для отображения опыта работы сотрудника -->
    <div class="modal fade" id="jobsModal" tabindex="-1" aria-labelledby="jobsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobsModalLabel">Опыт работы</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-primary mb-3" onclick="openAddJobForm()">Add Job</button>
                    <div id="jobForm" class="d-none">
                        <!-- Форма для добавления нового места работы -->
                        <form id="addJobForm">
                            <div class="form-group">
                                <label for="start_date">Дата начала</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Дата окончания</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                            <div class="form-group">
                                <label for="organization_name">Название организации</label>
                                <input type="text" class="form-control" id="organization_name" name="organization_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </form>
                    </div>
                    <!-- Таблица для отображения мест работы сотрудника -->
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Дата начала</th>
                            <th>Дата окончания</th>
                            <th>Название организации</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="jobsTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для редактирования места работы -->
    <div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJobModalLabel">Редактировать опыт</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Форма для редактирования места работы -->
                    <form id="editJobForm">
                        <input type="hidden" id="edit_job_id" name="job_id">
                        <div class="form-group">
                            <label for="edit_start_date">Дата начала</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_end_date">Дата окончания</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date">
                        </div>
                        <div class="form-group">
                            <label for="edit_organization_name">Название организации</label>
                            <input type="text" class="form-control" id="edit_organization_name" name="organization_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php require 'views/layout/footer.php'; ?>