<?php
include('config.php');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Empresas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-left">Listado de Empresas</h2>
            <a href="create.php" class="btn btn-primary">Nuevo</a>
        </div>
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
                </tr>
            </thead>
            <tbody id="data-table">
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchData() {
                $.ajax({
                    url: 'ajaxfile.php',
                    method: 'GET',
                    success: function(data) {
                        $('#data-table').html(data);
                    }
                });
            }

            fetchData();
        });
    </script>
</body>

</html>