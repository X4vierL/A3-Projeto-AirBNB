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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Anúncios</title>
</head>
<body>
<header class="header-main">
         <div class="filters-header">
            <label for="hospede" class="filter-label">
                <input type="number" name="hospede" id="hospede" placeholder="N° de hospedes">
                <i class="fa-solid fa-people-roof"></i>
            </label>
            <label for="Quartos" class="filter-label">
                <input type="number" name="Quartos" id="Quartos" placeholder="N° de quartos">
                <i class="fa-solid fa-bed"></i>
            </label>
                <label for="Valor" class="filter-label">
                <input type="" name="Valor" id="Valor" placeholder="Valor máximo">
                <i class="fa-solid fa-dollar-sign"></i>
            </label>
            <label for="Localidade" class="filter-label">
                <input type="text" name="Localidade" id="Localidade" placeholder="Localidade">
                <i class="fa-solid fa-location-dot"></i>
            </label>

         </div>
         <div class="login-button">
            <button>Faça login <i class="fa-solid fa-user"></i></button>
         </div>
    </header>

    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <i class="fa-regular fa-map"> Travel BnB</i>
            </div>
            <ul>
                <li><a href="http://localhost/A3---Projeto-AirBNB/cadastro-anuncios/cadastro-anuncios.php"> Criar anúncio </a></li>
                <li><a href="http://localhost/A3---Projeto-AirBNB/meus-anuncios/meus-anuncios.php"> <?php echo ($_SESSION["nivel_usuario"] == 'ADM') ? 'Anúncios pendentes.' : 'Meus anúncios'; ?> </a></li>
                <li><a href="http://localhost/A3---Projeto-AirBNB/logout.php"> <i class="fa-solid fa-right-from-bracket"></i>Logout </a></li>
            </ul>
        </nav>

        <main class="container-anuncios">
            <h1 class="title">Anúncios Disponíveis</h1>
            <div class="container-cards">
                <?php
                $sql = "SELECT criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, imagem, descricao, status FROM anuncios WHERE status = 'pendente'";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                
                        if ($row['imagem']) {
                            $imagemBase64 = base64_encode($row['imagem']); // Encode the binary image data
                            echo '<img src="data:image/png;base64,' . $imagemBase64 . '" alt="Imagem" />'; // Specify PNG type explicitly
                        } else {
                            echo "Imagem não encontrada.";
                        }
                        
                            echo "<div class='card-text-content'>";
                                echo "<div class='info-value'>";
                                    echo "<p>" . $row['localidade'] . "</p>";
                                    echo "<p>Contato: " . $row['contato'] . "</p>";
                                    echo "<p>Valor: R$ " . $row['valor'] . "</p>";
                                echo "</div>";
                                echo "<div class='rooms-value'>";
                                    echo "<div class='values'>";
                                        echo "<i class='fa-solid fa-bed'><p>"  . $row['camas'] ."</p></i>";
                                    echo "</div>";
                                    echo "<div class='values'>";
                                        echo "<i class='fa-solid fa-toilet'><p>"  . $row['banheiros'] ."</p></i>";
                                    echo "</div>";
                                    // echo "<div class='values'>";
                                    //     echo "<i class='fa-solid fa-bed'><p>"  . $row['quarto'] ."</p></i>";
                                    // echo "</div>";
                                    // echo "<p>Banheiros: " . $row['banheiros'] . "</p>";
                                    // echo "<p>Quartos: " . $row['quarto'] . "</p>";
                                    // echo "<p>Descrição: " . $row['descricao'] . "</p>";
                                    // echo "<p>Status: " . $row['status'] . "</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "Nenhum anúncio encontrado.";
                }
                        ?>
            </div>
        </main>
    </div>

</body>

</html>
