-- Table to store user information
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Use a secure hashing algorithm like bcrypt
    email VARCHAR(255) NOT NULL UNIQUE,
    full_name VARCHAR(100),
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store expense categories
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


-- Table to store expenses
CREATE TABLE expenses (
    expense_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    category_id INT,
    description TEXT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    date DATE NOT NULL,
    paid BOOLEAN NOT NULL DEFAULT 0, -- 0 for not paid, 1 for paid
    payment_method VARCHAR(50),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

-- Table to store shared expenses
CREATE TABLE shared_expenses (
    shared_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    expense_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (expense_id) REFERENCES expenses(expense_id)
);

-- Table to store expense attachments
CREATE TABLE attachments (
    attachment_id INT AUTO_INCREMENT PRIMARY KEY,
    expense_id INT,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (expense_id) REFERENCES expenses(expense_id)
);
