<?php

    session_start();

    require_once 'bibliotecas/bancodedados.bli';
    require_once 'bibliotecas/db_auth';

    if(isset($_REQUEST["sair"])) {
        session_unset();
        session_destroy();
        header('Location: '. $_SERVER["PHP_SELF"]);
        die();
    }

    if(isset($_SESSION["codigocliente"])) { header("Location: index.php"); die(); }

    if(isset($_REQUEST["signin"])) {

        $sql = "SELECT codigocliente, nome, cpf FROM tblcliente WHERE cpf = '". $_POST["login"] ."'";
        $result = $con->query($sql);
        $data = $result->fetch_array(MYSQLI_ASSOC);

        if(isset($data) && $_POST["login"] == $data["cpf"]) {
            $_SESSION["codigocliente"] = $data["codigocliente"];
            $_SESSION["nome"] = $data["nome"];
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
        <?php include 'assets/header.php'; ?>
        <br>
        <form action="login.php" method="POST">
            <fieldset style="margin: auto; width: 30%;">
                <legend> Entre em sua conta </legend>
                <div style="height: 50px;"></div>
                <label>CPF: </label><input type="text" name="login" maxlength="19" placeholder="Digite o seu CPF"><br>
                <div style="height: 50px;"></div>
                <input type="submit" name="signin" value="Entrar">
            </fieldset>
        </form>
        <p>Não está logado ainda? Cadastre-se <a href="perfil.php">aqui</a> agora.</p>
        <?php $footer_fixed = "fixed"; include 'assets/footer.php'; ?>
    </body>
</html>