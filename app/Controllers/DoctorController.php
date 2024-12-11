<?php
class DoctorController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Acción para listar los doctores
    public function listarAction() {
        $stmt = $this->pdo->query("SELECT * FROM doctores WHERE activo = 1");
        $doctores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>Lista de Doctores</h1>";
        foreach ($doctores as $doctor) {
            echo "<p>" . htmlspecialchars($doctor['nombre']) . " - " . htmlspecialchars($doctor['especialidad']) . "</p>";
            echo "<a href='?action=editarDoctor&id=" . $doctor['id'] . "'>Editar</a> | ";
            echo "<a href='?action=eliminarDoctor&id=" . $doctor['id'] . "'>Eliminar</a><br>";
        }

        // Enlace para agregar un nuevo doctor
        echo '<br><a href="?action=agregarDoctorForm">Agregar Doctor</a>';

        // Enlace para volver al índice
        echo '<br><br><a href="?action=inicio">Volver al Inicio</a>';
    }

    // Acción para mostrar el formulario de agregar un doctor
    public function agregarDoctorForm() {
        echo "<h1>Formulario para Agregar Doctor</h1>";
        echo '<form action="?action=agregarDoctor" method="POST">
                <label>Nombre:</label><input type="text" name="nombre" required><br>
                <label>Especialidad:</label><input type="text" name="especialidad" required><br>
                <button type="submit">Agregar Doctor</button>
              </form>';

        echo '<br><a href="?action=doctores">Volver a la lista de Doctores</a>';
    }

    // Acción para agregar un nuevo doctor
    public function agregarAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : '';

            // Validar si el nombre y especialidad no están vacíos
            if (!empty($nombre) && !empty($especialidad)) {
                // Preparar la consulta para insertar el nuevo doctor en la base de datos
                $stmt = $this->pdo->prepare("INSERT INTO doctores (nombre, especialidad, activo) 
                                             VALUES (:nombre, :especialidad, 1)");
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':especialidad', $especialidad);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    echo "<p>Doctor agregado correctamente.</p>";
                    echo '<br><a href="?action=doctores">Volver a la lista de Doctores</a>';
                } else {
                    echo "<p>Error al agregar el doctor. Intenta nuevamente.</p>";
                }
            } else {
                echo "<p>Por favor, completa todos los campos.</p>";
            }
        }
    }

    // Acción para mostrar el formulario de editar un doctor
    public function editarAction() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Obtener los datos del doctor por su ID
            $stmt = $this->pdo->prepare("SELECT * FROM doctores WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si el doctor existe
            if ($doctor) {
                echo "<h1>Formulario para Editar Doctor</h1>";
                echo '<form action="?action=actualizarDoctor&id=' . $doctor['id'] . '" method="POST">
                        <label>Nombre:</label><input type="text" name="nombre" value="' . htmlspecialchars($doctor['nombre']) . '" required><br>
                        <label>Especialidad:</label><input type="text" name="especialidad" value="' . htmlspecialchars($doctor['especialidad']) . '" required><br>
                        <button type="submit">Actualizar Doctor</button>
                      </form>';
                echo '<br><a href="?action=doctores">Volver a la lista de Doctores</a>';
            } else {
                echo "<p>Doctor no encontrado.</p>";
            }
        } else {
            echo "<p>No se especificó un ID de doctor.</p>";
        }
    }

    // Acción para actualizar los datos del doctor
    public function actualizarAction() {
        if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'];
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : '';

            // Validar si los campos no están vacíos
            if (!empty($nombre) && !empty($especialidad)) {
                // Preparar la consulta para actualizar los datos del doctor
                $stmt = $this->pdo->prepare("UPDATE doctores SET nombre = :nombre, especialidad = :especialidad WHERE id = :id");
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':especialidad', $especialidad);
                $stmt->bindParam(':id', $id);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    echo "<p>Doctor actualizado correctamente.</p>";
                    echo '<br><a href="?action=doctores">Volver a la lista de Doctores</a>';
                } else {
                    echo "<p>Error al actualizar el doctor. Intenta nuevamente.</p>";
                }
            } else {
                echo "<p>Por favor, completa todos los campos.</p>";
            }
        }
    }

    // Acción para eliminar un doctor
    public function eliminarAction() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Preparar la consulta para eliminar el doctor de la base de datos
            $stmt = $this->pdo->prepare("UPDATE doctores SET activo = 0 WHERE id = :id");
            $stmt->bindParam(':id', $id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "<p>Doctor eliminado correctamente.</p>";
            } else {
                echo "<p>Error al eliminar el doctor. Intenta nuevamente.</p>";
            }

            // Volver a la lista de doctores después de eliminar
            echo '<br><a href="?action=doctores">Volver a la lista de Doctores</a>';
        } else {
            echo "<p>El ID del doctor no fue proporcionado.</p>";
        }
    }
}
?>