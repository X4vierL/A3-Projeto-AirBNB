<!DOCTYPE html>
<html lang="pt-br">
<?php 
include ('C:\xampp\htdocs\A3---Projeto-AirBNB\config.php');
require ('C:\xampp\htdocs\A3---Projeto-AirBNB\verify.php');

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Anúncios</title>
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
    <h1><?php echo ($_SESSION["nivel_usuario"] == 'ADM') ? 'Anúncios pendentes.' : 'Meus anúncios!'; ?>
    </h1>
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

        <main class="container-anuncios">
        <h1 class="title"><?php echo ($_SESSION["nivel_usuario"] == 'ADM') ? 'Anúncios pendentes.' : 'Meus anúncios!'; ?></h1>
            <div class="container-cards">
<?php

$user = $_SESSION["id_usuario"];
$sql = $_SESSION["nivel_usuario"] == 'ADM' 
    ? "SELECT id, criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, imagem, descricao, status 
       FROM anuncios 
       WHERE status IN ('pendente','reprovado')" 
    : "SELECT id, criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, imagem, descricao, status 
       FROM anuncios 
       WHERE criador = '$user'";

// echo "<a href='" . $anuncio_link . "'>";
$result = $con->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $anuncio_link = "http://localhost/A3---Projeto-AirBNB/anuncio/anuncio.php?id=" . $row['id'];

            echo "<div class='card'>";
                echo "<a href='" . $anuncio_link . "' class='card-after-link'>";
                    echo "<div class='card-image-content'>";
                        if (!empty($row['imagem'])) {
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mimeType = finfo_buffer($finfo, $row['imagem']);
                            finfo_close($finfo);
                
                            $imagemBase64 = base64_encode($row['imagem']);
                            echo "<img src='data:$mimeType;base64,$imagemBase64' alt='Imagem'/>";
                        } else {
                            echo "<div class='no-image'>";
                                echo "<i class='fa-regular fa-file-image'></i>";
                                echo "Imagem não encontrada.";
                            echo "</div>";
                        }
                    echo "</div>";
                    echo "<div class='card-text-content'>";
                        echo "<p>Localidade: " . htmlspecialchars($row['localidade']) . "</p>";
                        echo "<p><strong>Hospedes:</strong> " . htmlspecialchars($row['hospedes']) . "</p>";
                        echo "<p><strong>Quartos:</strong> " . htmlspecialchars($row['quarto']) . "</p>";
                        echo "<p><strong>Camas:</strong> " . htmlspecialchars($row['camas']) . "</p>";
                        echo "<p><strong>Banheiros:</strong> " . htmlspecialchars($row['banheiros']) . "</p>";
                        echo "<p><strong>Contato:</strong> " . htmlspecialchars($row['contato']) . "</p>";
                        echo "<p><strong>Valor:</strong> R$ " . htmlspecialchars($row['valor']) . "</p>";
                        echo "<p><strong>Descrição:</strong> " . htmlspecialchars($row['descricao']) . "</p>";
                        echo "<p><strong>Status:</strong> " . htmlspecialchars($row['status']) . "</p>";
                    echo "</div>";
                echo "</a>";
            echo "</div>";
        // echo "<div class='card'>";


        // echo "</a>";
        // echo "</div>";
    }
} else {
    echo "<p>Nenhum anúncio encontrado.</p>";
}
?>
           </div>
        </main>
    </div>
</body>
</html>
