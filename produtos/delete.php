<?php
include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ID do produto não especificado');

$database = new Database();
$db = $database->getConnection();

try {
    $query = "DELETE FROM produtos WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $id);
    
    if ($stmt->execute()) {
        header("Location: read.php?message=Produto excluído com sucesso");
    } else {
        header("Location: read.php?message=Erro ao excluir produto");
    }
} catch(PDOException $exception) {
    if ($exception->getCode() == '23000') {
        header("Location: read.php?message=Erro: Este produto está vinculado a pedidos e não pode ser excluído");
    } else {
        header("Location: read.php?message=Erro: " . $exception->getMessage());
    }
}
?>