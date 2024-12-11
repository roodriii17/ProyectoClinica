
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Citas</title>
</head>
<body>
    <h1>Listado de Citas</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Doctor</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se iteran las citas desde el controlador -->
            <tr>
                <td>1</td>
                <td>Juan Pérez</td>
                <td>Dr. Juan Rodríguez</td>
                <td>2024-12-10</td>
                <td>10:00</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Ana Gómez</td>
                <td>Dra. María López</td>
                <td>2024-12-11</td>
                <td>11:00</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
