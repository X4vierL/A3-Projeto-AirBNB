<?php
include ('C:\xampp\htdocs\A3---Projeto-AirBNB\config.php');
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
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
        <form action="main-page.php" method="post" name="form1">
            <label for="hospede" class="filter-label">
                <input type="number" name="hospedes" id="hospede" placeholder="N° de hospedes">
                <i class="fa-solid fa-people-roof"></i>
            </label>
            <label for="Quartos" class="filter-label">
                <input type="number" name="quartos" id="Quartos" placeholder="N° de quartos">
                <i class="fa-solid fa-bed"></i>
            </label>
            <label for="Valor" class="filter-label">
                <input type="number" name="valor" id="Valor" placeholder="Valor máximo">
                <i class="fa-solid fa-dollar-sign"></i>
            </label>
            <label for="Localidade" class="filter-label">
                <input type="text" name="localidade" id="Localidade" placeholder="Localidade">
                <i class="fa-solid fa-location-dot"></i>
            </label>
            <label class="filter-label-search">
                <div class="container-icon-filter">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="submit" name="botao" value="Buscar">
                </div>
            </label>
        </form>
    </div>
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
            <li><a href="http://localhost/A3---Projeto-AirBNB/cadastro-anuncios/cadastro-anuncios.php"> Criar anúncio </a></li>
            <li><a href="http://localhost/A3---Projeto-AirBNB/meus-anuncios/meus-anuncios.php"> 
                <?php echo !isset($_SESSION["nivel_usuario"]) 
                    ? 'Meus anúncios' 
                    : ($_SESSION["nivel_usuario"] === 'ADM' ? 'Anúncios pendentes' : 'Meus anúncios'); ?> 
            </a></li>
            <?php if (isset($_SESSION["id_usuario"])): ?><li>
                <a href='http://localhost/A3---Projeto-AirBNB/logout.php'>
                    <i class='fa-solid fa-right-from-bracket'></i> Logout
                </a>
            </li><?php endif; ?>
        </ul>
    </nav>

    <main class="container-anuncios">
        <h1 class="title">Anúncios Disponíveis</h1>
        <div class="container-cards">
            <?php
            $sql = "SELECT id, criador, hospedes, quarto, camas, banheiros, contato, localidade, valor, imagem, descricao, status FROM anuncios WHERE status = 'aprovado'";
            if (isset($_POST['botao']) && $_POST['botao'] == "Buscar") {
                $filtros = [];
                if (!empty($_POST['hospedes'])) {
                    $n_hosp = intval($_POST['hospedes']);
                    $filtros[] = "hospedes = $n_hosp";
                }
                if (!empty($_POST['quartos'])) {
                    $n_quart = intval($_POST['quartos']);
                    $filtros[] = "quarto = $n_quart";
                }
                if (!empty($_POST['valor'])) {
                    $val_max = floatval($_POST['valor']);
                    $filtros[] = "valor <= $val_max";
                }
                if (!empty($_POST['localidade'])) {
                    $local = $_POST['localidade'];
                    $filtros[] = "localidade LIKE '%$local%'";
                }
                if (count($filtros) > 0) {
                    $sql .= " AND " . implode(" AND ", $filtros);
                }
            }
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $anuncio_link = "http://localhost/A3---Projeto-AirBNB/anuncio/anuncio.php?id=" . $row['id'];
                    echo "<div class='card'>";
                        echo "<a href='" . $anuncio_link . "'>";
                            echo "<div class='card-image-content'>";
                                if (!empty($row['imagem'])) {
                                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                    $mimeType = finfo_buffer($finfo, $row['imagem']);
                                    finfo_close($finfo);
                                
                                    $imagemBase64 = base64_encode($row['imagem']);
                                    echo "<img src='data:$mimeType;base64,$imagemBase64' alt='Imagem'/>";
                                } else {
                                    echo "Imagem não encontrada.";
                                }
                        echo "</div>";
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
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='sem-anuncio'>";
                    echo "<p>Nenhum anúncio encontrado.</p>";
                echo "</div>";
            }
            
            ?>
        </div>
    </main>
</div>
</body>
</html>
