-- 1. Tabla de Usuarios (Administrador)
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insertar usuario admin (Usuario: admin, Contraseña: 123)
INSERT INTO usuarios (usuario, password) VALUES ('admin', '123');

-- 2. Tabla de Salones
CREATE TABLE salones (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(150),
    descripcion TEXT,
    precio DECIMAL(10,2),
    capacidad INT,
    imagen_url VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE
);

-- Insertar los salones 
INSERT INTO salones (nombre, ubicacion, descripcion, precio, capacidad, imagen_url) VALUES 
('Salon Jardines del Norte', 'Av Manabi', 'Salón con vista al jardín, rodeado de naturaleza.', 350.00, 150, 'imagenes/salon jardin.jpg'),
('Salon La Hacienda', 'Av Machala', 'Localidad rústica y amplia, ambiente campestre.', 400.00, 300, 'imagenes/salon hacienda.jpg'),
('Gran Salon Luxury', 'Calle Juan Montalvo', 'Salón elegante y moderno para eventos de lujo.', 250.00, 100, 'imagenes/salon luxury.jpg');

-- 3. Tabla de Reservas
CREATE TABLE reservas (
    id SERIAL PRIMARY KEY,
    salon_id INT REFERENCES salones(id),
    cliente_nombre VARCHAR(100) NOT NULL,
    cliente_contacto VARCHAR(50) NOT NULL,
    fecha_evento DATE NOT NULL,
    hora_evento TIME NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente' -- Pendiente, Confirmada, Cancelada
);
