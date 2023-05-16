<?php

    require_once 'bibliotecas/bancodedados.bli';
    require_once 'bibliotecas/db_auth';
    require_once 'ver_auth';

    date_default_timezone_set("America/Fortaleza");

    if(isset($_REQUEST["request"])) { $fails = 0;
        $insert_tblencomenda = [
            "codigocliente" => $_SESSION["codigocliente"],
            "data"          => date("Y-m-d H:i:s"),
            "status"        => "Em processamento"
        ];
        $vatlanches->inserir("tblencomenda",$insert_tblencomenda);
        $insert_tblitens["codigoencomenda"] = $vatlanches->insert_id;

        foreach ($_POST["quantidade"] as $codigoproduto => $quantidade) {
            if($quantidade > 0) {
                $insert_tblitens["codigoproduto"] = $codigoproduto;
                $insert_tblitens["quantidade"] = $quantidade;
                
                $vatlanches->inserir("tblitens", $insert_tblitens);
            }
        }

        $feedback["message"] = "Sua compra foi realizada com sucesso.";
        $feedback["type"] = "success-box";
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Encomendas - Vat Lanches</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body style="text-align: center;">
        <?php $header_tables = ["Encomendas" => "./", "Pedidos" => "pedidos.php", "Perfil" => "perfil.php?edit=1"]; include 'assets/header.php'; ?>
        <br>
        <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
            <div class="panel-view">
                <table align="center">
                    <tr class="gray-border">
                        <th class="gray-border"> Produto    </th>
                        <th class="gray-border"> Categoria  </th>
                        <th class="gray-border"> Preço      </th>
                        <th class="gray-border"> quantidade </th>
                    </tr>
                    <?php $buscar = $vatlanches->buscar("tblproduto", "codigoproduto, descricao, categoria, preco");
                        if(is_array($buscar)) {
                            foreach($buscar as $linha) { ?>
                                <tr class="gray-border">
                                    <?php
                                        foreach($linha as $atributo => $registro) { 
                                                if($atributo == "codigoproduto") { continue; }
                                                ?> <td class="gray-border"><?=$registro?></td> <?php
                                        }
                                    ?>
                                    <td class="gray-border" style="width: 120px;">
                                        <input type="number" name="quantidade[<?=$linha["codigoproduto"]?>]" min="0" value="0">
                                    </td>
                                </tr>
                            <?php }
                        } else { ?><tr><td class="gray-border" colspan="100"><?=$buscar?></td><?php }
                    ?>
                </table>
            </div>
            <br><input type="submit" name="request" value="Encomendar"> <input type="reset" value="Cancelar"><br>
        </form>
        <br>
        <?php $footer_fixed = 'fixed'; include 'assets/footer.php'; ?>
    </body>
</html>
