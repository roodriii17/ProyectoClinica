
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas</title>
</head>
<body>
    <h1>Mis Citas</h1>
    <?php if (empty($citas)): ?>
        <p>No tienes citas agendadas.</p>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí iteramos sobre las citas del paciente -->
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?php echo $cita['id']; ?></td>
                        <td><?php echo $cita['doctor']; ?></td>
                        <td><?php echo $cita['fecha']; ?></td>
                        <td><?php echo $cita['hora']; ?></td>
                        <td>
                            <!-- Puedes agregar botones para eliminar o editar la cita -->
                            <a href="/citas/cancelar/<?php echo $cita['id']; ?>">Cancelar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <p><a href="/citas/agendar">Agendar una nueva cita</a></p>
</body>
</html>
