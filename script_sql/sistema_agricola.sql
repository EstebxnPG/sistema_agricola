/* SENTENCIA SQL PARA EL PROYECTO, NUESTRA BASE DE DATOS. */

CREATE DATABASE sistema_agricola;
use sistema_agricola;

-- Crear la base de datos
CREATE DATABASE sistema_agricola;
USE sistema_agricola;

-- Tabla Agricultor
CREATE TABLE agricultor (
    id_agricultor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    documento VARCHAR(50) UNIQUE NOT NULL,
    contacto VARCHAR(50),
    email VARCHAR(100)
);

-- Tabla Colaborador
CREATE TABLE colaborador (
    id_colaborador INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    documento VARCHAR(50) UNIQUE NOT NULL,
    cargo VARCHAR(50),
    contacto VARCHAR(50),
    id_agricultor INT,
    FOREIGN KEY (id_agricultor) REFERENCES agricultor(id_agricultor)
        ON DELETE CASCADE
);

-- Tabla Cultivo
CREATE TABLE cultivo (
    id_cultivo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_siembra DATE,
    ubicacion VARCHAR(100),
    id_agricultor INT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_agricultor) REFERENCES agricultor(id_agricultor)
        ON DELETE CASCADE
);

-- Tabla HerramientaMaquinaria
CREATE TABLE herramienta_maquinaria (
    id_herramienta INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50),
    referencia VARCHAR(100),
    estado VARCHAR(50),
    fecha_compra DATE,
    id_agricultor INT,
    FOREIGN KEY (id_agricultor) REFERENCES agricultor(id_agricultor)
        ON DELETE CASCADE
);

-- Tabla Evento
CREATE TABLE evento (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('riego', 'fertilizacion', 'mantenimiento', 'otro') NOT NULL,
    fecha_evento DATE NOT NULL,
    descripcion TEXT,
    id_cultivo INT,
    FOREIGN KEY (id_cultivo) REFERENCES cultivo(id_cultivo)
        ON DELETE CASCADE
);

-- Tabla InsumoUsado
CREATE TABLE insumo_usado (
    id_insumo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    cantidad DECIMAL(10, 2),
    unidad VARCHAR(20),
    id_cultivo INT,
    FOREIGN KEY (id_cultivo) REFERENCES cultivo(id_cultivo)
        ON DELETE CASCADE
);

-- Tabla Notificación
CREATE TABLE notificacion (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    mensaje TEXT NOT NULL,
    tipo ENUM('SMS', 'Push') NOT NULL,
    fecha_envio DATETIME NOT NULL,
    estado ENUM('enviada', 'fallida') DEFAULT 'enviada',
    id_evento INT,
    id_agricultor INT,
    FOREIGN KEY (id_evento) REFERENCES evento(id_evento)
        ON DELETE SET NULL,
    FOREIGN KEY (id_agricultor) REFERENCES agricultor(id_agricultor)
        ON DELETE CASCADE
);

-- Tabla Documento
CREATE TABLE documento (
    id_documento INT AUTO_INCREMENT PRIMARY KEY,
    tipo_documento VARCHAR(50),
    nombre_archivo VARCHAR(100),
    ruta_archivo TEXT,
    fecha_subida DATETIME,
    id_agricultor INT,
    FOREIGN KEY (id_agricultor) REFERENCES agricultor(id_agricultor)
        ON DELETE CASCADE
);
