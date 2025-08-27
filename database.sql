-- database.sql - Database schema for College Expenditure Monitoring & UC Generator

-- Create database
CREATE DATABASE IF NOT EXISTS college_expense_tracker;
USE college_expense_tracker;

-- Create expenditures table
CREATE TABLE IF NOT EXISTS expenditures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    date DATE NOT NULL,
    category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create utilisation_certificates table
CREATE TABLE IF NOT EXISTS utilisation_certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create uc_expenditures table (junction table for many-to-many relationship)
CREATE TABLE IF NOT EXISTS uc_expenditures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uc_id INT NOT NULL,
    expenditure_id INT NOT NULL,
    FOREIGN KEY (uc_id) REFERENCES utilisation_certificates(id) ON DELETE CASCADE,
    FOREIGN KEY (expenditure_id) REFERENCES expenditures(id) ON DELETE CASCADE,
    UNIQUE KEY unique_uc_expenditure (uc_id, expenditure_id)
);

-- Insert sample data
INSERT INTO expenditures (item_name, amount, date, category) VALUES
('Office Stationery', 1500.00, '2023-01-15', 'stationery'),
('Printer Maintenance', 3000.00, '2023-01-20', 'maintenance'),
('Annual Day Event', 15000.00, '2023-02-10', 'events'),
('Faculty Salaries', 50000.00, '2023-02-28', 'salary');

INSERT INTO utilisation_certificates (title, description) VALUES
('January Stationery Expenses', 'Utilization certificate for office stationery purchased in January'),
('January Maintenance Expenses', 'Utilization certificate for printer maintenance in January');

INSERT INTO uc_expenditures (uc_id, expenditure_id) VALUES
(1, 1),
(2, 2);