
<?php
session_start();

// Verificar si el usuario está autenticado, si no, redirigir al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');

    exit();
}

require_once __DIR__ . '/config/database.php';  // Ajuste la ruta al archivo de configuración
require_once __DIR__ . '/app/Controllers/CitaController.php';
require_once __DIR__ . '/app/Controllers/DoctorController.php';
require_once __DIR__ . '/app/Controllers/PacienteController.php';


// Obtener la conexión PDO usando la clase Database
$pdo = Database::getConnection();

// Inicializar los controladores
$doctorController = new DoctorController($pdo); 
$pacienteController = new PacienteController($pdo); 
$citaController = new CitaController($pdo); 

// Verificar qué acción se solicita
$action = isset($_GET['action']) ? $_GET['action'] : 'inicio'; 

// Ejecutar la acción correspondiente
switch ($action) {
    // Acciones relacionadas con doctores
    case 'doctores':
        $doctorController->listarAction(); // Acción para listar doctores
        break;
    case 'agregarDoctorForm':
        $doctorController->agregarDoctorForm(); // Acción para mostrar formulario de agregar doctor
        break;
    case 'agregarDoctor':
        $doctorController->agregarAction(); // Acción para agregar un doctor
        break;
    case 'editarDoctor':
        $doctorController->editarAction(); // Acción para editar un doctor
        break;
    case 'actualizarDoctor':
        $doctorController->actualizarAction(); // Acción para actualizar un doctor
        break;
    case 'eliminarDoctor':
        $doctorController->eliminarAction(); // Acción para eliminar un doctor
        break;

    // Acciones relacionadas con pacientes
    case 'pacientes':
        $pacienteController->listarAction(); // Acción para listar pacientes
        break;
    case 'agregarPacienteForm':
        $pacienteController->agregarPacienteForm(); // Acción para mostrar formulario de agregar paciente
        break;
    case 'agregarPaciente':
        $pacienteController->agregarAction(); // Acción para agregar un paciente
        break;
    case 'editarPaciente':
        $pacienteController->editarAction(); // Acción para editar un paciente
        break;
    case 'actualizarPaciente':
        $pacienteController->actualizarAction(); // Acción para actualizar un paciente
        break;
    case 'eliminarPaciente':
        $pacienteController->eliminarAction(); // Acción para eliminar un paciente
        break;

    // Acciones relacionadas con citas
    case 'citas':
        $citaController->listarCitas(); // Acción para listar citas
        break;
    case 'agendarCitaForm':
        $citaController->agendarCitaForm(); // Acción para mostrar formulario de agendar cita
        break;
    case 'agendarCita':
        $citaController->agendarAction(); // Acción para agendar una cita
        break;
    case 'editarCitaForm':
        $citaController->editarCitaForm(); // Acción para mostrar formulario de editar cita
        break;
    case 'actualizarCita':
        $citaController->actualizarCita(); // Acción para actualizar cita
        break;
    case 'eliminarCita':
        $citaController->eliminarCita(); // Acción para eliminar una cita
        break;

    // Página principal de inicio
    case 'inicio':
        echo "<h1>Bienvenido a la Clínica</h1><p>Gestión de Citas Médicas</p>";
        echo "<a href='?action=doctores'>Ver Doctores</a><br>";
        echo "<a href='?action=pacientes'>Ver Pacientes</a><br>";
        echo "<a href='?action=citas'>Ver Citas</a><br>";
        echo "<a href='?action=agendarCitaForm'>Agendar Cita</a><br>";
        break;
    
    // Acción por defecto si no se encuentra la ruta
    default:
        echo "Acción no encontrada"; // Mensaje si la acción no es válida
        break;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica - Gestión de Citas</title>
    <!-- Vincular el archivo CSS -->
    <link rel="stylesheet" href="../ProyectoClinica/public/css/styles.css"> <!-- Asegúrate de tener este archivo CSS en la carpeta 'css' -->
</head>

