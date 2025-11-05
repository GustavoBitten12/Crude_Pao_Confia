<?php
include_once '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ID do produto não especificado');

$database = new Database();
$db = $database->getConnection();

if ($_POST) {
    try {
        $query = "UPDATE produtos SET nome=:nome, descricao=:descricao, preco=:preco, categoria_id=:categoria_id, estoque=:estoque WHERE id=:id";
        $stmt = $db->prepare($query);
        
        $nome = htmlspecialchars(strip_tags($_POST['nome']));
        $descricao = htmlspecialchars(strip_tags($_POST['descricao']));
        $preco = htmlspecialchars(strip_tags($_POST['preco']));
        $categoria_id = htmlspecialchars(strip_tags($_POST['categoria_id']));
        $estoque = htmlspecialchars(strip_tags($_POST['estoque']));
        
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":categoria_id", $categoria_id);
        $stmt->bindParam(":estoque", $estoque);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            header("Location: read.php?message=Produto atualizado com sucesso");
            exit();
        }
    } catch(PDOException $exception) {
        echo "Erro: " . $exception->getMessage();
    }
}

// Buscar dados do produto
$query = "SELECT * FROM produtos WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado");
}

// Buscar categorias
$categorias = $db->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Padaria Pão e Confia</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Padaria Pão e Confia</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Início</a></li>
                    <li><a href="read.php">Produtos</a></li>
                    <li><a href="../categorias/read.php">Categorias</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="form-container">
            <h2>Editar Produto</h2>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
                <div class="form-group">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3" maxlength="500"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="preco">Preço (R$)</label>
                    <input type="number" id="preco" name="preco" step="0.01" min="0" value="<?php echo $produto['preco']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="categoria_id">Categoria</label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['id']; ?>" 
                                <?php echo $categoria['id'] == $produto['categoria_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="estoque">Estoque</label>
                    <input type="number" id="estoque" name="estoque" min="0" value="<?php echo $produto['estoque']; ?>" required>
                </div>
                
                <div class="form-actions">
                    <a href="read.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn">Atualizar Produto</button>
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