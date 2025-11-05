<?php
include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ID da categoria não especificado');

$database = new Database();
$db = $database->getConnection();

if ($_POST) {
    try {
        $query = "UPDATE categorias SET nome=:nome, descricao=:descricao WHERE id=:id";
        $stmt = $db->prepare($query);
        
        $nome = htmlspecialchars(strip_tags($_POST['nome']));
        $descricao = htmlspecialchars(strip_tags($_POST['descricao']));
        
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            header("Location: read.php?message=Categoria atualizada com sucesso");
            exit();
        }
    } catch(PDOException $exception) {
        echo "Erro: " . $exception->getMessage();
    }
}

// Buscar dados da categoria
$query = "SELECT * FROM categorias WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$categoria) {
    die("Categoria não encontrada");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria - Padaria Pão e Confia</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Padaria Pão e Confia</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Início</a></li>
                    <li><a href="../produtos/read.php">Produtos</a></li>
                    <li><a href="read.php">Categorias</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="form-container">
            <h2>Editar Categoria</h2>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
                <div class="form-group">
                    <label for="nome">Nome da Categoria</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($categoria['nome']); ?>" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3" maxlength="500"><?php echo htmlspecialchars($categoria['descricao']); ?></textarea>
                </div>
                
                <div class="form-actions">
                    <a href="read.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn">Atualizar Categoria</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Padaria Pão e Confia. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>