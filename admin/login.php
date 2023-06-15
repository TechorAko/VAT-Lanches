<?php

    session_start();

    if(isset($_GET["error"])) {
        switch($_GET["error"]) {
            case "forbidden":
                $alert = ["content" => "<b>Erro:</b> Acesso negado, você não está logado. Por favor, entre com a sua conta.", "type" => "danger"];
                break;
            case "unauthorized":
                $alert = ["content" => "<b>Erro:</b> Acesso negado, o usuário é inválido. Tente novamente com uma conta de administrador.", "type" => "danger"];
            default: 
        }
    }

    if(isset($_REQUEST["sair"]) && $_REQUEST["sair"] == 0) {
        session_unset();
        session_destroy();
        header('Location: '.$SERVER["PHP_SELF"].'?sair=1');
        die();
    } else if (isset($_REQUEST["sair"]) && $_REQUEST["sair"] == 1) {
        $alert = ["content" => "Você saiu da sua conta.", "type" => "warning"];
    }

    $login = "techorako";
    $pwd = "admin123";

    if(isset($_SESSION["user"]) && $_SESSION["user"] == $login) { header("Location: index.php"); die(); }

    if(isset($_POST["login"])) {
        if($_POST["login"] == $login && $_POST["pwd"] == $pwd) {
            $_SESSION["user"] = $_POST["login"];
            header("Location: ". $_SERVER["PHP_SELF"]);
            die();
        } else { $alert = ["content" => "<b>Erro:</b> Usuário inválido. Por favor, tente novamente", "context" => "danger"]; }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Entrar - VAT Lanches</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <?php $header_block = TRUE; include '../bibliotecas/bootstrap.html'; ?>
    </head>
    <body class="bg-lightgray">
        <?php include '../assets/header.php'; ?>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-lg-4 bg-light my-lg-5 p-4">
                    <div class="row justify-content-center">
                        <h2>Olá, Administrador.</h2>
                    </div>
                    <div class="row justify-content-center">
                        <p>Por favor, entre com sua conta.</p>
                    </div>
                    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                        <div class="form-row my-4">
                        <div class="col">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control" id="email" placeholder="Digite o seu login" name="login" required>
                        </div>
                        </div>
                        <div class="form-row my-4">
                        <div class="col">
                            <label for="pwsd">Senha:</label>
                            <input type="password" class="form-control" id="pswd" placeholder="Digite a sua senha" name="pwd" required>
                        </div>
                        </div>
                        <div class="form-row justify-content-center pt-5">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="col-4"></div>
        </div>

        <?php $footer_fixed = TRUE; include '../assets/footer.php'; ?>
    </body>
</html>