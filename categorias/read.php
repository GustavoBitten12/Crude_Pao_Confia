<?php
include_once '../db.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT p.*, c.nome as categoria_nome 
          FROM produtos p 
          LEFT JOIN categorias c ON p.categoria_id = c.id 
          ORDER BY p.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Padaria Pão e Confia</title>
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
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <div class="table-header">
                <h2>Lista de Produtos</h2>
                <a href="create.php" class="btn">Novo Produto</a>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($produtos) > 0): ?>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?php echo $produto['id']; ?></td>
                                <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                                <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
                                <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($produto['categoria_nome']); ?></td>
                                <td><?php echo $produto['estoque']; ?></td>
                                <td class="actions">
                                    <a href="update.php?id=<?php echo $produto['id']; ?>" class="btn">Editar</a>
                                    <a href="delete.php?id=<?php echo $produto['id']; ?>" class="btn btn-danger" 
                                       onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Nenhum produto encontrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Padaria Pão e Confia. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>