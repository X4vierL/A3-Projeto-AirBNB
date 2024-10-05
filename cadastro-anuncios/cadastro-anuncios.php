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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<div class="container">
    <header class="header-main">
         <div class="login-button">
            <button><a href="http://localhost/A3---Projeto-AirBNB/logout.php"> <i class="fa-solid fa-right-from-bracket"></i>Logout </a></i></button>
         </div>
    </header>

    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <i class="fa-regular fa-map"> Travel BnB</i>
            </div>
            <ul>
                <li><a href="http://localhost/A3---Projeto-AirBNB/meus-anuncios/meus-anuncios.php"> <?php echo ($_SESSION["nivel_usuario"] == 'ADM') ? 'Anúncios pendentes.' : 'Meus anúncios'; ?> </a></li>
            </ul>
        </nav>
    </div>

    <main class="main-container">
        <div class="form-container">
            <h2>Cadastre seu anúncio</h2>
            <form action="cadastro-anuncios.php" method="POST" enctype="multipart/form-data" class="form-wrapper">
                <div class="input-group-one-row">
                    <label>
                        <div class="input-style hover-effect">
                            <input type="text" id="contato" name="contato" maxlength="20" placeholder="Contato (telefone)" required>
                            <i class="fa-solid fa-phone"></i>
                        </div>
                    </label>
                    <label>
                        <div class="input-style hover-effect">
                            <input type="text" id="localidade" name="localidade" maxlength="20" placeholder="Localidade" required>
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </label>
                    <label>
                        <div class="input-style hover-effect">
                            <input type="number" id="valor" name="valor" placeholder="Valor (em reais)" required>
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                    </label>
                </div>
                <div class="input-group-two-row">
                    <label>
                        <div class="input-style hover-effect">
                            <input type="number" id="hospedes" name="hospedes" placeholder="N° de Hóspedes" required>
                            <i class="fa-solid fa-people-roof"></i>
                        </div>
                    </label>
                    <label>
                        <div class="input-style hover-effect">
                            <input type="number" id="quarto" name="quarto" placeholder="N° de Quartos" required>
                            <i class="fa-solid fa-restroom"></i>
                        </div>
                    </label>
                </div>
                <div class="input-group-two-row">
                    <label>
                        <div class="input-style hover-effect">
                            <input type="number" id="camas" name="camas" placeholder="N° de Camas" required>
                            <i class="fa-solid fa-bed"></i>
                        </div>
                    </label>
                    <label>
                        <div class="input-style hover-effect">
                            <input type="number" id="banheiros" name="banheiros" placeholder="N° de Banheiros" required>
                            <i class="fa-solid fa-toilet"></i>
                        </div>
                    </label>
                </div>
                <div class="input-group-one-row">
                    <label>
                        <div class="input-style text-area">
                            <p>Descreva seu imóvel:</p>
                            <textarea id="descricao" name="descricao" maxlength="255" required></textarea>
                        </div>
                    </label>
                </div>
                <div class="input-group-one-row">
                    <label>
                        <div class="input-style img">
                            <p>Fotos do imóvel:</p>
                            <input type="file" id="imagem" name="imagem" accept="image/*">
                        </div>
                    </label>
                </div>
                <div class="buttons">
                    <a href="http://localhost/A3---Projeto-AirBNB/main-page/main-page.php">Voltar</a>
                    <input type="submit" value="Criar Anúncio">
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>


        