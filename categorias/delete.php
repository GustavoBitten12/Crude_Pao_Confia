<?php
include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ID da categoria não especificado');

$database = new Database();
$db = $database->getConnection();

try {
    
    $check_query = "SELECT COUNT(*) as total FROM produtos WHERE categoria_id = ?";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(1, $id);
    $check_stmt->execute();
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['total'] > 0) {
        header("Location: read.php?message=Erro: Esta categoria possui produtos vinculados e não pode ser excluída");
        exit();
    }
    
    $query = "DELETE FROM categorias WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $id);
    
    if ($stmt->execute()) {
        header("Location: read.php?message=Categoria excluída com sucesso");
    } else {
        header("Location: read.php?message=Erro ao excluir categoria");
    }
} catch(PDOException $exception) {
    header("Location: read.php?message=Erro: " . $exception->getMessage());
}
?>