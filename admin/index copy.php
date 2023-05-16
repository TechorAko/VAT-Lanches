<?php

    header("Location: ./");

    require_once '../bibliotecas/bancodedados.bli';
    require_once '../bibliotecas/db_auth';
    require_once 'ver_auth';

    $table = isset($_REQUEST["table"]) ? $_REQUEST["table"] : $vatlanches->tabelas[0];
    $submit_form = "Inserir";

    if(isset($_POST["submit"]) && $_POST["submit"] == "Alterar") {
        if($vatlanches->alterar($table, $_POST[$table], $_POST[$table."_primary"])) {
            $feedback["message"] = "Registro alterado com sucesso.";
            $feedback["type"] = "success-box";
        } else {
            $feedback["message"] = "Não foi possível alterar o registro.";
            $feedback["type"] = "error-box";
        }
    }

    if(isset($_POST["edit"])) {
        
        switch($_POST["edit"]) {
            case "Alterar":
                $error = $_REQUEST["edit"];
                $edit = $_POST[$table];
                $submit_form = "Alterar";
                break;
            case "Excluir":
                if($vatlanches->excluir($table, $_POST[$table])) {
                    $feedback["message"] = "Registro excluído com sucesso.";
                    $feedback["type"] = "success-box";
                } else {
                    $feedback["message"] = "Não foi possível excluir o registro.";
                    $feedback["type"] = "error-box";
                }
                break;
            default:
                $feedback["message"] = "Algo de errado ocorreu com a ação, não foi possível identificar o modo de edição.";
                $feedback["type"] = "error-box";
        }
    }

?>
<!DOCTYPE html>
    <head>
        <title>Administração - VAT Lanches</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body style="text-align: center;">
        <?php foreach($vatlanches->tabelas as $tabela) { $header_tables[$tabela] = "index%20copy.php?table=$tabela"; } include '../assets/header.php'; ?>
        <h3>Inserir Registros</h3>
        <div class="panel-view" style="border: 0px; height: auto;">
            <form action="./?table=<?=$table?>" method="POST">
                <?php include "insert.php"; ?>
                <br><input type="submit" name="submit" value="<?=$submit_form?>"> <input type="reset" value="Limpar"><br>
            </form>
        </div>
        <h3>Painel de Registros</h3>
        <div class="panel-view">
            <table align="center">
                <tr class="gray-border">
                    <th colspan="100"><?=$table?></th>
                </tr>
                <tr class="gray-border">
                    <?php
                        foreach($vatlanches->descrever($table) as $attribute) {
                            $attribute = $attribute["Field"];
                            ?><th class="gray-border"><?=$attribute?></th><?php
                        }
                    ?>
                    <th class="gray-border">Opções</th>
                </tr>
                    <?php $buscar = $vatlanches->buscar($table, "*");
                        if(is_array($buscar)) {
                            foreach($buscar as $linha) {
                                ?><tr>
                                    <form action="./?table=<?=$table?>" method="POST"> <?php
                                        foreach($linha as $atributo => $registro) { ?>
                                                <td class="gray-border"><?=$registro?></td>
                                                <input type="hidden" name="<?=$table?>[<?=$atributo?>]" value="<?=$registro?>">
                                        <?php } ?>
                                        <td class="gray-border" style="width: 120px;">
                                            <?php if($table != "tblitens") { ?><input type="submit" name="edit" value="Alterar"><?php } ?>
                                            <input type="submit" name="edit" value="Excluir">
                                        </td>
                                    </form>
                                </tr><?php
                            }
                        } else { ?><tr><td class="gray-border" colspan="100"><?=$buscar?></td><?php }
                    ?>
            </table>
        </div>
        <br>
        <?php include '../assets/footer.php'; ?>
    </body>
</html>