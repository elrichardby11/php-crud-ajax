CREATE TABLE REGION (
    ID INT PRIMARY KEY,
    NAME VARCHAR(50)
);

CREATE TABLE COMUNA (
    ID INT PRIMARY KEY,
    NAME VARCHAR(50),
    ID_REGION INT,
    FOREIGN KEY (ID_REGION) REFERENCES REGION(ID)
);

CREATE TABLE CIUDAD (
    ID INT PRIMARY KEY,
    NAME VARCHAR(50),
    ID_COMUNA INT,
    FOREIGN KEY (ID_COMUNA) REFERENCES COMUNA(ID)
);

CREATE TABLE CATEGORIA (
    ID INT PRIMARY KEY,
    NAME VARCHAR(50)
);

CREATE TABLE EMPRESAS (
    RUT VARCHAR(8) PRIMARY KEY,
    DV VARCHAR(1) NOT NULL,
    CODIGO VARCHAR(25),
    RAZON_SOCIAL VARCHAR(50) NOT NULL,
    GIRO VARCHAR(50) NOT NULL,
    E_MAIL VARCHAR(50),
    OBSERVACION VARCHAR(255),
    VIGENTE BOOLEAN,
    DIRECCION VARCHAR(255) NOT NULL,
    TELEFONO VARCHAR(15),
    ID_CATEGORIA INT,
    FOREIGN KEY (ID_CATEGORIA) REFERENCES CATEGORIA(ID),
    ID_COMUNA INT,
    FOREIGN KEY (ID_COMUNA) REFERENCES COMUNA(ID)
);
-- Insertar datos en la tabla REGION
INSERT INTO REGION (ID, NAME) VALUES
(1, 'Región Metropolitana'),
(2, 'Región de Valparaíso');

-- Insertar datos en la tabla COMUNA
INSERT INTO COMUNA (ID, NAME, ID_REGION) VALUES
(1, 'Santiago', 1),
(2, 'Providencia', 1),
(3, 'Viña del Mar', 2);

-- Insertar datos en la tabla CIUDAD
INSERT INTO CIUDAD (ID, NAME, ID_COMUNA) VALUES
(1, 'Santiago Centro', 1),
(2, 'Providencia Centro', 2),
(3, 'Viña Centro', 3);

-- Insertar datos en la tabla CATEGORIA
INSERT INTO CATEGORIA (ID, NAME) VALUES
(1, 'Oro'),
(2, 'Plata'),
(3, 'Bronce');

-- Insertar datos en la tabla EMPRESAS
INSERT INTO EMPRESAS (RUT, DV, CODIGO, RAZON_SOCIAL, GIRO, E_MAIL, OBSERVACION, VIGENTE, DIRECCION, TELEFONO, ID_CATEGORIA, ID_COMUNA) VALUES
('12345678', '5', 'EMP001', 'Empresa de Tecnología', 'Desarrollo de Software', 'contacto@empresa1.cl', 'Sin observaciones', TRUE, 'Av. Siempre Viva 123', '123456789', 1, 1),
('87654321', '4', 'EMP002', 'Clínica de Salud', 'Servicios Médicos', 'contacto@clinica2.cl', 'Sin observaciones', TRUE, 'Calle Falsa 456', '987654321', 2, 2);

-- Vistas y Funciones

-- Vista para listado principal
CREATE OR REPLACE VIEW vw_empresas AS
SELECT
    e.rut,
    e.dv,
    e.codigo,
    e.razon_social,
    e.giro,
    e.e_mail,
    e.vigente
FROM empresas e

-- Funcion para listado principal
CREATE OR REPLACE FUNCTION get_empresas()
RETURNS TABLE(
    rut VARCHAR,
    dv VARCHAR,
    codigo VARCHAR,
    razon_social VARCHAR,
    giro VARCHAR,
    e_mail VARCHAR,
    vigente BOOLEAN
) AS $$
BEGIN
    RETURN QUERY SELECT * FROM vw_empresas;
END;
$$ LANGUAGE plpgsql;

-- Vista para listado detallado
CREATE OR REPLACE FUNCTION get_empresas_detalle(p_rut VARCHAR)
RETURNS TABLE(
    rut VARCHAR,
    dv VARCHAR,
    codigo VARCHAR,
    razon_social VARCHAR,
    giro VARCHAR,
    e_mail VARCHAR,
    vigente BOOLEAN,
    observacion VARCHAR,
    direccion VARCHAR,
    telefono VARCHAR,
    categoria_nombre VARCHAR,
    comuna_nombre VARCHAR
) AS $$
BEGIN
    RETURN QUERY
    SELECT
        e.rut,
        e.dv,
        e.codigo,
        e.razon_social,
        e.giro,
        e.e_mail,
        e.vigente,
        e.observacion,
        e.direccion,
        e.telefono,
        c.name AS categoria_nombre,
        co.name AS comuna_nombre
    FROM empresas e
    LEFT JOIN categoria c ON e.id_categoria = c.id
    LEFT JOIN comuna co ON e.id_comuna = co.id
    WHERE e.rut = p_rut; -- Se especifica el alias "e" para evitar ambigüedad
END;
$$ LANGUAGE plpgsql;

-- Funcion para listado principal
CREATE OR REPLACE FUNCTION get_empresas_detalle(p_rut VARCHAR)
RETURNS TABLE(
    rut VARCHAR,
    dv VARCHAR,
    codigo VARCHAR,
    razon_social VARCHAR,
    giro VARCHAR,
    e_mail VARCHAR,
    vigente BOOLEAN,
    observacion VARCHAR,
    direccion VARCHAR,
    telefono VARCHAR,
    categoria_nombre VARCHAR,
    comuna_nombre VARCHAR
) AS $$
BEGIN
    RETURN QUERY SELECT * FROM vw_empresas WHERE rut = p_rut;
END;
$$ LANGUAGE plpgsql;

-- Funcion para crear empresa
CREATE OR REPLACE FUNCTION insertar_empresa(
    p_rut VARCHAR(8),
    p_dv VARCHAR(1),
    p_codigo VARCHAR(25),
    p_razon_social VARCHAR(50),
    p_giro VARCHAR(50),
    p_email VARCHAR(50),
    p_observacion VARCHAR(255),
    p_vigente BOOLEAN,
    p_direccion VARCHAR(255),
    p_telefono VARCHAR(15),
    p_id_categoria INT,
    p_id_comuna INT
)
RETURNS VOID AS $$
BEGIN
    INSERT INTO EMPRESAS (RUT, DV, CODIGO, RAZON_SOCIAL, GIRO, E_MAIL, OBSERVACION, VIGENTE, DIRECCION, TELEFONO, ID_CATEGORIA, ID_COMUNA)
    VALUES (p_rut, p_dv, p_codigo, p_razon_social, p_giro, p_email, p_observacion, p_vigente, p_direccion, p_telefono, p_id_categoria, p_id_comuna);
END;
$$ LANGUAGE plpgsql;

-- Funcion para editar empresa
CREATE OR REPLACE FUNCTION actualizar_empresa(
    p_rut TEXT,
    p_dv TEXT,
    p_codigo TEXT,
    p_razon_social TEXT,
    p_direccion TEXT,
    p_giro TEXT,
    p_email TEXT,
    p_telefono TEXT,
    p_observacion TEXT,
    p_vigente BOOLEAN,
    p_id_comuna INT,
    p_id_categoria INT
)
RETURNS VOID AS $$
BEGIN
    UPDATE empresas
    SET
        codigo = p_codigo,
        razon_social = p_razon_social,
        direccion = p_direccion,
        giro = p_giro,
        e_mail = p_email,
        telefono = p_telefono,
        observacion = p_observacion,
        vigente = p_vigente,
        id_comuna = p_id_comuna,
        id_categoria = p_id_categoria
    WHERE rut = p_rut;
END;
$$ LANGUAGE plpgsql;

-- Funcion para eliminar empresa
CREATE OR REPLACE FUNCTION eliminar_empresa(p_rut VARCHAR)
RETURNS VOID AS
$$

BEGIN
    DELETE FROM empresas WHERE rut = p_rut;
END;
$$

LANGUAGE plpgsql;



--DELETE FROM CATEGORIA;
--DELETE FROM CIUDAD;
--DELETE FROM COMUNA;
--DELETE FROM EMPRESAS;
--DELETE FROM REGION;

--DROP TABLE CATEGORIA;
--DROP TABLE CIUDAD;
--DROP TABLE COMUNA;
--DROP TABLE EMPRESAS;
--DROP TABLE REGION;

