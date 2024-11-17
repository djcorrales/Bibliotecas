<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Operación</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Cargar Bootstrap para usar modales -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
// Comprobamos el estado del resultado
$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($status == 'success') {
    $message = "Usuario agregado exitosamente.";
    $modalTitle = "Éxito";
    $modalClass = "success";
} else {
    $message = "Error al agregar el usuario.";
    $modalTitle = "Error";
    $modalClass = "danger";
}
?>



<!-- Modal -->
<div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-<?php echo $modalClass; ?>">
                <h5 class="modal-title" id="modalTitle"><?php echo $modalTitle; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo $message; ?>
            </div>
            <div class="modal-footer">
                <a href="../view/admin.php" class="btn btn-secondary">Cerrar</a>
            </div>
        </div>
    </div>
</div>

<!-- Script de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Mostrar el modal cuando la página cargue
    var myModal = new bootstrap.Modal(document.getElementById('resultadoModal'));
    myModal.show();
</script>

</body>
</html>
