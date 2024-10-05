<!DOCTYPE html>
<html lang="pt-br">
<?php 
include ('C:\xampp\htdocs\A3---Projeto-AirBNB\config.php');  
session_start();

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Anúncios</title>
</head>
<body>
    <h1>Anúncios Disponíveis</h1>
    <div class="container">

<?php

$sql = "SELECT id, criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, descricao, status 
       FROM anuncios 
       WHERE status = 'aprovado'";


$result = $con->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $anuncio_link = "http://localhost/A3---Projeto-AirBNB/anuncio/anuncio.php?id="  . $row['id'];

        echo "<div class='card'>";
        echo "<a href='" . $anuncio_link . "'>";
        echo "<h3>Localidade: " . htmlspecialchars($row['localidade']) . "</h3>";
        echo "<p><strong>Hospedes:</strong> " . htmlspecialchars($row['hospedes']) . "</p>";
        echo "<p><strong>Quartos:</strong> " . htmlspecialchars($row['quarto']) . "</p>";
        echo "<p><strong>Camas:</strong> " . htmlspecialchars($row['camas']) . "</p>";
        echo "<p><strong>Banheiros:</strong> " . htmlspecialchars($row['banheiros']) . "</p>";
        echo "<p><strong>Contato:</strong> " . htmlspecialchars($row['contato']) . "</p>";
        echo "<p><strong>Valor:</strong> R$ " . htmlspecialchars($row['valor']) . "</p>";
        echo "<p><strong>Descrição:</strong> " . htmlspecialchars($row['descricao']) . "</p>";
        echo "<p><strong>Status:</strong> " . htmlspecialchars($row['status']) . "</p>";
        echo "</a>";
        echo "</div>";
    }
} else {
    echo "<p>Nenhum anúncio encontrado.</p>";
}

        ?>
    </div>
</body>
<a href="http://localhost/A3---Projeto-AirBNB/logout.php"> sair </a> <br>
<a href="http://localhost/A3---Projeto-AirBNB/cadastro-anuncios/cadastro-anuncios.php"> cadastrar anuncio </a> <br>
<a href="http://localhost/A3---Projeto-AirBNB/meus-anuncios/meus-anuncios.php"> <?php echo ($_SESSION["nivel_usuario"] == 'ADM') ? 'Anúncios pendentes.' : 'Meus anúncios!'; ?> </a> <br>
</html>
