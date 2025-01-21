<?php 
include('config.php');

// Obtener las regiones desde la base de datos
$query = "SELECT * FROM region;";
$stmt = $pdo->query($query);
$regiones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener las categorías desde la base de datos
$query = "SELECT * FROM categoria;";
$stmt = $pdo->query($query);
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $rut = $_POST['rut'];
    $codigo = $_POST['codigo'];
    $direccion = $_POST['direccion'];
    $razon_social = $_POST['razon_social'];
    $giro = $_POST['giro'];
    $comuna = $_POST['comuna'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $observacion = $_POST['text'];
    $categoria = $_POST['categoria'];
    $vigente = isset($_POST['vigente']) ? 1 : 0;

    # Fornateo de rut
    $rut = str_replace(['.', '-'], '', $rut);
    $dv = substr($rut, -1);
    $rut = substr($rut, 0, 8);

    if ($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "El correo electrónico ingresado debe contener un formato válido.";
            exit;
        }    
    }
    
    // Insertar los datos en la base de datos
    $sql = "SELECT insertar_empresa(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $rut, $dv, $codigo, $razon_social, $giro, $email, $observacion, $vigente, $direccion, $telefono, $categoria, $comuna
    ]);

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="flex-grow-1 bg-white py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">  
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="text-left">Nueva Empresa</h2>
                </div>
                <hr>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="rut" class="form-label"><strong>RUT (*)</strong></label>
                                <input type="text" class="form-control" id="rut" name="rut" required placeholder="RUT">
                            </div>                        
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="codigo" class="form-label"><strong>Código</strong></label>
                                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código Interno">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="direccion" class="form-label"><strong>Dirección (*)</strong></label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección Principal" required>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="razon_social" class="form-label"><strong>Razón Social (*)</strong></label>
                                <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razón Social" required>
                            </div> 
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="region" class="form-label"><strong>Región</strong></label>
                                <select id="region" name="region" class="form-select">
                                    <?php foreach ($regiones as $region): ?>
                                        <option value="<?php echo $region['id']; ?>">
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
                                <input type="text" class="form-control" id="giro" name="giro" placeholder="Giro Comercial" required>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="comuna" class="form-label"><strong>Comuna</strong></label>
                                <select id="comuna" name="comuna" class="form-select">
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="ciudad" class="form-label"><strong>Ciudad</strong></label>
                                <select id="ciudad" name="ciudad" class="form-select" disabled>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="email" class="form-label"><strong>E-mail</strong></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="e-mail">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="telefono" class="form-label"><strong>Teléfono</strong></label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="text" class="form-label"><strong>Observación</strong></label>
                                <textarea class="form-control" id="text" name="text" rows="3" placeholder="Observación"></textarea>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                            <?php foreach ($categorias as $categoria): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="categoria" checked id="categoria<?php echo $categoria['id']; ?>" value="<?php echo $categoria['id']; ?>">
                                    <label class="form-check-label" for="categoria<?php echo $categoria['id']; ?>">
                                        Categoría <?php echo htmlspecialchars($categoria['name']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="vigente" name="vigente" checked>
                                <label class="form-check-label" for="vigente">
                                    Vigente
                                </label>
                            </div>
                        </div>
                    </div>

                    <br>

                    <br><br>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a onclick="goBack()" class="content-left btn btn-light">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
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
        $('#region').change(function() {
            var regionId = $(this).val();
            $.ajax({
                url: 'ajaxfile.php',
                method: 'GET',
                data: { action: 'fetch_comunas_by_region', id_region: regionId },
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
                    data: { action: 'fetch_ciudad_by_comuna', id_comuna: comunaId },
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

    function calcularDV(rut) {
        var numerosAMultiplicar = [3, 2, 7, 6, 5, 4, 3, 2];
        var resultados = [];
        var suma = 0;

        // Convertir RUT a string, quitar caracteres no numéricos, y asegurar que solo tiene 8 dígitos
        rut = rut.replace(/[^\d]/g, '');  
        if (rut.length !== 8) {
            return null;  // Si no tiene 8 dígitos, el RUT no es válido
        }

        // Multiplica cada dígito del RUT por los números definidos
        for (var i = 0; i < rut.length; i++) {
            var resultado_individual = parseInt(rut.charAt(i)) * numerosAMultiplicar[i];
            resultados.push(resultado_individual);
        }

        // Suma los resultados de las multiplicaciones
        for (var j = 0; j < resultados.length; j++) {
            suma += resultados[j];
        }

        // Obtener el dígito verificador
        var dvCalculado = 11 - (suma % 11);

        // Ajusta el dígito verificador según las reglas
        if (dvCalculado === 11) {
            return '0';
        } else if (dvCalculado === 10) {
            return 'K';
        } else {
            return dvCalculado.toString();
        }
    }

    function validarRut(rutCompleto) {
        // Eliminar caracteres no válidos y convertir todo a mayúsculas (para la K)
        rutCompleto = rutCompleto.replace(/[^\dKk]/g, '').toUpperCase();
        
        // Extraer los números y el dígito verificador ingresado
        var rutNumeros = rutCompleto.slice(0, -1);  // Los primeros 8 dígitos del RUT
        var dvIngresado = rutCompleto.slice(-1);  // El último carácter es el DV

        var dvCalculado = calcularDV(rutNumeros);  // Calcula el DV

        // Comparar el dígito verificador ingresado con el calculado
        return dvIngresado === dvCalculado;
    }

    // Verifica el RUT en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        var txtRut = document.getElementById('rut');

        txtRut.addEventListener('blur', function() {
            var rut = txtRut.value;

            if ((rut) && !(validarRut(rut))) {
                alert("El RUT ingresado es incorrecto. Verifique el dígito verificador.");
                txtRut.classList.add('is-invalid');
            } else {
                txtRut.classList.remove('is-invalid');
            }
        });
    });

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
