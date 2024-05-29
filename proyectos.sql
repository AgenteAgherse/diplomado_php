-- Crear la tabla proyectos
CREATE TABLE proyectos (
    Id_proyecto INT PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(255) NOT NULL,
    Fecha_inicio DATE NOT NULL,
    Fecha_entrega DATE NOT NULL,
    Valor DECIMAL(10, 2) NOT NULL,
    Lugar VARCHAR(255) NOT NULL,
    Responsable VARCHAR(255) NOT NULL,
    Estado VARCHAR(50) NOT NULL
);

-- Crear la tabla personas
CREATE TABLE personas (
    Id_persona INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Apellidos VARCHAR(100) NOT NULL,
    Direccion VARCHAR(255) NOT NULL,
    Telefono VARCHAR(20) NOT NULL,
    Sexo VARCHAR(10) NOT NULL,
    Fecha_nacimiento DATE NOT NULL,
    Profesion VARCHAR(100) NOT NULL
);

-- Crear la tabla actividades
CREATE TABLE actividades (
    Id_actividad INT PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(255) NOT NULL,
    Fecha_inicio DATE NOT NULL,
    Fecha_final DATE NOT NULL,
    Id_proyecto INT NOT NULL,
    Responsable VARCHAR(255) NOT NULL,
    Estado VARCHAR(50) NOT NULL,
    Presupuesto DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (Id_proyecto) REFERENCES proyectos(Id_proyecto)
);

-- Crear la tabla tareas
CREATE TABLE tareas (
    Id_tarea INT PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(255) NOT NULL,
    Fecha_inicio DATE NOT NULL,
    Fecha_final DATE NOT NULL,
    Id_actividad INT NOT NULL,
    Estado VARCHAR(50) NOT NULL,
    Presupuesto DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (Id_actividad) REFERENCES actividades(Id_actividad)
);

-- Crear la tabla recursos
CREATE TABLE recursos (
    Id_recurso INT PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(255) NOT NULL,
    Valor DECIMAL(10, 2) NOT NULL,
    Unidad_de_medida VARCHAR(50) NOT NULL
);

-- Crear la tabla tareaxrecurso
CREATE TABLE tareaxrecurso (
    Id_tarea INT NOT NULL,
    Id_recurso INT NOT NULL,
    Cantidad DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (Id_tarea, Id_recurso),
    FOREIGN KEY (Id_tarea) REFERENCES tareas(Id_tarea),
    FOREIGN KEY (Id_recurso) REFERENCES recursos(Id_recurso)
);

-- Crear la tabla tareaxpersona
CREATE TABLE tareaxpersona (
    Id_tarea INT NOT NULL,
    Id_persona INT NOT NULL,
    Duracion DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (Id_tarea, Id_persona),
    FOREIGN KEY (Id_tarea) REFERENCES tareas(Id_tarea),
    FOREIGN KEY (Id_persona) REFERENCES personas(Id_persona)
);
