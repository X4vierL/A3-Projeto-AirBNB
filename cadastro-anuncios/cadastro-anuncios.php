<!DOCTYPE html>
<html lang="pt-br">
<?php 
include ('C:\xampp\htdocs\A3---Projeto-AirBNB\config.php');
require ('C:\xampp\htdocs\A3---Projeto-AirBNB\verify.php');

$id = $_SESSION["id_usuario"];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hospedes = trim($_POST['hospedes'] ?? '');
    $quarto = trim($_POST['quarto'] ?? '');
    $camas = trim($_POST['camas'] ?? '');
    $banheiros = trim($_POST['banheiros'] ?? '');
    $contato = trim($_POST['contato'] ?? '');
    $localidade = trim($_POST['localidade'] ?? '');
    $valor = trim($_POST['valor'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if (empty($hospedes) || empty($quarto) || empty($camas) || 
        empty($banheiros) || empty($contato) || empty($localidade) || empty($valor) || 
        empty($descricao)) {
        echo "<script>alert('Todos os campos são obrigatórios!');</script>";
    } else {
        $imagem = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
            $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
        }
        $inserir = "INSERT INTO anuncios (criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, imagem, descricao, status) 
                    VALUES ('$id', '$hospedes', '$quarto', '$camas', '$banheiros', '$contato', '$localidade', '$valor', ?, '$descricao', 'pendente')";
        $stmt = $con->prepare($inserir);
        $stmt->bind_param("b", $imagem);
        
        if ($stmt->execute()) {
            echo "<script>alert('Anúncio cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar o anúncio!');</script>";
        }
        $stmt->close();
    }
}
?>
<head>
    <meta charset="UTF-8">
    <title>A3 - TravelBnB</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Criação de Anúncios</h1>
    </header>

    <nav class="sidebar">
        <ul>
            <li><a href="#">Item 1</a></li>
            <li><a href="#">Item 2</a></li>
            <li><a href="#">Item 3</a></li>
        </ul>
    </nav>

    <main class="main-container">
        <div class="form-container">
            <h2>Formulário</h2>
            <form action="cadastro-anuncios.php" method="POST" enctype="multipart/form-data">
                <label for="hospedes">Quantidade de Hóspedes:</label>
                <input type="number" id="hospedes" name="hospedes" required><br>

                <label for="quarto">Número de Quartos:</label>
                <input type="number" id="quarto" name="quarto" required><br>

                <label for="camas">Número de Camas:</label>
                <input type="number" id="camas" name="camas" required><br>

                <label for="banheiros">Número de Banheiros:</label>
                <input type="number" id="banheiros" name="banheiros" required><br>

                <label for="contato">Contato (telefone):</label>
                <input type="text" id="contato" name="contato" maxlength="20" required><br>

                <label for="localidade">Localidade:</label>
                <input type="text" id="localidade" name="localidade" maxlength="20" required><br>

                <label for="valor">Valor (em reais):</label>
                <input type="number" id="valor" name="valor" required><br>

                <label for="imagem">Imagem do Imóvel:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*"><br>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" maxlength="255" required></textarea><br><br>

                <input type="submit" value="Salvar">
            </form>
            <a href="http://localhost/A3---Projeto-AirBNB/main-page/main-page.php">Voltar</a>
        </div>
    </main>
</div>
</body>
</html>


        