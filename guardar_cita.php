<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $especialidad = $_POST['especialidad'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $motivo = $_POST['motivo'];

    $check = $conn->prepare("SELECT id FROM citas WHERE especialidad_id = ? AND fecha_cita = ? AND hora_cita = ?");
    $check->bind_param("iss", $especialidad, $fecha, $hora);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: index.php?mensaje=Error: Ese horario ya está ocupado para dicha especialidad.");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO citas (paciente_nombre, paciente_cedula, especialidad_id, fecha_cita, hora_cita, motivo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $nombre, $cedula, $especialidad, $fecha, $hora, $motivo);

    if ($stmt->execute()) {
        header("Location: index.php?mensaje=Cita registrada exitosamente.");
    } else {
        header("Location: index.php?mensaje=Error al guardar la cita.");
    }
    $stmt->close();
    $conn->close();
}
?>