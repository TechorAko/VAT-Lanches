<?php

    require_once 'bibliotecas/bancodedados.bli';
    require_once 'bibliotecas/db_auth';

    $legend = "Criar sua conta";
    $submit = "Cadastrar";

    if(isset($_GET["edit"])) {

        require_once "ver_auth";

        $legend = $_SESSION["nome"];
        $submit = "Alterar";

        $alterar = $vatlanches->buscar("tblcliente", "*", ["codigocliente" => $_SESSION["codigocliente"]])[0];
        
    } else {
        session_start();

        if(isset($_SESSION["codigocliente"])) {
            header("Location: perfil.php?edit=1");
            die();
        }
    }

    if(isset($_POST["signup"])) {
        switch($_POST["signup"]) {
            case "Cadastrar":
                $vatlanches->inserir("tblcliente", $_POST["tblcliente"]);
                header("Location: login.php");
                die();
                break;
            case "Alterar":
                $vatlanches->alterar("tblcliente", $_POST["tblcliente"], ["codigocliente" => $_SESSION["codigocliente"]]);
                $alert = [
                    "content" => "Seu perfil foi alterado com sucesso!",
                    "type" => "success"
                ];
                break;
            default:
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro - VAT Lanches</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <?php include_once 'bibliotecas/bootstrap.html'; ?>
    </head>
    <body class="bg-lightgray">
        <?php if(!isset($_SESSION["codigocliente"])) { $header_block = TRUE; } include 'assets/header.php';?>
        <div class="container bg-light my-sm-4 p-5">
            <div class="row d-flex justify-content-center mb-4"><h1> <?=$legend?> </h1></div>
            <div class="row d-flex justify-content-center">
                <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                        <?php if(isset($alterar)) { ?><input type="hidden" name="edit" value="1"><?php } ?>
                        <div class="row form-group"><label class="col-sm-3 col-form-label">Nome:      </label> <div class="col"><input class="form-control" type="text" name="tblcliente[nome]"       <?php if(isset($alterar)) { ?>value="<?=$alterar["nome"]    ?>"<?php }?>></div></div>
                        <div class="row form-group"><label class="col-sm-3 col-form-label">CPF:       </label> <div class="col"><input class="form-control" type="text" name="tblcliente[cpf]"        <?php if(isset($alterar)) { ?>value="<?=$alterar["cpf"]     ?>"<?php }?>></div></div>
                        <div class="row form-group"><label class="col-sm-3 col-form-label">Email:     </label> <div class="col"><input class="form-control" type="text" name="tblcliente[email]"      <?php if(isset($alterar)) { ?>value="<?=$alterar["email"]   ?>"<?php }?>></div></div>
                        <div class="row form-group"><label class="col-sm-3 col-form-label">Telefone:  </label> <div class="col"><input class="form-control" type="text" name="tblcliente[telefone]"   <?php if(isset($alterar)) { ?>value="<?=$alterar["telefone"]?>"<?php }?>></div></div>
                        <div class="row form-group"><label class="col-sm-3 col-form-label">Endereço:  </label> <div class="col"><input class="form-control" type="text" name="tblcliente[endereco]"   <?php if(isset($alterar)) { ?>value="<?=$alterar["endereco"]?>"<?php }?>></div></div>
                        <div class="row form-group d-flex justify-content-around"><button type="submit" class="btn btn-primary" name="signup" value="<?=$submit?>"><?=$submit?></button><?php if(!isset($alterar)) { ?><a href="./"><button type="button" class="btn btn-secondary">Voltar</button></a><?php } ?></div>
                </form>
            </div>
        </div>
        <?php $footer_fixed = "fixed"; include 'assets/footer.php'; ?>
    </body>
</html>