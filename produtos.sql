CREATE DATABASE IF NOT EXISTS hadiofx;
USE hadiofx;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (username, password)
VALUES ('usuario123', SHA2('senha123', 256));

CREATE TABLE produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  imagem TEXT NOT NULL,
  quantidade INT NOT NULL
);