# ACDB1

Proyecto web desarrollado en PHP, MySQL, HTML, CSS y jQuery para el registro,
inicio de sesion y administracion del perfil de usuario.

## Funcionalidades

- Registro de usuarios.
- Inicio de sesion.
- Validacion de usuario autenticado mediante sesiones.
- Actualizacion de datos del perfil.
- Cambio de contrasena.
- Cierre de sesion usando `session_destroy()`.

## Seguridad

El proyecto utiliza consultas preparadas con `mysqli_prepare()` y
`mysqli_stmt_bind_param()` para evitar inyecciones SQL.

Las contrasenas se guardan de forma segura usando `password_hash()` y se validan
al iniciar sesion con `password_verify()`.

Tambien se maneja la sesion del usuario con `session_start()` para validar el
acceso a paginas privadas y `session_destroy()` para cerrar la sesion.

## Requisitos del sistema

Para ejecutar el proyecto se necesita:

- Servidor local como WAMP, XAMPP o Laragon.
- PHP 7.4 o superior.
- MySQL o MariaDB.
- Navegador web actualizado.
- Extension `mysqli` habilitada en PHP.
- Base de datos creada con la tabla `usuarios`.
- Acceso a phpMyAdmin o algun cliente MySQL para administrar la base de datos.

## Requisitos de Base de Datos 

-- Database: `acdb1_pw`
--
--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `nombres`, `apellidos`, `fecha_nacimiento`, `password`, `fecha_registro`) VALUES
(2, 'andym380@hotmail.com', 'Jorge Andres', 'Munoz', '1985-12-30', '$2y$10$0zYeWXVcbBYD3gUzQ2uPKOCFDbCgcgk1UWz2kknKXs2LJttjgz0dO', '2026-05-05 03:07:03');
COMMIT;

## Estructura principal

- `index.php`: pagina principal que carga los formularios de login y registro.
- `assets/conf/partials/login.php`: partial del formulario de inicio de sesion.
- `assets/conf/partials/registro_usuario.php`: partial del formulario de registro.
- `assets/conf/login/validar_login.php`: valida las credenciales del usuario.
- `assets/conf/login/logout.php`: destruye la sesion y cierra el acceso.
- `assets/conf/registro/guardar_registro.php`: registra nuevos usuarios.
- `assets/conf/registro/actualizar_datos.php`: actualiza los datos del perfil.
- `assets/conf/registro/actualizar_password.php`: actualiza la contrasena.
- `assets/conf/bd/conexion.php`: conexion a la base de datos.
- `home/perfil.php`: pagina privada del perfil del usuario.
- `assets/css/index.css`: estilos de la pagina principal, login y registro.
- `assets/css/perfil.css`: estilos de la pagina de perfil.

## Pasos para instalar y ejecutar localmente

1. Instalar un servidor web(Apache), puede ser Xampp, Wampp.
2. Instalar MySql Server 
3. Crear la Base de Datos
4. Crear la tabla usuarios
5. Ejecuatar la wb.