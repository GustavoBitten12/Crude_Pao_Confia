<?php
include_once '../db.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT c.*, COUNT(p.id) as total_produtos 
          FROM categorias c 
          LEFT JOIN produtos p ON c.id = p.categoria_id 
          GROUP BY c.id 
          ORDER BY c.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - Padaria Pão e Confia</title>
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
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <div class="table-header">
                <h2>Lista de Categorias</h2>
                <a href="create.php" class="btn">Nova Categoria</a>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Total de Produtos</th>
                        <th>Data de Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($categorias) > 0): ?>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?php echo $categoria['id']; ?></td>
                                <td><?php echo htmlspecialchars($categoria['nome']); ?></td>
                                <td><?php echo htmlspecialchars($categoria['descricao']); ?></td>
                                <td><?php echo $categoria['total_produtos']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($categoria['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="update.php?id=<?php echo $categoria['id']; ?>" class="btn">Editar</a>
                                    <a href="delete.php?id=<?php echo $categoria['id']; ?>" class="btn btn-danger" 
                                       onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Nenhuma categoria encontrada</td>
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