<?php
session_start();

// Definir el usuario y la contraseña (solo para pruebas)
$usuarioValido = "admin";
$contraseñaValida = "1234";

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar las credenciales
    if ($username === $usuarioValido && $password === $contraseñaValida) {
        // Si el login es correcto, iniciar sesión
        $_SESSION['user_id'] = 1; // Definir un ID de usuario (puede ser cualquier número único)
        $_SESSION['username'] = $username;

        // Redirigir al index con la acción 'inicio' (ubicación correcta desde la carpeta public)
        header('Location: ../index.php?action=inicio');  // Cambiar la ruta aquí
        exit(); // Asegurarse de que el script se detenga después de la redirección
    } else {
        // Si las credenciales son incorrectas, mostrar error
        $error = "Credenciales incorrectas. Intenta nuevamente.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
    
    <style>
      
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background: #f0f4f7;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Estilo para el contenedor del formulario */
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 2.2rem;
            font-weight: 600;
        }

        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background-color: #f9f9f9;
        }

        
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #3498db;
            background-color: #fff;
            outline: none;
        }

        /* Botón de login */
        button {
            background-color: #3498db;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1rem;
            width: 100%;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Estilo para el mensaje de error */
        .error {
            color: red;
            font-size: 1rem;
            margin-top: 15px;
            text-align: center;
        }

        /* Enlace debajo del formulario */
        a {
            color: #3498db;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s ease;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>
   
    <form action="login.php" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <button type="submit">Iniciar sesión</button>
    </form>
    
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
</body>
</html>
