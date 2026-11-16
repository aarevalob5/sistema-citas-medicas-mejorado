# Sistema Web de Citas Médicas Mejorado (WCAG 2.1)

Proyecto desarrollado para la asignatura **Interacción Humano-Computador** – Universidad Estatal de Milagro (UNEMI).

## Mejoras Implementadas respecto al Prototipo Base
- **Accesibilidad Web (WCAG 2.1):** Botón interactivo *"Alternar Alto Contraste"* (`body.alto-contraste` en `estilos.css`) para personas con baja visión.
- **Base de Datos Relacional MySQL (`citas_medicas_db.sql`):** Migración a tablas normalizadas (`citas` y `especialidades`) bajo servidor local XAMPP (Apache + MySQL).
- **Gestión Completa de Turnos (CRUD):** Módulo `eliminar_cita.php` para cancelar citas programadas en tiempo real.
- **Validación y Triaje:** Campo de cédula de identidad (10 dígitos) y motivo de consulta.
- **Arquitectura Modular:** Separación limpia entre `conexion.php`, `guardar_cita.php`, `eliminar_cita.php`, `index.php` y `estilos.css`.
