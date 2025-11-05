
CREATE DATABASE IF NOT EXISTS padaria_pao_confia;
USE padaria_pao_confia;


CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    categoria_id INT,
    estoque INT DEFAULT 0,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);


CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    telefone VARCHAR(20),
    endereco TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pendente', 'preparando', 'pronto', 'entregue', 'cancelado') DEFAULT 'pendente',
    total DECIMAL(10,2) DEFAULT 0,
    observacoes TEXT,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);


CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    produto_id INT,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) GENERATED ALWAYS AS (quantidade * preco_unitario) STORED,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);


INSERT INTO categorias (nome, descricao) VALUES
('Pães', 'Pães artesanais e tradicionais'),
('Bolos', 'Bolos caseiros e especiais'),
('Salgados', 'Salgados assados e fritos'),
('Doces', 'Doces caseiros e sobremesas');

INSERT INTO produtos (nome, descricao, preco, categoria_id, estoque) VALUES
('Pão Francês', 'Pão francês tradicional', 0.80, 1, 100),
('Bolo de Chocolate', 'Bolo de chocolate caseiro', 25.00, 2, 10),
('Coxinha', 'Coxinha de frango', 4.50, 3, 50),
('Brigadeiro', 'Brigadeiro caseiro', 2.50, 4, 80);