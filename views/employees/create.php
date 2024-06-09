<?php require 'views/layout/header.php'; ?>
<h1>Добавление сотрудника</h1>
    <!-- Форма для добавления нового сотрудника -->
<form action="/index.php?controller=employee&action=store" method="POST">
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
<?php require 'views/layout/footer.php'; ?>