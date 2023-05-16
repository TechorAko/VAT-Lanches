<?php

    session_start();

    if(isset($_REQUEST["sair"])) {
        session_unset();
        session_destroy();
        header('Location: '. $_SERVER["PHP_SELF"]);
        die();
    }

    $login = "techorako";
    $pwd = "admin123";

    if(isset($_SESSION["user"]) && $_SESSION["user"] == $login) { header("Location: index.php"); die(); }

    if(isset($_REQUEST["signin"])) {
        if($_POST["login"] == $login && $_POST["pwd"] == $pwd) {
            $_SESSION["user"] = $_POST["login"];
            header("Location: ". $_SERVER["PHP_SELF"]);
            die();
        } else { $error = "Usuário inválido. Por favor, tente novamente."; }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Entrar :: Administração - VAT Lanches</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
    </head>
    <body style="text-align: center;">
        <?php include '../assets/header.php'; ?>
        <br>
        <form action="login.php" method="POST">
            <fieldset style="margin: auto; width: 30%;">
                <legend> Entre em sua conta </legend>
                <div style="height: 50px;"></div>
                <label>Login: </label><input type="text" name="login" maxlength="20" placeholder="Digite o seu login"><br>
                <label>Senha: </label><input type="password" name="pwd" minlength="8" placeholder="Digite sua senha"><br>
                <div style="height: 50px;"></div>
                <input type="submit" name="signin" value="Entrar">
            </fieldset>
        </form>

        <p>Não é um administrator? Clique <a href="../login.php">aqui</a> para voltar ao site.</p>

        <?php $footer_fixed = "fixed"; include '../assets/footer.php'; ?>
    </body>
</html>