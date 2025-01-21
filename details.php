<?php

include('config.php');

$query = "SELECT NAME FROM REGION;";
$stmt = $pdo->query($query);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de la Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <h2 class="text-left">Datos de la Empresa</h2>
        <hr>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>RUT</th>
                    <th>Código</th>
                    <th>Razón Social</th>
                    <th>Giro Comercial</th>
                    <th>E-Mail</th>
                    <th>Vigente</th>
                    <th>Observación</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Categoría</th>
                    <th>Comuna</th>
                </tr>
            </thead>
            <tbody id="data-table">
            </tbody>
        </table>
        <hr>
        <div class="d-flex justify-content-between">
            <a onclick="goBack()" class="btn btn-light">Cerrar</a>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="delete.php?rut=<?php echo $_GET['rut']; ?>" class="btn btn-danger">Eliminar</a>
                <a href="edit.php?rut=<?php echo $_GET['rut']; ?>" class="btn btn-primary">Modificar</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchData(rut) {
                $.ajax({
                    url: 'ajaxfile.php',
                    method: 'GET',
                    data: {
                        action: 'fetch_detail_by_rut',
                        rut: rut
                    },
                    success: function(data) {
                        $('#data-table').html(data);
                    }
                });
            }

            var rut = '<?php echo $_GET['rut']; ?>';
            fetchData(rut);
        });

        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>