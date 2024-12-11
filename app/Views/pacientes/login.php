<!-
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Paciente</title>
</head>
<body>
    <h1>Iniciar sesión</h1>
    <form action="/login" method="POST">
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Iniciar sesión</button>
    </form>
    <p>¿No tienes cuenta? <a href="/registro">Regístrate</a></p>
</body>
</html>
