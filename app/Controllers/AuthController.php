<?php
class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Mostrar formulario de login
    public function loginAction() {
        session_start();  // Asegurarse de que la sesión se inicie antes de hacer cualquier cosa

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar el formulario
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Comprobación de usuario en la base de datos
            $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Si el usuario es válido, guardamos la sesión y redirigimos al index
                $_SESSION['user_id'] = $user['id'];  // Guardamos el id del usuario en la sesión
                $_SESSION['username'] = $user['username'];  // Guardamos el nombre de usuario en la sesión
                header('Location: index'); // Redirige al index después de iniciar sesión
                exit;
            } else {
                // Si las credenciales son incorrectas
                $error = "Usuario o contraseña incorrectos";
                require_once __DIR__ . '/../views/login.php'; // Mostrar de nuevo el formulario de login con error
                return;
            }
        }

        // Si no es un POST, mostramos el formulario de login
        require_once __DIR__ . '/../views/login.php';
    }

    // Cerrar sesión
    public function logoutAction() {
        session_start();
        session_destroy();  // Destruir la sesión
        header('Location: login'); // Redirige al login después de cerrar sesión
        exit;
    }
}
?>
