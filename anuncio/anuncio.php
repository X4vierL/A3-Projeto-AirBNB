<!DOCTYPE html>
<html lang="pt-br">
<?php 
include ('C:\xampp\htdocs\A3---Projeto-AirBNB\config.php');
session_start();

$id_anuncio = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = @$_SESSION["id_usuario"];
$nivel = @$_SESSION["nivel_usuario"];

if ($id_anuncio > 0) {
    $sql = "SELECT criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, descricao, imagem, status 
            FROM anuncios WHERE id = $id_anuncio";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $anuncio = $result->fetch_assoc();
    } else {
        die("Anúncio não encontrado.");
    }
} else {
    die("ID do anúncio inválido.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["button"] == "aprovar") {
        $inserir = "UPDATE anuncios SET status = 'aprovado' WHERE status = 'pendente' and id = '$id_anuncio'";
        $result_inserir = mysqli_query($con, $inserir);
        if ($result_inserir) {
            echo "<script>alert('Anúncio aprovado!');</script>";
        } else {
            echo "<script>alert('Erro ao aprovar anúncio.');</script>";
        }
    } else if ($_POST["button"] == "reprovar") {
        $inserir = "UPDATE anuncios SET status = 'reprovado' WHERE status = 'pendente' and id = '$id_anuncio'";
        $result_inserir = mysqli_query($con, $inserir);
        if ($result_inserir) {
            echo "<script>alert('Anúncio reprovado.');</script>";
        } else {
            echo "<script>alert('Erro ao reprovar anúncio.');</script>";
        }
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Anúncio</title>
    <link rel="stylesheet" href="assets/css/anuncio.css">
</head>
<body>

<div class="anuncio-container">
    <div class="anuncio-header">
        <h1><?php echo htmlspecialchars($anuncio['localidade']); ?></h1>
        <p>Status: <?php echo htmlspecialchars($anuncio['status']); ?></p>
    </div>
    
    <div class="anuncio-imagem">
        <img src="<?php echo htmlspecialchars($anuncio['imagem']); ?>" alt="Imagem do Anúncio">
    </div>

    <div class="anuncio-info">
        <h2>Descrição</h2>
        <p><?php echo htmlspecialchars($anuncio['descricao']); ?></p>

        <div class="anuncio-details">
            <div>
                <h3>Detalhes</h3>
                <p><strong>Hóspedes:</strong> <?php echo htmlspecialchars($anuncio['hospedes']); ?></p>
                <p><strong>Quartos:</strong> <?php echo htmlspecialchars($anuncio['quarto']); ?></p>
                <p><strong>Camas:</strong> <?php echo htmlspecialchars($anuncio['camas']); ?></p>
                <p><strong>Banheiros:</strong> <?php echo htmlspecialchars($anuncio['banheiros']); ?></p>
            </div>
            <div>
                <h3>Contato</h3>
                <p><strong>Telefone:</strong> <?php echo htmlspecialchars($anuncio['contato']); ?></p>
                <p class="valor">Valor: R$ <?php echo number_format($anuncio['valor'], 2, ',', '.'); ?></p>
                
                <form action="" method="POST" class="status-update">
                    <button id="botao-aprovar" type="submit" value="aprovar" name="button" class="button">Aprovar</button>
                    <button id="botao-reprovar" type="submit" value="reprovar" name="button" class="button">Reprovar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<a href="http://localhost/A3---Projeto-AirBNB/main-page/main-page.php"> Home </a>

<script>
    var nivelUsuario = '<?php echo $_SESSION["nivel_usuario"]; ?>';

    function verificarNivelUsuario() {
        var botaoAprovar = document.getElementById("botao-aprovar");
        var botaoReprovar = document.getElementById("botao-reprovar");

        if (nivelUsuario === "ADM") {
            botaoAprovar.style.display = "inline-block";
            botaoReprovar.style.display = "inline-block";
        } else {
            botaoAprovar.style.display = "none";
            botaoReprovar.style.display = "none";
        }
    }

    window.onload = verificarNivelUsuario;
</script>

</body>
</html>
