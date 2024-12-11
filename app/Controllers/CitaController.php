<?php
class CitaController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Acción para listar todas las citas
    public function listarCitas() {
        $stmt = $this->pdo->query("SELECT * FROM citas");
        $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>Lista de Citas</h1>";
        foreach ($citas as $cita) {
            // Obtenemos el nombre del paciente y doctor
            $stmtPaciente = $this->pdo->prepare("SELECT nombre FROM pacientes WHERE id = :id");
            $stmtPaciente->bindParam(':id', $cita['paciente_id']);
            $stmtPaciente->execute();
            $paciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);

            $stmtDoctor = $this->pdo->prepare("SELECT nombre FROM doctores WHERE id = :id");
            $stmtDoctor->bindParam(':id', $cita['doctor_id']);
            $stmtDoctor->execute();
            $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);

         
            echo "<p>Paciente: " . $paciente['nombre'] . " | Doctor: " . $doctor['nombre'] . " | Fecha: " . $cita['fecha'] . " | Hora: " . $cita['hora'] . "</p>";
            
            echo "<a href='?action=editarCita&id=" . $cita['id'] . "'>Editar</a> | ";
            echo "<a href='?action=eliminarCita&id=" . $cita['id'] . "'>Eliminar</a><br>";
        }

        
        echo '<br><a href="?action=agendarCitaForm">Agendar Cita</a>';

       
        echo '<br><a href="?action=inicio">Volver al Inicio</a>';
    }

   
    public function agendarCitaForm() {
        // Obtener la lista de doctores y pacientes
        $stmtDoctor = $this->pdo->query("SELECT * FROM doctores WHERE activo = 1");
        $doctores = $stmtDoctor->fetchAll(PDO::FETCH_ASSOC);

        $stmtPaciente = $this->pdo->query("SELECT * FROM pacientes WHERE activo = 1");
        $pacientes = $stmtPaciente->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>Formulario para Agendar Cita</h1>";
        echo '<form action="?action=agendarCita" method="POST">
                <label>Paciente:</label><select name="paciente_id" required>';
        foreach ($pacientes as $paciente) {
            echo "<option value='" . $paciente['id'] . "'>" . $paciente['nombre'] . "</option>";
        }
        echo '</select><br>';
        echo '<label>Doctor:</label><select name="doctor_id" required>';
        foreach ($doctores as $doctor) {
            echo "<option value='" . $doctor['id'] . "'>" . $doctor['nombre'] . "</option>";
        }
        echo '</select><br>';
        echo '<label>Fecha:</label><input type="date" name="fecha" required><br>';
        echo '<label>Hora:</label><input type="time" name="hora" required><br>';
        echo '<button type="submit">Agendar Cita</button>';
        echo '<br><a href="?action=citas"><button type="button">Volver a la Lista de Citas</button></a>';
        echo '</form>';
    }

    // Acción para agendar una nueva cita
    public function agendarAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paciente_id = $_POST['paciente_id'];
            $doctor_id = $_POST['doctor_id'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];

            // Validar si ya existe una cita con el mismo doctor y la misma fecha y hora
            $stmt = $this->pdo->prepare("SELECT * FROM citas WHERE doctor_id = :doctor_id AND fecha = :fecha AND hora = :hora");
            $stmt->bindParam(':doctor_id', $doctor_id);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->execute();
            $existeCita = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existeCita) {
                echo "<p>Ya existe una cita con este doctor en esa fecha y hora. Por favor, elige otro horario.</p>";
                return;
            }

            // Insertar la nueva cita
            $stmt = $this->pdo->prepare("INSERT INTO citas (paciente_id, doctor_id, fecha, hora) VALUES (:paciente_id, :doctor_id, :fecha, :hora)");
            $stmt->bindParam(':paciente_id', $paciente_id);
            $stmt->bindParam(':doctor_id', $doctor_id);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);

            if ($stmt->execute()) {
                echo "<p>Cita agendada correctamente.</p>";
                echo '<br><a href="?action=citas">Volver a la lista de Citas</a>';
            } else {
                echo "<p>Error al agendar la cita. Intenta nuevamente.</p>";
            }
        }
    }

    // Acción para editar una cita
    public function editarCita() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            
            $stmt = $this->pdo->prepare("SELECT * FROM citas WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $cita = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cita) {
               
                $stmtPaciente = $this->pdo->query("SELECT * FROM pacientes WHERE activo = 1");
                $pacientes = $stmtPaciente->fetchAll(PDO::FETCH_ASSOC);

                $stmtDoctor = $this->pdo->query("SELECT * FROM doctores WHERE activo = 1");
                $doctores = $stmtDoctor->fetchAll(PDO::FETCH_ASSOC);

                echo "<h1>Editar Cita</h1>";
                echo '<form action="?action=actualizarCita&id=' . $cita['id'] . '" method="POST">
                        <label>Paciente:</label><select name="paciente_id" required>';
                foreach ($pacientes as $paciente) {
                    $selected = $cita['paciente_id'] == $paciente['id'] ? 'selected' : '';
                    echo "<option value='" . $paciente['id'] . "' $selected>" . $paciente['nombre'] . "</option>";
                }
                echo '</select><br>';
                echo '<label>Doctor:</label><select name="doctor_id" required>';
                foreach ($doctores as $doctor) {
                    $selected = $cita['doctor_id'] == $doctor['id'] ? 'selected' : '';
                    echo "<option value='" . $doctor['id'] . "' $selected>" . $doctor['nombre'] . "</option>";
                }
                echo '</select><br>';
                echo '<label>Fecha:</label><input type="date" name="fecha" value="' . $cita['fecha'] . '" required><br>';
                echo '<label>Hora:</label><input type="time" name="hora" value="' . $cita['hora'] . '" required><br>';
                echo '<button type="submit">Actualizar Cita</button>';
                echo '</form>';
            } else {
                echo "<p>Cita no encontrada.</p>";
            }
        } else {
            echo "<p>No se especificó el ID de la cita.</p>";
        }
    }

  // Acción para actualizar la cita
public function actualizarCita() {
    if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'];
        $paciente_id = $_POST['paciente_id'];
        $doctor_id = $_POST['doctor_id'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];

        
        $stmt = $this->pdo->prepare("SELECT * FROM citas WHERE doctor_id = :doctor_id AND fecha = :fecha AND hora = :hora AND id != :id");
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $existeCita = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existeCita) {
            echo "<p>Ya existe una cita con este doctor en esa fecha y hora. Por favor, elige otro horario.</p>";
            return;
        }

        // Actualizar la cita
        $stmt = $this->pdo->prepare("UPDATE citas SET paciente_id = :paciente_id, doctor_id = :doctor_id, fecha = :fecha, hora = :hora WHERE id = :id");
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo "<p>Cita actualizada correctamente.</p>";
            echo '<br><a href="?action=citas">Volver a la lista de Citas</a>';
        } else {
            echo "<p>Error al actualizar la cita. Intenta nuevamente.</p>";
        }
    }
}

// Acción para mostrar el formulario de edición de cita
public function editarCitaForm() {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Obtener los detalles de la cita
        $stmt = $this->pdo->prepare("SELECT * FROM citas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $cita = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cita) {
            // Mostrar el formulario para editar la cita
            echo "<h1>Editar Cita</h1>";
            echo '<form action="?action=actualizarCita&id=' . $cita['id'] . '" method="POST">
                    <label>Paciente:</label>
                    <select name="paciente_id" required>';

            // Obtener pacientes
            $stmtPaciente = $this->pdo->query("SELECT * FROM pacientes");
            $pacientes = $stmtPaciente->fetchAll(PDO::FETCH_ASSOC);
            foreach ($pacientes as $paciente) {
                echo "<option value='" . $paciente['id'] . "' " . ($cita['paciente_id'] == $paciente['id'] ? 'selected' : '') . ">" . $paciente['nombre'] . "</option>";
            }

            echo '</select><br>';

            echo '<label>Doctor:</label>
                    <select name="doctor_id" required>';

            // Obtener doctores
            $stmtDoctor = $this->pdo->query("SELECT * FROM doctores");
            $doctores = $stmtDoctor->fetchAll(PDO::FETCH_ASSOC);
            foreach ($doctores as $doctor) {
                echo "<option value='" . $doctor['id'] . "' " . ($cita['doctor_id'] == $doctor['id'] ? 'selected' : '') . ">" . $doctor['nombre'] . "</option>";
            }

            echo '</select><br>';

            // Mostrar fecha y hora actual de la cita
            echo '<label>Fecha y Hora:</label><input type="datetime-local" name="fecha_hora" value="' . date('Y-m-d\TH:i', strtotime($cita['fecha_hora'])) . '" required><br>';
            echo '<button type="submit">Actualizar Cita</button>';
            echo '</form>';
        } else {
            echo "<p>Cita no encontrada.</p>";
        }
    } else {
        echo "<p>No se especificó el ID de la cita.</p>";
    }
}


  // Acción para eliminar una cita
public function eliminarCita() {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Preparar la consulta para eliminar la cita
        $stmt = $this->pdo->prepare("DELETE FROM citas WHERE id = :id");
        $stmt->bindParam(':id', $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<p>Cita eliminada correctamente.</p>";
            echo '<br><a href="?action=citas">Volver a la lista de Citas</a>';
        } else {
            echo "<p>Error al eliminar la cita. Intenta nuevamente.</p>";
        }
    } else {
        echo "<p>No se especificó el ID de la cita.</p>";
    }
}

    // Acción para volver al inicio
    public function inicio() {
        echo "<h1>Bienvenido a la Clínica</h1>";
        echo '<br><a href="?action=citas">Ver Lista de Citas</a>';
    }
}
?>
