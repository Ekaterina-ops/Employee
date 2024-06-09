<?php require 'views/layout/header.php'; ?>
<h1>Редактирование данных сотрудника</h1>
    <!-- Форма для редактирования данных сотрудника -->
<form action="/index.php?controller=employee&action=update&id=<?= $employee->id ?>" method="POST"> <!-- В action передаем ID сотрудника, которого редактируем, и указываем, что данные будут обработаны методом update контроллера employee -->
    <div class="form-group">
        <label for="last_name">Фамилия</label>
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $employee->last_name ?>" required>
    </div>
    <div class="form-group">
        <label for="first_name">Имя</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $employee->first_name ?>" required>
    </div>
    <div class="form-group">
        <label for="middle_name">Отчество</label>
        <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= $employee->middle_name ?>">
    </div>
    <div class="form-group">
        <label for="birth_date">Дата рождения</label>
        <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?= $employee->birth_date ?>" required>
    </div>
    <div class="form-group">
        <label>Пол</label><br>
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

    <!-- Форма для добавления нового места работы -->
<h2>Опыт работы</h2>
<form action="/index.php?controller=employee&action=addJob&employee_id=<?= $employee->id ?>" method="POST"><!-- В action передаем ID сотрудника, для которого добавляем место работы, и указываем, что данные будут обработаны методом addJob контроллера employee -->
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
    <button type="submit" class="btn btn-primary">Добавить место работы</button>
</form>

    <!-- Таблица для отображения предыдущих мест работы -->
<table class="table">
    <thead>
        <tr>
            <th>Дата начала</th>
            <th>Дата окончания</th>
            <th>Название организации</th>
            <th>Редактировать</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($previous_jobs as $job): ?>
        <tr>
            <td><?= $job->start_date ?></td>
            <td><?= $job->end_date ?></td>
            <td><?= $job->organization_name ?></td>
            <td>
                <form action="/index.php?controller=employee&action=deleteJob&job_id=<?= $job->id ?>&employee_id=<?= $employee->id ?>" method="POST" style="display:inline-block;">
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require 'views/layout/footer.php'; ?>