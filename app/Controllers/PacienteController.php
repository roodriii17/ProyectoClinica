<?php
class PacienteController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Acción para listar los pacientes
    public function listarAction() {
        $stmt = $this->pdo->query("SELECT * FROM pacientes WHERE activo = 1");
        $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>Lista de Pacientes</h1>";
        foreach ($pacientes as $paciente) {
            echo "<p>" . htmlspecialchars($paciente['nombre']) . " - " . htmlspecialchars($paciente['fecha_nacimiento']) . "</p>";
            echo "<a href='?action=editarPaciente&id=" . $paciente['id'] . "'>Editar</a> | ";
            echo "<a href='?action=eliminarPaciente&id=" . $paciente['id'] . "'>Eliminar</a><br>";
        }

        // Enlace para agregar un nuevo paciente
        echo '<br><a href="?action=agregarPacienteForm">Agregar Paciente</a>';

        // Enlace para volver al índice
        echo '<br><br><a href="?action=inicio">Volver al Inicio</a>';
    }

    // Acción para mostrar el formulario de agregar un paciente
    public function agregarPacienteForm() {
        echo "<h1>Formulario para Agregar Paciente</h1>";
        echo '<form action="?action=agregarPaciente" method="POST">
                <label>Nombre:</label><input type="text" name="nombre" required><br>
                <label>Fecha de Nacimiento:</label><input type="date" name="fecha_nacimiento" required><br>
                <button type="submit">Agregar Paciente</button>
              </form>';
        echo '<br><a href="?action=pacientes">Volver a la lista de Pacientes</a>';
    }

    // Acción para agregar un nuevo paciente
    public function agregarAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';

            // Validar si el nombre y fecha de nacimiento no están vacíos
            if (!empty($nombre) && !empty($fecha_nacimiento)) {
                // Preparar la consulta para insertar el nuevo paciente en la base de datos
                $stmt = $this->pdo->prepare("INSERT INTO pacientes (nombre, fecha_nacimiento, activo) 
                                             VALUES (:nombre, :fecha_nacimiento, 1)");
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    echo "<p>Paciente agregado correctamente.</p>";
                    echo '<br><a href="?action=pacientes">Volver a la lista de Pacientes</a>';
                } else {
                    echo "<p>Error al agregar el paciente. Intenta nuevamente.</p>";
                }
            } else {
                echo "<p>Por favor, completa todos los campos.</p>";
            }
        }
    }

    // Acción para mostrar el formulario de editar un paciente
    public function editarAction() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Obtener los datos del paciente por su ID
            $stmt = $this->pdo->prepare("SELECT * FROM pacientes WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si el paciente existe
            if ($paciente) {
                echo "<h1>Formulario para Editar Paciente</h1>";
                echo '<form action="?action=actualizarPaciente&id=' . $paciente['id'] . '" method="POST">
                        <label>Nombre:</label><input type="text" name="nombre" value="' . htmlspecialchars($paciente['nombre']) . '" required><br>
                        <label>Fecha de Nacimiento:</label><input type="date" name="fecha_nacimiento" value="' . htmlspecialchars($paciente['fecha_nacimiento']) . '" required><br>
                        <button type="submit">Actualizar Paciente</button>
                      </form>';
                echo '<br><a href="?action=pacientes">Volver a la lista de Pacientes</a>';
            } else {
                echo "<p>Paciente no encontrado.</p>";
            }
        } else {
            echo "<p>No se especificó un ID de paciente.</p>";
        }
    }

    // Acción para actualizar los datos del paciente
    public function actualizarAction() {
        if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'];
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';

            // Validar si los campos no están vacíos
            if (!empty($nombre) && !empty($fecha_nacimiento)) {
                // Preparar la consulta para actualizar los datos del paciente
                $stmt = $this->pdo->prepare("UPDATE pacientes SET nombre = :nombre, fecha_nacimiento = :fecha_nacimiento WHERE id = :id");
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                $stmt->bindParam(':id', $id);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    echo "<p>Paciente actualizado correctamente.</p>";
                    echo '<br><a href="?action=pacientes">Volver a la lista de Pacientes</a>';
                } else {
                    echo "<p>Error al actualizar el paciente. Intenta nuevamente.</p>";
                }
            } else {
                echo "<p>Por favor, completa todos los campos.</p>";
            }
        }
    }

    // Acción para eliminar un paciente
    public function eliminarAction() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Preparar la consulta para eliminar el paciente de la base de datos
            $stmt = $this->pdo->prepare("UPDATE pacientes SET activo = 0 WHERE id = :id");
            $stmt->bindParam(':id', $id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "<p>Paciente eliminado correctamente.</p>";
                echo '<br><a href="?action=pacientes">Volver a la lista de Pacientes</a>';
            } else {
                echo "<p>Error al eliminar el paciente. Intenta nuevamente.</p>";
            }
        } else {
            echo "<p>El ID del paciente no fue proporcionado.</p>";
        }
    }
}
?>
