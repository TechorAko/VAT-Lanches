<?php

    require_once 'bibliotecas/bancodedados.bli';
    require_once 'bibliotecas/db_auth';

    $legend = "Criar sua conta";
    $submit = "Cadastrar";

    if(isset($_REQUEST["edit"])) {

        require_once "ver_auth";

        $header_tables = ["Encomendas" => "./", "Pedidos" => "pedidos.php", "Perfil" => "perfil.php?edit=1"];
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
                $feedback["message"] = "Seu perfil foi alterado com sucesso!";
                $feedback["type"] = "success-box";
                break;
            default:
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro - Vat Lanches</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <style>
            label {
                text-align: right;
                width: 50px;
            }
            .cad-input {
                position: relative ;
                left: -35px;
                display: inline-block;
                width: 150px;
            }
        </style>
    </head>
    <body style="text-align: center;">
        <?php include 'assets/header.php';?>
        <br>
        <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
            <fieldset style="margin: auto; width: 30%;">
                <legend> <?=$legend?> </legend>
                <div style="height: 40px;"></div>
                        <?php if(isset($alterar)) { ?><input type="hidden" name="edit" value="1"><?php } ?>
                        <label class="cad-input">Nome:      </label> <input class="cad-input" type="text" name="tblcliente[nome]"       <?php if(isset($alterar)) { ?>value="<?=$alterar["nome"]    ?>"<?php }?>>
                    <br><label class="cad-input">CPF:       </label> <input class="cad-input" type="text" name="tblcliente[cpf]"        <?php if(isset($alterar)) { ?>value="<?=$alterar["cpf"]     ?>"<?php }?>>
                    <br><label class="cad-input">Email:     </label> <input class="cad-input" type="text" name="tblcliente[email]"      <?php if(isset($alterar)) { ?>value="<?=$alterar["email"]   ?>"<?php }?>>
                    <br><label class="cad-input">Telefone:  </label> <input class="cad-input" type="text" name="tblcliente[telefone]"   <?php if(isset($alterar)) { ?>value="<?=$alterar["telefone"]?>"<?php }?>>
                    <br><label class="cad-input">Endereço:  </label> <input class="cad-input" type="text" name="tblcliente[endereco]"   <?php if(isset($alterar)) { ?>value="<?=$alterar["endereco"]?>"<?php }?>>
                <div style="height: 40px;"></div>
                <input type="submit" name="signup" value="<?=$submit?>">
            </fieldset>
            <?php if(!isset($alterar)) { ?><p><a href="./">Voltar</a></p><?php } ?>
        </form>
        <?php $footer_fixed = "fixed"; include 'assets/footer.php'; ?>
    </body>
</html>