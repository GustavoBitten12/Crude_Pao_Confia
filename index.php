<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padaria Pão e Confia</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Padaria Pão e Confia</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="produtos/read.php">Produtos</a></li>
                    <li><a href="categorias/read.php">Categorias</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="welcome">
            <h2>Bem-vindo ao Sistema de Gestão</h2>
            <div class="dashboard">
                <div class="card">
                    <h3>Produtos</h3>
                    <p>Gerencie o catálogo de produtos</p>
                    <a href="produtos/read.php" class="btn">Acessar</a>
                </div>
                <div class="card">
                    <h3>Categorias</h3>
                    <p>Organize as categorias de produtos</p>
                    <a href="categorias/read.php" class="btn">Acessar</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Padaria Pão e Confia. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>