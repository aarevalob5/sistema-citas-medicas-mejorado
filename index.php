<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Web de Citas Médicas Portable</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header role="banner">
        <h1>Clínica Salud Integral - Gestión de Citas</h1>
        <p>Sistema Web Portable | Accesibilidad Web (WCAG 2.1)</p>
        <button id="btn-contraste" type="button" aria-pressed="false">Alternar Alto Contraste</button>
    </header>

    <main role="main" class="contenedor">
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alerta" role="alert">
                <?php echo htmlspecialchars($_GET['mensaje']); ?>
            </div>
        <?php endif; ?>

        <section aria-labelledby="titulo-form" class="tarjeta">
            <h2 id="titulo-form">Agendar Nueva Cita Médica</h2>
            <form action="guardar_cita.php" method="POST" id="form-cita">
                <div class="campo">
                    <label for="nombre">Nombre completo del paciente:</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ej. María López">
                </div>

                <div class="campo">
                    <label for="cedula">Cédula de identidad (10 dígitos):</label>
                    <input type="text" id="cedula" name="cedula" maxlength="10" pattern="[0-9]{10}" required placeholder="Ej. 0912345678">
                </div>

                <div class="campo">
                    <label for="especialidad">Especialidad médica:</label>
                    <select id="especialidad" name="especialidad" required>
                        <option value="">-- Seleccione una especialidad --</option>
                        <?php
                        $res = $conn->query("SELECT * FROM especialidades");
                        while ($row = $res->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="fila-doble">
                    <div class="campo">
                        <label for="fecha">Fecha de la cita:</label>
                        <input type="date" id="fecha" name="fecha" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="campo">
                        <label for="hora">Hora de atención:</label>
                        <input type="time" id="hora" name="hora" required>
                    </div>
                </div>

                <div class="campo">
                    <label for="motivo">Motivo de consulta (Opcional):</label>
                    <textarea id="motivo" name="motivo" rows="2" placeholder="Describa brevemente sus síntomas..."></textarea>
                </div>

                <button type="submit" class="btn-primario">Confirmar Cita Médica</button>
            </form>
        </section>

        <section aria-labelledby="titulo-lista" class="tarjeta">
            <h2 id="titulo-lista">Citas Programadas</h2>
            <div class="tabla-responsiva">
                <table>
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Cédula</th>
                            <th>Especialidad</th>
                            <th>Fecha y Hora</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT c.id, c.paciente_nombre, c.paciente_cedula, e.nombre AS especialidad, c.fecha_cita, c.hora_cita 
                                FROM citas c 
                                INNER JOIN especialidades e ON c.especialidad_id = e.id 
                                ORDER BY c.fecha_cita ASC, c.hora_cita ASC";
                        $citas = $conn->query($sql);
                        if ($citas->num_rows > 0):
                            while ($fila = $citas->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['paciente_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($fila['paciente_cedula']); ?></td>
                                <td><?php echo htmlspecialchars($fila['especialidad']); ?></td>
                                <td><?php echo $fila['fecha_cita'] . " - " . substr($fila['hora_cita'], 0, 5); ?></td>
                                <td>
                                    <a href="eliminar_cita.php?id=<?php echo $fila['id']; ?>" 
                                       class="btn-eliminar" 
                                       onclick="return confirm('¿Seguro que desea cancelar esta cita?');"
                                       aria-label="Cancelar cita de <?php echo htmlspecialchars($fila['paciente_nombre']); ?>">
                                       Cancelar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr><td colspan="5">No hay citas médicas registradas aún.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        const btnContraste = document.getElementById('btn-contraste');
        btnContraste.addEventListener('click', () => {
            document.body.classList.toggle('alto-contraste');
            const activo = document.body.classList.contains('alto-contraste');
            btnContraste.setAttribute('aria-pressed', activo);
        });
    </script>
</body>
</html>