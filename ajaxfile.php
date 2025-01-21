<?php

include('config.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'fetch_detail_by_rut':
            if (isset($_GET['rut'])) {
                fetchDetailsByRut($pdo, $_GET['rut']);
            }
            break;
        case 'fetch_comunas_by_region':
            if (isset($_GET['id_region'])) {
                fetchComunasByRegion($pdo, $_GET['id_region']);
            }
            break;
        case 'fetch_ciudad_by_comuna':
            if (isset($_GET['id_comuna'])) {
                fetchCiudadByComuna($pdo, $_GET['id_comuna']);
            }
            break;
    }
} else {
    fetchDetails($pdo);
}

function fetchDetails($pdo)
{
    $query = "SELECT * FROM get_empresas()";
    $stmt = $pdo->query($query);
    $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($empresas as $empresa) {
        echo "
            <tr>
                <td>
                    <a href=\"details.php?rut=" . urlencode($empresa['rut']) . "\">
                        " . htmlspecialchars($empresa['rut']) . "-" . htmlspecialchars($empresa['dv']) . "
                    </a>
                </td>
                <td>" . htmlspecialchars($empresa['codigo']) . "</td>
                <td>" . htmlspecialchars($empresa['razon_social']) . "</td>
                <td>" . htmlspecialchars($empresa['giro']) . "</td>
                <td>" . htmlspecialchars($empresa['e_mail']) . "</td>
                <td>" . ($empresa['vigente'] ? 'Sí' : 'No') . "</td>
            </tr>
        ";
    }
}

function fetchDetailsByRut($pdo, $rut)
{
    $query = "SELECT * FROM get_empresas_detalle(?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$rut]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['rut']) . "-" . htmlspecialchars($row['dv']) . "</td>
                <td>" . htmlspecialchars($row['codigo']) . "</td>
                <td>" . htmlspecialchars($row['razon_social']) . "</td>
                <td>" . htmlspecialchars($row['giro']) . "</td>
                <td>" . htmlspecialchars($row['e_mail']) . "</td>
                <td>" . ($row['vigente'] ? 'Sí' : 'No') . "</td>
                <td>" . htmlspecialchars($row['observacion']) . "</td>
                <td>" . htmlspecialchars($row['direccion']) . "</td>
                <td>" . htmlspecialchars($row['telefono']) . "</td>
                <td>" . htmlspecialchars($row['categoria_nombre']) . "</td>
                <td>" . htmlspecialchars($row['comuna_nombre']) . "</td>
              </tr>";
    }
}

function fetchComunasByRegion($pdo, $regionId)
{
    $query = "SELECT * FROM comuna WHERE id_region = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$regionId]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
    }
}

function fetchCiudadByComuna($pdo, $comunaId)
{
    $query = "SELECT * FROM ciudad WHERE id_comuna = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$comunaId]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) .  '</option>';
    }
}
