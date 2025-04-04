<?php 
include ('C:\xampp\htdocs\A3---Projeto-AirBNB\config.php');

session_start();

$id_anuncio = isset($_GET['id']) ? intval($_GET['id']) : 0;
$nivel = @$_SESSION["nivel_usuario"];
$id_usuario = @$_SESSION["id_usuario"];

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
        $inserir = "UPDATE anuncios SET status = 'aprovado' WHERE  id = '$id_anuncio'";
        $result_inserir = mysqli_query($con, $inserir);
        if ($result_inserir) {
            echo "<script>alert('Anúncio aprovado!');</script>";
        } else {
            echo "<script>alert('Erro ao aprovar anúncio.');</script>";
        }
    } else if ($_POST["button"] == "reprovar") {
        $inserir = "UPDATE anuncios SET status = 'reprovado' WHERE id = '$id_anuncio'";
        $result_inserir = mysqli_query($con, $inserir);
        if ($result_inserir) {
            echo "<script>alert('Anúncio reprovado.');</script>";
        } else {
            echo "<script>alert('Erro ao reprovar anúncio.');</script>";
        }
    } else if($_POST["button"] == "excluir") {
        $deletar = "DELETE from anuncios WHERE id = '$id_anuncio'";
        $result_deletar = mysqli_query($con, $deletar);
        if ($result_deletar) {
            echo "<script>
                alert('Anúncio excluído.');
                setTimeout(function() {
                    window.location.href = 'http://localhost/A3---Projeto-AirBNB/meus-anuncios/meus-anuncios.php';
                }, 1);
            </script>";        
        } else {
            echo "<script>alert('Erro ao excluir anúncio.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Anúncio</title>
    <link rel="stylesheet" href="assets/css/anuncio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
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
                <i class="fa-regular fa-map">Travel BnB</i>
            </div>
            <ul>
                <li><a href="http://localhost/A3---Projeto-AirBNB/cadastro-anuncios/cadastro-anuncios.php"> Criar anúncio </a></li>
                <li><a href="http://localhost/A3---Projeto-AirBNB/main-page/main-page.php"> Home </a></li>
                <?php if (isset($_SESSION["id_usuario"])): ?>
                    <li><a href='http://localhost/A3---Projeto-AirBNB/logout.php'>
                        <i class='fa-solid fa-right-from-bracket'></i> Logout</a></li>
                        <?php endif; ?>
            </ul>
        </nav>
        <h1 class="title">Detalhes do anúncio</h1>

        <div class="anuncio-container">
            <div class="anuncio-text-container">
                <div class="anuncio-info-title">
                    <p><?php echo htmlspecialchars($anuncio['localidade']); ?></p>
                    <?php if($nivel === 'ADM' || $anuncio['criador'] === $id_usuario) { ?>
                        <p class='status'>Status: <span><?php echo htmlspecialchars($anuncio['status']); ?></span></p>
                    <?php } ?>
                </div>
                <div class="box-details-contact">
                    <div class="details">
                        <div class="two-row">
                            <p><span>Hóspedes: </span><?php echo htmlspecialchars($anuncio['hospedes']); ?></p>
                            <p><span>Quartos: </span><?php echo htmlspecialchars($anuncio['quarto']); ?></p>
                        </div>
                        <div class="two-row">
                            <p><span>Camas: </span><?php echo htmlspecialchars($anuncio['camas']); ?></p>
                            <p><span>Banheiros: </span><?php echo htmlspecialchars($anuncio['banheiros']); ?></p>
                        </div>
                    </div>
                    <div class="contact">
                            <p><span><i class="fa-solid fa-phone"></i> Telefone</span> : <?php echo htmlspecialchars($anuncio['contato']); ?></p>
                            <p><span>Valor mensal:</span> R$ <?php echo number_format($anuncio['valor'], 2, ',', '.'); ?></p>
                    </div>
                </div>                        
                <div class="describe">

                    <p><span>Descrição do imóvel: </span> <?php echo htmlspecialchars($anuncio['descricao']); ?></p>
                </div>
                <div class="aprove">
                    <?php if (isset($_SESSION['nivel_usuario']) && $_SESSION['nivel_usuario'] === 'ADM'): ?>
                        <form action="" method="POST" class="status-update">
                            <?php if ($anuncio['status'] === 'pendente'): ?>
                                <button id="botao-aprovar" type="submit" value="aprovar" name="button" class="aprove">Aprovar</button>
                                <button id="botao-reprovar" type="submit" value="reprovar" name="button" class="reprove">Reprovar</button>
                            <?php elseif ($anuncio['status'] === 'aprovado'): ?>
                                <button id="botao-reprovar" type="submit" value="reprovar" name="button" class="reprove">Reprovar</button>
                            <?php elseif ($anuncio['status'] === 'reprovado'): ?>
                                <button id="botao-aprovar" type="submit" value="aprovar" name="button" class="aprove">Aprovar</button>
                                <button id="botao-excluir" type="submit" value="excluir" name="button" class="reprove">Excluir</button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="anuncio-image-container">
                <?php
                    if (!empty($anuncio['imagem'])) {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_buffer($finfo, $anuncio['imagem']);
                        finfo_close($finfo);
            
                        $imagemBase64 = base64_encode($anuncio['imagem']);
                        echo "<img src='data:$mimeType;base64,$imagemBase64' alt='Imagem'/>";
                    } else {
                        echo "<div class='no-image'>";
                            echo "<i class='fa-regular fa-file-image'></i>";
                            echo "Imagem não encontrada.";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </div>

</body>
</html>
