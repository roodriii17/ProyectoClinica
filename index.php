
<?php
session_start();

// Verificar si el usuario está autenticado, si no, redirigir al login
if (!isset($_SESSION['user_id'])) {
    header('Location: /ProyectoClinica/public/login.php');




    exit();
}

require_once __DIR__ . '/config/database.php';  
require_once __DIR__ . '/app/Controllers/CitaController.php';
require_once __DIR__ . '/app/Controllers/DoctorController.php';
require_once __DIR__ . '/app/Controllers/PacienteController.php';



$pdo = Database::getConnection();


$doctorController = new DoctorController($pdo); 
$pacienteController = new PacienteController($pdo); 
$citaController = new CitaController($pdo); 


$action = isset($_GET['action']) ? $_GET['action'] : 'inicio'; 


switch ($action) {
    // Acciones relacionadas con doctores
    case 'doctores':
        $doctorController->listarAction(); 
        break;
    case 'agregarDoctorForm':
        $doctorController->agregarDoctorForm(); 
        break;
    case 'agregarDoctor':
        $doctorController->agregarAction(); 
        break;
    case 'editarDoctor':
        $doctorController->editarAction(); 
        break;
    case 'actualizarDoctor':
        $doctorController->actualizarAction(); 
        break;
    case 'eliminarDoctor':
        $doctorController->eliminarAction(); 
        break;

    // Acciones relacionadas con pacientes
    case 'pacientes':
        $pacienteController->listarAction(); 
        break;
    case 'agregarPacienteForm':
        $pacienteController->agregarPacienteForm(); 
        break;
    case 'agregarPaciente':
        $pacienteController->agregarAction(); 
        break;
    case 'editarPaciente':
        $pacienteController->editarAction(); 
        break;
    case 'actualizarPaciente':
        $pacienteController->actualizarAction(); 
        break;
    case 'eliminarPaciente':
        $pacienteController->eliminarAction(); 
        break;

    // Acciones relacionadas con citas
    case 'citas':
        $citaController->listarCitas(); 
        break;
    case 'agendarCitaForm':
        $citaController->agendarCitaForm(); 
        break;
    case 'agendarCita':
        $citaController->agendarAction(); 
        break;
    case 'editarCitaForm':
        $citaController->editarCitaForm(); 
        break;
    case 'actualizarCita':
        $citaController->actualizarCita(); 
        break;
    case 'eliminarCita':
        $citaController->eliminarCita(); 
        break;

    // Página principal de inicio
    case 'inicio':
        echo "<h1>Bienvenido a la Clínica</h1><p>Gestión de Citas Médicas</p>";
        echo "<a href='?action=doctores'>Ver Doctores</a><br>";
        echo "<a href='?action=pacientes'>Ver Pacientes</a><br>";
        echo "<a href='?action=citas'>Ver Citas</a><br>";
        echo "<a href='?action=agendarCitaForm'>Agendar Cita</a><br>";
        break;
    
    
    default:
        echo "Acción no encontrada"; 
        break;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica - Gestión de Citas</title>
   
    <link rel="stylesheet" href="../ProyectoClinica/public/css/styles.css"> 
</head>

