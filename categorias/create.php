<?php
include_once '../db.php';

if ($_POST) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "INSERT INTO categorias SET nome=:nome, descricao=:descricao";
        $stmt = $db->prepare($query);
        
        $nome = htmlspecialchars(strip_tags($_POST['nome']));
        $descricao = htmlspecialchars(strip_tags($_POST['descricao']));
        
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        
        if ($stmt->execute()) {
            header("Location: read.php?message=Categoria criada com sucesso");
            exit();
        }
    } catch(PDOException $exception) {
        echo "Erro: " . $exception->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Categoria - Padaria Pão e Confia</title>
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
            <h2>Criar Nova Categoria</h2>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="nome">Nome da Categoria</label>
                    <input type="text" id="nome" name="nome" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3" maxlength="500"></textarea>
                </div>
                
                <div class="form-actions">
                    <a href="read.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Criar Categoria</button>
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