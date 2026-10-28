DROP TABLE IF EXISTS inscripciones;

CREATE TABLE inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    cedula VARCHAR(50) NOT NULL,
    tipo_participante VARCHAR(50) NOT NULL,
    facultad VARCHAR(150) DEFAULT NULL,
    anio VARCHAR(10) DEFAULT NULL,
    comprobante VARCHAR(255) DEFAULT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


