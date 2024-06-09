// Функция для отображения сообщения на странице
// Принимает текст сообщения и его тип (например, 'success' или 'danger')
function showMessage(message, type) {
    // Добавляем сообщение в элемент с id 'messages' в виде Bootstrap-алерта
    $('#messages').html(`<div class="alert alert-${type}" role="alert">${message}</div>`);
    // Убираем сообщение через 3 секунды
    setTimeout(() => { $('#messages').html(''); }, 3000);
}

// Функция для открытия модального окна
// Принимает id модального окна и URL, на который будет отправлена форма
function openModal(modalId, actionUrl) {
    // Открываем модальное окно с указанным id
    $(modalId).modal('show');
    // Устанавливаем action формы внутри модального окна на указанный URL
    $(modalId + ' form').attr('action', actionUrl);
}

// Функция для обработки отправки формы
// Принимает id формы и id модального окна
function handleFormSubmit(formId, modalId) {
    // При попытке отправки формы
    $(formId).submit(function(event) {
        // Останавливаем стандартное поведение формы (отправку страницы)
        event.preventDefault();
        // Отправляем данные формы асинхронно через AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'), // URL, на который отправляется форма
            data: $(this).serialize(), // Сериализуем данные формы для отправки
            success: function(response) {
                // Если данные успешно сохранены, показываем сообщение и закрываем модальное окно
                showMessage('Changes saved successfully.', 'success');
                $(modalId).modal('hide');
                location.reload(); // Перезагружаем страницу для обновления данных
            },
            error: function(response) {
                // Если произошла ошибка, показываем сообщение об ошибке
                showMessage('There was an error saving the changes.', 'danger');
            }
        });
    });
}

// Функция для открытия модального окна редактирования сотрудника
// Принимает идентификатор сотрудника
function openEditModal(employeeId) {
    // Отправляем GET запрос для получения данных о сотруднике по его ID
    $.ajax({
        url: '/index.php?controller=employee&action=edit&id=' + employeeId,
        type: 'GET',
        success: function(response) {
            // Выводим полученные данные в консоль для отладки
            console.log('Employee data response:', response);  // Отладочная информация
            if (response) {
                // Если данные получены, разбираем их как JSON
                let employee = JSON.parse(response);
                // Заполняем форму редактирования данными сотрудника
                $('#last_name').val(employee.last_name);
                $('#first_name').val(employee.first_name);
                $('#middle_name').val(employee.middle_name);
                $('#birth_date').val(employee.birth_date);
                // Устанавливаем пол сотрудника в форме
                if (employee.gender == 1) {
                    $('#male').prop('checked', true);
                } else {
                    $('#female').prop('checked', true);
                }
                // Открываем модальное окно и устанавливаем action для обновления данных
                openModal('#employeeModal', '/index.php?controller=employee&action=update&id=' + employee.id);
            } else {
                // Если данные пустые, показываем сообщение об ошибке
                showMessage('Error: Empty response from server.', 'danger');
            }
        },
        error: function(response) {
            // Если произошла ошибка при получении данных, показываем сообщение об ошибке
            showMessage('Error fetching employee data.', 'danger');
        }
    });
}

// Функция для удаления сотрудника
// Принимает идентификатор сотрудника
function deleteEmployee(employeeId) {
    // Спрашиваем подтверждение у пользователя перед удалением
    if (confirm('Are you sure you want to delete this employee?')) {
        // Отправляем запрос на удаление сотрудника
        $.ajax({
            url: '/index.php?controller=employee&action=destroy&id=' + employeeId,
            type: 'POST',
            success: function(response) {
                // Если сотрудник успешно удален, показываем сообщение и перезагружаем страницу
                showMessage('Employee deleted successfully.', 'success');
                location.reload();
            },
            error: function(response) {
                // Если произошла ошибка при удалении, показываем сообщение об ошибке
                showMessage('There was an error deleting the employee.', 'danger');
            }
        });
    }
}

// Функция для открытия модального окна с опытом работы сотрудника
// Принимает идентификатор сотрудника
function openJobsModal(employeeId) {
    // Выводим сообщение в консоль для отладки
    console.log('Opening jobs modal for employee:', employeeId);  // Отладочная информация
    // Отправляем GET запрос для получения всех мест работы сотрудника
    $.ajax({
        url: '/index.php?controller=employee&action=getJobs&employee_id=' + employeeId,
        type: 'GET',
        success: function(data) {
            // Выводим данные в консоль для отладки
            console.log('Jobs data response:', data);  // Отладочная информация
            let jobs = data;  // Объект уже содержит данные
            let jobsTableBody = $('#jobsTableBody');
            jobsTableBody.empty(); // Очищаем таблицу от предыдущих данных
            if (jobs.length > 0) {
                // Если есть места работы, добавляем их в таблицу
                jobs.forEach(job => {
                    jobsTableBody.append(`
                        <tr data-job-id="${job.id}">
                            <td>${job.start_date}</td>
                            <td>${job.end_date}</td>
                            <td>${job.organization_name}</td>
                            <td>
                                <button class="btn btn-warning" onclick="openEditJobModal(${job.id}, ${employeeId})">Изменить</button>
                                <button class="btn btn-danger" onclick="deleteJob(${job.id}, ${employeeId})">Удалить</button>
                            </td>
                        </tr>
                    `);
                });
            } else {
                // Если мест работы нет, показываем сообщение
                console.log('No previous jobs found for employee:', employeeId);  // Отладочная информация
                $('#jobsModalLabel').text('Опыт работы сотрудника ');
                jobsTableBody.append('<tr><td colspan="4">Нет данных</td></tr>');
            }
            // Открываем модальное окно с опытом работы
            $('#jobsModal').modal('show');
            // Устанавливаем action формы для добавления нового места работы
            $('#addJobForm').attr('action', '/index.php?controller=employee&action=addJob&employee_id=' + employeeId);
            // Обрабатываем отправку формы добавления нового места работы
            handleJobFormSubmit(employeeId);
        },
        error: function(response) {
            // Если произошла ошибка при получении данных, показываем сообщение об ошибке
            showMessage('Error fetching jobs data.', 'danger');
        }
    });
}

// Функция для обработки отправки формы добавления места работы
// Принимает идентификатор сотрудника
function handleJobFormSubmit(employeeId) {
    $('#addJobForm').submit(function(event) {
        event.preventDefault();
        // Выводим сообщение в консоль для отладки
        console.log('Submitting job form for employee:', employeeId);  // Отладочная информация
        // Отправляем данные формы асинхронно через AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                // Если место работы успешно добавлено, показываем сообщение
                showMessage('Job added successfully.', 'success');
                // Добавляем новое место работы в таблицу
                let job = data;  // Объект уже содержит данные
                console.log('New job added:', job);  // Отладочная информация
                $('#jobsTableBody').append(`
                    <tr>
                        <td>${job.start_date}</td>
                        <td>${job.end_date}</td>
                        <td>${job.organization_name}</td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteJob(${job.id}, ${employeeId})">Удалить</button>
                        </td>
                    </tr>
                `);
                // Скрываем форму добавления места работы
                $('#jobForm').addClass('d-none');
                // Сбрасываем форму
                $('#addJobForm')[0].reset();
            },
            error: function(response) {
                // Если произошла ошибка при добавлении места работы, показываем сообщение об ошибке
                showMessage('There was an error adding the job.', 'danger');
            }
        });
    });
}

// Функция для открытия формы добавления нового места работы
function openAddJobForm() {
    $('#jobForm').removeClass('d-none'); // Показываем форму
}

// Функция для удаления места работы
// Принимает идентификатор места работы и идентификатор сотрудника
function deleteJob(jobId, employeeId) {
    $.ajax({
        url: '/index.php?controller=employee&action=deleteJob&job_id=' + jobId + '&employee_id=' + employeeId,
        type: 'POST',
        success: function(response) {
            // Если место работы успешно удалено, показываем сообщение
            showMessage('Job deleted successfully.', 'success');
            // Удаляем строку из таблицы с местами работы
            $(`#jobsTableBody tr`).has(`button[onclick="deleteJob(${jobId}, ${employeeId})"]`).remove();
        },
        error: function(response) {
            // Если произошла ошибка при удалении, показываем сообщение об ошибке
            showMessage('There was an error deleting the job.', 'danger');
        }
    });
}

// Выполняется при загрузке страницы
$(document).ready(function() {
    // Обрабатываем отправку формы редактирования сотрудника
    handleFormSubmit('#employeeForm', '#employeeModal');
});

// Функция для открытия модального окна редактирования места работы
// Принимает идентификатор места работы и идентификатор сотрудника
function openEditJobModal(jobId, employeeId) {
    $.ajax({
        url: '/index.php?controller=employee&action=getJobDetails&job_id=' + jobId,
        type: 'GET',
        success: function(data) {
            // Выводим данные в консоль для отладки
            console.log('Job data response:', data);  // Отладочная информация
            // Заполняем форму редактирования данными
            $('#edit_job_id').val(data.id);
            $('#edit_start_date').val(data.start_date);
            $('#edit_end_date').val(data.end_date);
            $('#edit_organization_name').val(data.organization_name);
            // Устанавливаем action формы для обновления места работы
            $('#editJobForm').attr('action', '/index.php?controller=employee&action=updateJob&job_id=' + jobId);
            // Открываем модальное окно редактирования места работы
            $('#editJobModal').modal('show');
        },
        error: function(response) {
            // Если произошла ошибка при получении данных, показываем сообщение об ошибке
            showMessage('Error fetching job data.', 'danger');
        }
    });
}

// Функция для обработки отправки формы редактирования места работы
function handleEditJobFormSubmit(employeeId) {
    $('#editJobForm').submit(function(event) {
        event.preventDefault();
        // Выводим сообщение в консоль для отладки
        console.log('Submitting edit job form for employee:', employeeId);  // Отладочная информация
        // Отправляем данные формы асинхронно через AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                // Если место работы успешно обновлено, показываем сообщение
                showMessage('Job updated successfully.', 'success');
                let job = data;  // Объект уже содержит данные
                console.log('Updated job:', job);  // Отладочная информация
                // Обновляем строку в таблице с местами работы
                $(`#jobsTableBody tr[data-job-id="${job.id}"]`).replaceWith(`
                    <tr data-job-id="${job.id}">
                        <td>${job.start_date}</td>
                        <td>${job.end_date}</td>
                        <td>${job.organization_name}</td>
                        <td>
                            <button class="btn btn-warning" onclick="openEditJobModal(${job.id}, ${employeeId})">Изменить</button>
                            <button class="btn btn-danger" onclick="deleteJob(${job.id}, ${employeeId})">Удалить</button>
                        </td>
                    </tr>
                `);
                // Закрываем модальное окно редактирования
                $('#editJobModal').modal('hide');
            },
            error: function(response) {
                // Если произошла ошибка при обновлении, показываем сообщение об ошибке
                showMessage('There was an error updating the job.', 'danger');
            }
        });
    });
}

// Выполняется при загрузке страницы
$(document).ready(function() {
    // Обрабатываем отправку формы редактирования места работы
    handleEditJobFormSubmit();
});
