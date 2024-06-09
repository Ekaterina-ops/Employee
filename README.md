# Employee Management System

Employee Management System is a simple web application that allows you to manage employee records and their previous job experiences. The application is built using PHP and MySQL without any frameworks, making it easy to understand and modify for beginners.

## Features

- Add new employees
- Edit existing employee details
- Delete employees
- Add previous job experiences for employees
- Edit and delete job experiences
- Display employee information and their job experiences in a table

## Prerequisites

- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web server (e.g., Apache, Nginx)
- Browser

## Getting Started

1. Clone the repository to your local machine:
    ```bash
    git clone https://github.com/Ekaterina-ops/Employee.git
    ```

2. Navigate to the project directory:
    ```bash
    cd employee
    ```

3. Set up your local web server to serve the files in this directory.

4. Create the database and tables using the script below:

### Database Setup

Run the following SQL script to create the database and tables required for the application:

```sql
-- Create database
CREATE DATABASE employee_management;

-- Use the database
USE employee_management;

-- Create employees table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    last_name VARCHAR(50) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    birth_date DATE NOT NULL,
    gender TINYINT(1) NOT NULL
);

-- Create previous_jobs table
CREATE TABLE previous_jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    start_date DATE NOT NULL,
    end_date DATE,
    organization_name VARCHAR(100) NOT NULL,
    employee_id INT,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

-- Use the database
USE employee_management;

-- Insert test employees
INSERT INTO employees (last_name, first_name, middle_name, birth_date, gender) VALUES
('Иванов', 'Иван', 'Иванович', '1990-01-01', 1),
('Петрова', 'Анна', 'Сергеевна', '1992-05-12', 0),
('Сидоров', 'Алексей', 'Петрович', '1988-11-23', 1),
('Кузнецова', 'Мария', 'Александровна', '1995-07-08', 0),
('Ковалев', 'Дмитрий', 'Николаевич', '1985-03-15', 1),
('Григорьева', 'Ольга', 'Михайловна', '1993-10-22', 0);

-- Insert test previous jobs
INSERT INTO previous_jobs (start_date, end_date, organization_name, employee_id) VALUES
('2010-01-01', '2015-01-01', 'ООО Альфа', 1),
('2015-02-01', '2018-01-01', 'ЗАО Бета', 1),
('2018-03-01', NULL, 'ИП Гамма', 1),

('2011-01-01', '2014-01-01', 'ООО Дельта', 2),
('2014-02-01', '2017-01-01', 'ЗАО Эпсилон', 2),
('2017-03-01', NULL, 'ИП Зета', 2),

('2009-01-01', '2012-01-01', 'ООО Этап', 3),
('2012-02-01', '2016-01-01', 'ЗАО Уран', 3),
('2016-03-01', NULL, 'ИП Квадрат', 3),

('2010-01-01', '2014-01-01', 'ООО Триада', 4),
('2014-02-01', '2018-01-01', 'ЗАО Старт', 4),
('2018-03-01', NULL, 'ИП Градиент', 4),

('2008-01-01', '2012-01-01', 'ООО Радар', 5),
('2012-02-01', '2015-01-01', 'ЗАО Линия', 5),
('2015-03-01', NULL, 'ИП Ось', 5),

('2011-01-01', '2013-01-01', 'ООО Метр', 6),
('2013-02-01', '2016-01-01', 'ЗАО Вектор', 6),
('2016-03-01', NULL, 'ИП Синус', 6);

