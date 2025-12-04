CREATE DATABASE IF NOT EXISTS projet_web;

USE projet_web;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Ecole', 'Entreprise', 'Simple Utilisateur') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
