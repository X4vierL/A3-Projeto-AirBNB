<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>A3 - TravelBnB</title>
</head>
<body>
    <div class="scene">
        <div class="card container">
            <div class="card-face login-card">
                <div class="top-text-container">
                    <h1>Bem Vindo!</h1>
                    <p>Por gentileza, entre em sua conta.</p>
                </div>
                <form action="#" class="form-login">
                    <label for="user" name="user" class="input-account">
                        <input type="text" name="user" id="user" placeholder="Usuário">
                        <i class="fa-solid fa-user"></i>
                    </label>
                    <label for="password" name="password" class="input-account">
                        <input type="password" name="password" id="password" placeholder="Senha">
                        <i class="fa-solid fa-lock"></i>
                    </label>
                    <input type="submit" value="Entrar" class="button-login">
                </form>
                <div class="bottom-text-container">
                    <p>Não tem conta? Clique abaixo <i class="fa-solid fa-arrow-down"></i></p>
                    <button class="button-register" id="buttom-register">Criar minha conta</button>
                </div>
            </div>
            <div class="card-face register-card">
                 <div class="top-text-container">
                    <h1>Bem Vindo!</h1>
                    <p>Preencha os dados para criar sua conta nova.</p>
                </div>
                <form action="#" class="form-register">
                    <label for="user" name="user" class="input-account">
                        <input type="text" name="user" id="user" placeholder="Usuário">
                        <i class="fa-solid fa-user"></i>
                    </label>
                    <label for="email" name="email" class="input-account">
                        <input type="text" name="email" id="email" placeholder="Email">
                        <i class="fa-solid fa-envelope"></i>
                    </label>
                    <label for="password" name="password" class="input-account">
                        <input type="password" name="password" id="password" placeholder="Senha">
                        <i class="fa-solid fa-lock"></i>
                    </label>
                    <input type="submit" value="Entrar" class="button-login">
                </form> 
                <div class="bottom-text-container">
                    <p>Já tem uma conta? Clique abaixo <i class="fa-solid fa-arrow-down"></i></p>
                    <button class="button-login-open" id="buttom-login">Já tenho conta!</button>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/login.js"></script>
</body>
</html>