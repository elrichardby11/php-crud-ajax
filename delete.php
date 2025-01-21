<?php
include('config.php');

if (!isset($_GET['rut'])) {
    echo "No se ha proporcionado el RUT.";
    exit;
}

if (isset($_GET['rut'])) {
    $rut = $_GET['rut'];

    $query = "SELECT eliminar_empresa(:rut)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':rut', $rut, PDO::PARAM_INT);
    
    if (!$stmt->execute()) {
        echo "Error al eliminar la empresa.";
        exit;
    }
    
    header("Location: index.php");
    exit;
    
} 
?>
