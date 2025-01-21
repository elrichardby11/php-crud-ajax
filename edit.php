<?php

include('config.php');

$rut = isset($_GET['rut']) ? $_GET['rut'] : '';
$query = "SELECT * FROM empresas WHERE rut = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$rut]);
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT * FROM region;";
$stmt = $pdo->query($query);
$regiones = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM categoria;";
$stmt = $pdo->query($query);
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$region_query = "SELECT id_region FROM comuna WHERE id = ?";
$region_stmt = $pdo->prepare($region_query);
$region_stmt->execute([$empresa['id_comuna']]);
$current_region = $region_stmt->fetch(PDO::FETCH_ASSOC)['id_region'];

$query = "SELECT * FROM comuna where id_region = ?;";
$stmt = $pdo->prepare($query);
$stmt->execute([$current_region]);
$comunas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dv = $rut[strlen($rut) - 1];
    $codigo = $_POST['codigo'];
    $razon_social = $_POST['razon_social'];
    $direccion = $_POST['direccion'];
    $giro = $_POST['giro'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $observacion = $_POST['text'];
    $vigente = isset($_POST['vigente']) ? 1 : 0;
    $region = $_POST['region'];
    $comuna = $_POST['comuna'];
    $categoria = $_POST['categoria'];

    // verificar email

    $query = "SELECT actualizar_empresa(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$rut, $dv, $codigo, $razon_social, $direccion, $giro, $email, $telefono, $observacion, $vigente, $comuna, $categoria]);

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main class="flex-grow-1 bg-white py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="text-left">Modificar Empresa</h2>
                    </div>
                    <hr>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="rut" class="form-label"><strong>RUT (*)</strong></label>
                                    <input type="text" class="form-control" id="rut" name="rut" required placeholder="RUT" value="<?php echo htmlspecialchars($empresa['rut']) . "-" . htmlspecialchars($empresa['dv']); ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="codigo" class="form-label"><strong>Código</strong></label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código Interno" value="<?php echo htmlspecialchars($empresa['codigo']); ?>">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="direccion" class="form-label"><strong>Dirección (*)</strong></label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección Principal" required value="<?php echo htmlspecialchars($empresa['direccion']); ?>">
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="razon_social" class="form-label"><strong>Razón Social (*)</strong></label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razón Social" required value="<?php echo htmlspecialchars($empresa['razon_social']); ?>">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="region" class="form-label"><strong>Región</strong></label>
                                    <select id="region" class="form-select" name="region">
                                        <?php foreach ($regiones as $region): ?>
                                            <option value="<?php echo $region['id']; ?>" <?php echo $region['id'] == $current_region ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($region['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row g-3">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="giro" class="form-label"><strong>Giro Comercial (*)</strong></label>
                                    <input type="text" class="form-control" id="giro" name="giro" placeholder="Giro Comercial" required value="<?php echo htmlspecialchars($empresa['giro']); ?>">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="comuna" class="form-label"><strong>Comuna</strong></label>
                                    <select id="comuna" class="form-select" name="comuna">
                                        <?php foreach ($comunas as $comuna): ?>
                                            <option value="<?= $comuna['id']; ?>"
                                                <?= $comuna['id'] == $empresa['id_comuna'] ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($comuna['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="ciudad" class="form-label"><strong>Ciudad</strong></label>
                                    <select id="ciudad" class="form-select" name="ciudad" disabled>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="email" class="form-label"><strong>E-mail</strong></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="e-mail" value="<?php echo htmlspecialchars($empresa['e_mail']); ?>">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="telefono" class="form-label"><strong>Teléfono</strong></label>
                                    <input type="phone" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo htmlspecialchars($empresa['telefono']); ?>">
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="text" class="form-label"><strong>Observación</strong></label>
                                    <textarea class="form-control" id="text" name="text" rows="3" placeholder="Observación"><?php echo htmlspecialchars($empresa['observacion']); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <div id="categorias-list">
                                        <?php foreach ($categorias as $categoria): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="categoria" id="categoria<?php echo $categoria['id']; ?>" value="<?php echo $categoria['id']; ?>" <?php echo in_array($categoria['id'], explode(',', $empresa['id_categoria'])) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="categoria<?php echo $categoria['id']; ?>">
                                                    Categoría <?php echo htmlspecialchars($categoria['name']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="vigente" name="vigente" <?php echo $empresa['vigente'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="vigente">
                                        Vigente
                                    </label>
                                </div>
                            </div>
                        </div>

                        <br>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <a onclick="goBack()" class="btn btn-light">Cerrar</a>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="delete.php?rut=<?php echo urlencode($empresa['rut']); ?>" class="btn btn-danger">Eliminar</a>
                                <button type="submit" class="btn btn-primary">Modificar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        let isPageLoaded = false;
        var initialRegionId = $('#region').val();

        if (initialRegionId) {
            $.ajax({
                url: 'ajaxfile.php',
                method: 'GET',
                data: {
                    action: 'fetch_comunas_by_region',
                    id_region: initialRegionId
                },
                success: function(data) {
                    $('#comuna').trigger('change');
                }
            });
        }
        setTimeout(function() {
            isPageLoaded = true;
        }, 100);

        $('#region').change(function() {
            if (!isPageLoaded) return;

            var regionId = $(this).val();
            $.ajax({
                url: 'ajaxfile.php',
                method: 'GET',
                data: {
                    action: 'fetch_comunas_by_region',
                    id_region: regionId
                },
                success: function(data) {
                    $('#comuna').html(data);
                    $('#comuna').trigger('change');
                }
            });
        });

        $('#comuna').change(function() {
            var comunaId = $(this).val();
            if (comunaId) {
                $.ajax({
                    url: 'ajaxfile.php',
                    method: 'GET',
                    data: {
                        action: 'fetch_ciudad_by_comuna',
                        id_comuna: comunaId
                    },
                    success: function(data) {
                        $('#ciudad').html(data);
                    },
                });
            }
        });

        var regionId = $('#region').val();
        if (regionId) {
            $('#region').trigger('change');
        }
    });

    function goBack() {
        window.history.back();
    }

    // Verifica el email en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        var txtEmail = document.getElementById('email');

        email.addEventListener('blur', function() {
            var email = txtEmail.value;

            if ((email) && (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))) {
                alert("El correo electrónico ingresado debe contener un formato válido.");
                txtEmail.classList.add('is-invalid');
            } else {
                txtEmail.classList.remove('is-invalid');
            }
        });
    })
</script>
</body>

</html>