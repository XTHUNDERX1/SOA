-- Base de datos: eventos_peru

-- Estructura de tabla para la tabla clientes
CREATE TABLE clientes (
  ClienteID SERIAL PRIMARY KEY,
  NombreCliente VARCHAR(100) NOT NULL,
  Telefono VARCHAR(15),
  Email VARCHAR(100),
  Direccion VARCHAR(255)
);

-- Estructura de tabla para la tabla eventos
CREATE TABLE eventos (
  EventoID SERIAL PRIMARY KEY,
  TipoEvento VARCHAR(50) NOT NULL,
  Fecha DATE NOT NULL,
  Lugar VARCHAR(255) NOT NULL,
  ClienteID INT,
  ProveedorID INT,
  FOREIGN KEY (ClienteID) REFERENCES clientes (ClienteID),
  FOREIGN KEY (ProveedorID) REFERENCES proveedores (ProveedorID)
);

-- Estructura de tabla para la tabla feedback
CREATE TABLE feedback (
  FeedbackID SERIAL PRIMARY KEY,
  EventoID INT,
  Comentarios TEXT,
  Calificacion INT CHECK (Calificacion >= 1 AND Calificacion <= 5),
  FOREIGN KEY (EventoID) REFERENCES eventos (EventoID)
);

-- Estructura de tabla para la tabla proveedores
CREATE TABLE proveedores (
  ProveedorID SERIAL PRIMARY KEY,
  NombreProveedor VARCHAR(100) NOT NULL,
  Telefono VARCHAR(15),
  Email VARCHAR(100),
  Direccion VARCHAR(255),
  Reputacion INT DEFAULT 0
);

-- Estructura de tabla para la tabla roles
CREATE TABLE roles (
  RolID SERIAL PRIMARY KEY,
  NombreRol VARCHAR(50) NOT NULL UNIQUE
);

-- Volcado de datos para la tabla roles
INSERT INTO roles (RolID, NombreRol) VALUES
(1, 'Administrador'),
(2, 'Moderador'),
(3, 'Usuario');

-- Estructura de tabla para la tabla usuarios
CREATE TABLE usuarios (
  UsuarioID SERIAL PRIMARY KEY,
  NombreUsuario VARCHAR(50) NOT NULL,
  Email VARCHAR(100) NOT NULL UNIQUE,
  Contraseña VARCHAR(255) NOT NULL,
  RolID INT,
  FOREIGN KEY (RolID) REFERENCES roles (RolID)
);

-- Volcado de datos para la tabla usuarios
INSERT INTO usuarios (UsuarioID, NombreUsuario, Email, Contraseña, RolID) VALUES
(1, 'admin', 'test@gmail.com', '$2y$10$HeEVDqxUERsrBzmHi/eBae/78DsfRYvKrRFgNQf8Um5rtXqY0X29G', 1),
(2, 'william', 'william@gmail.com', '$2y$10$j2zk4CBmN/RcGwjK5GmobO.Pjo18NPu9iCLT9rv0dKvTVlB.NaRV.', 2),
(3, 'admin2', 'admin2@gmail.com', '$2y$10$ggtlYttW783fIXx3BXU6vO09AKV3Ew87U29H9aU0.TmtEq9p6sPrm', 1);
