CREATE DATABASE IF NOT EXISTS crud_example;
USE crud_example;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS setores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS usuario_setor (
    id_usuario INT,
    id_setor INT,
    PRIMARY KEY (id_usuario, id_setor),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_setor) REFERENCES setores(id)
);
