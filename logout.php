<?php

session_start();
session_unset();
session_destroy();

echo "<script>alert('Você saiu!');top.location.href='login.php';</script>"; /*aqui voc� pode por alguma coisa falando que ele saiu ou fazer como eu, coloquei redirecionar para uma certa p�gina*/
?>