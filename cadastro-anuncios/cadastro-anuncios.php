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
    $localidade = trim(($_POST['estado'] . ', ' . $_POST['cidade']) ?? '');
    $valor = trim($_POST['valor'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $status = 'pendente';

    if (empty($hospedes) || empty($quarto) || empty($camas) || 
        empty($banheiros) || empty($contato) || empty($localidade) || empty($valor) || 
        empty($descricao)) {
        echo "<script>alert('Todos os campos são obrigatórios!');</script>";
    } else {
        $imagem = null;
    if (!empty($_FILES['imagem']['tmp_name'])) {
        $imagem = addslashes(file_get_contents($_FILES['imagem']['tmp_name']));
    } else {
        $imagem = null;
    }

    $sql = "INSERT INTO anuncios (criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, imagem, descricao, status) 
            VALUES ('$id', '$hospedes', '$quarto', '$camas', '$banheiros', '$contato', '$localidade', '$valor', '$imagem', '$descricao', '$status')";
    if (mysqli_query($con, $sql)) {

        echo "<script>alert('Dados inseridos com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao inserir os dados: " . mysqli_error($con) . "');</script>";
        }
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
    <?php 
    if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"])) {
        echo "<div class='login-button'>
            <a href='http://localhost/A3---Projeto-AirBNB/login-page/login-page.php'> 
            <button>Faça login <i class='fa-solid fa-user'></i></button>
            </div>";
    }else{
        $nome_usuario = $_SESSION["nome_usuario"];
        echo "<div class='welcome-message'>
                <p>Olá, $nome_usuario</p>
              </div>";
    }
    ?>
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
                            <select id="estado" name="estado" required>
                                <option value="">Selecione um estado</option>
                            </select>
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </label>
                    <label>
                        <div class="input-style hover-effect">
                            <select id="cidade" name="cidade" required disabled>
                                <option value="">Selecione uma cidade</option>
                            </select>
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </label>
                    <label>
                    <div class="input-style hover-effect">
                        <input type="number" id="valor" name="valor" min="1" placeholder="Valor (em reais)" required>
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    </label>
                </div>
                <div class="input-group-two-row">
                    <label>
                    <div class="input-group-two-row">
                        <div class="input-style hover-effect">
                            <input type="number" id="hospedes" name="hospedes" min="1" placeholder="N° de Hóspedes" required>
                            <i class="fa-solid fa-people-roof"></i>
                        </div>
                    </label>
                    <label>
                        <div class="input-style hover-effect">
                            <input type="number" id="quarto" name="quarto" min="1" placeholder="N° de Quartos" required>
                            <i class="fa-solid fa-restroom"></i>
                        </div>
                    </div>
                    </label>
                </div>
                <div class="input-group-two-row">
                    <label>
                        <div class="input-style hover-effect">
                            <input type="number" id="camas" name="camas" placeholder="N° de Camas" min='1' required>
                            <i class="fa-solid fa-bed"></i>
                        </div>
                    </label>
                    <label>
                    <div class="input-style hover-effect">
                            <input type="number" id="banheiros" name="banheiros" min="1" placeholder="N° de Banheiros" required>
                            <i class="fa-solid fa-toilet"></i>
                        </div>
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
                            <input type="file" id="imagem" name="imagem" accept="image/*" required>
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
<script>
function carregarEstados() {
    fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
        .then(response => response.json())
        .then(estados => {
            const estadoSelect = document.getElementById('estado');
            estados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.sigla;
                option.text = estado.nome;
                estadoSelect.appendChild(option);
            });
        });
}

function carregarCidades(estadoSigla) {
    fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoSigla}/municipios`)
        .then(response => response.json())
        .then(cidades => {
            const cidadeSelect = document.getElementById('cidade');
            cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
            cidades.forEach(cidade => {
                const option = document.createElement('option');
                option.value = cidade.nome;
                option.text = cidade.nome;
                cidadeSelect.appendChild(option);
            });
            cidadeSelect.disabled = false;
        });
}

document.getElementById('estado').addEventListener('change', function() {
    const estadoSigla = this.value;
    if (estadoSigla) {
        carregarCidades(estadoSigla);
    } else {
        document.getElementById('cidade').innerHTML = '<option value="">Selecione uma cidade</option>';
        document.getElementById('cidade').disabled = true;
    }
});

window.onload = carregarEstados;
</script>