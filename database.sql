-- Base de datos para Clínica Veterinaria
-- Database for Veterinary Clinic

CREATE DATABASE IF NOT EXISTS veterinaria_db;
USE veterinaria_db;

-- Tabla de Clientes (Clients/Owners)
CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    direccion VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Veterinarios (Veterinarians)
CREATE TABLE IF NOT EXISTS veterinarios (
    id_veterinario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100),
    telefono VARCHAR(20),
    email VARCHAR(100),
    fecha_contratacion DATE
);

-- Tabla de Mascotas (Pets)
CREATE TABLE IF NOT EXISTS mascotas (
    id_mascota INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raza VARCHAR(100),
    edad INT,
    peso DECIMAL(5,2),
    id_cliente INT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE
);

-- Tabla de Citas (Appointments)
CREATE TABLE IF NOT EXISTS citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_mascota INT NOT NULL,
    id_veterinario INT NOT NULL,
    fecha_cita DATETIME NOT NULL,
    motivo VARCHAR(255),
    estado VARCHAR(50) DEFAULT 'Pendiente',
    observaciones TEXT,
    FOREIGN KEY (id_mascota) REFERENCES mascotas(id_mascota) ON DELETE CASCADE,
    FOREIGN KEY (id_veterinario) REFERENCES veterinarios(id_veterinario) ON DELETE CASCADE
);

-- Tabla de Tratamientos (Treatments)
CREATE TABLE IF NOT EXISTS tratamientos (
    id_tratamiento INT AUTO_INCREMENT PRIMARY KEY,
    id_cita INT NOT NULL,
    descripcion TEXT NOT NULL,
    medicamentos TEXT,
    costo DECIMAL(10,2),
    fecha_tratamiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cita) REFERENCES citas(id_cita) ON DELETE CASCADE
);

-- Insertar datos de ejemplo (Sample data)

-- Clientes de ejemplo
INSERT INTO clientes (nombre, apellido, telefono, email, direccion) VALUES
('Juan', 'Pérez', '555-0101', 'juan.perez@email.com', 'Calle Principal 123'),
('María', 'González', '555-0102', 'maria.gonzalez@email.com', 'Avenida Central 456'),
('Carlos', 'Rodríguez', '555-0103', 'carlos.rodriguez@email.com', 'Calle Secundaria 789');

-- Veterinarios de ejemplo
INSERT INTO veterinarios (nombre, apellido, especialidad, telefono, email, fecha_contratacion) VALUES
('Dr. Ana', 'Martínez', 'Cirugía', '555-0201', 'ana.martinez@veterinaria.com', '2020-01-15'),
('Dr. Pedro', 'López', 'Medicina General', '555-0202', 'pedro.lopez@veterinaria.com', '2019-06-20'),
('Dra. Laura', 'Sánchez', 'Dermatología', '555-0203', 'laura.sanchez@veterinaria.com', '2021-03-10');

-- Mascotas de ejemplo
INSERT INTO mascotas (nombre, especie, raza, edad, peso, id_cliente) VALUES
('Max', 'Perro', 'Labrador', 3, 25.5, 1),
('Luna', 'Gato', 'Siamés', 2, 4.2, 1),
('Rocky', 'Perro', 'Pastor Alemán', 5, 35.0, 2),
('Mimi', 'Gato', 'Persa', 1, 3.8, 3);

-- Citas de ejemplo
INSERT INTO citas (id_mascota, id_veterinario, fecha_cita, motivo, estado, observaciones) VALUES
(1, 1, '2026-01-20 10:00:00', 'Consulta de rutina', 'Pendiente', 'Primera consulta del año'),
(2, 3, '2026-01-21 14:30:00', 'Problema de piel', 'Pendiente', 'Cliente reporta picazón'),
(3, 2, '2026-01-22 11:00:00', 'Vacunación', 'Confirmada', 'Vacuna antirrábica');

-- Tratamientos de ejemplo
INSERT INTO tratamientos (id_cita, descripcion, medicamentos, costo) VALUES
(1, 'Revisión general y vacunación', 'Vacuna múltiple, Desparasitante', 850.00),
(2, 'Tratamiento dermatológico', 'Antibiótico tópico, Antihistamínico', 650.00);
