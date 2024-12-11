<!-- app/Views/citas/agendar.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
</head>
<body>
    <h1>Agendar Cita</h1>
    <form action="/citas/agendar" method="POST">
        <label for="paciente_id">Paciente:</label>
        <select name="paciente_id" id="paciente_id" required>
            <!-- Aquí se llenarán los pacientes desde la base de datos -->
            <option value="1">Juan Pérez</option>
            <option value="2">Ana Gómez</option>
        </select><br><br>

        <label for="doctor_id">Doctor:</label>
        <select name="doctor_id" id="doctor_id" required>
            <!-- Aquí se llenarán los doctores disponibles según especialidad -->
            <option value="1">Dr. Juan Rodríguez</option>
            <option value="2">Dra. María López</option>
        </select><br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required><br><br>

        <label for="hora">Hora:</label>
        <input type="time" name="hora" id="hora" required><br><br>

        <button type="submit">Agendar cita</button>
    </form>
</body>
</html>
