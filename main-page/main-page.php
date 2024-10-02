<!DOCTYPE html>
<html lang="pt-br">
<?php include ('C:\xampp\htdocs\A3---Projeto-AirBNB\config.php'); ?>
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
$sql = "SELECT criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, descricao, status FROM anuncios WHERE status = 'pendente'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<h3>" . $row['localidade'] . "</h3>";
        echo "<p><strong>Hospedes:</strong> " . $row['hospedes'] . "</p>";
        echo "<p><strong>Quartos:</strong> " . $row['quarto'] . "</p>";
        echo "<p><strong>Camas:</strong> " . $row['camas'] . "</p>";
        echo "<p><strong>Banheiros:</strong> " . $row['banheiros'] . "</p>";
        echo "<p><strong>Contato:</strong> " . $row['contato'] . "</p>";
        echo "<p><strong>Valor:</strong> R$ " . $row['valor'] . "</p>";
        echo "<p><strong>Descrição:</strong> " . $row['descricao'] . "</p>";
        echo "<p><strong>Status:</strong> " . $row['status'] . "</p>";
        echo "</div>";
    }
} else {
    echo "Nenhum anúncio encontrado.";
}
        ?>
    </div>
</body>
</html>
