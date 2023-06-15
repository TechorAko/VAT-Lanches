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

    if(isset($_POST["login"])) {

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
        <title>Entrar - VAT Lanches</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <?php include_once 'bibliotecas/bootstrap.html'; ?>
    </head>
    <body class="bg-lightgray">
        <?php $header_block = TRUE; include 'assets/header.php'; ?>
        <div class="container bg-light my-sm-5 p-3">
            <div class="row d-flex justify-content-center">
                <h1>Entre em sua conta</h1>
            </div>
            <div class="row d-flex justify-content-center m-5">
                <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                    <div class="form-group row">
                        <label for="cpf" class="col-2 col-form-label">CPF:</label>
                        <div class="col">
                            <input type="text" class="form-control" name="login" id="cpf" placeholder="xxx.xxx.xxx-xx">
                        </div>
                    </div>
                    <div class="form-group row d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary">Entrar</button>
                    </div>
                </form>
            </div>
            <div class="row d-flex justify-content-center">
                <p class="d-flex justify-content-center">Não está logado ainda? Cadastre-se <a href="perfil.php" class="ml-1"> aqui </a>.</p>
            </div>
        </div>
        <?php $footer_fixed = "fixed"; include 'assets/footer.php'; ?>
    </body>
</html>