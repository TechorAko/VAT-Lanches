<?php

    require_once 'bibliotecas/bancodedados.bli';
    require_once 'bibliotecas/db_auth';
    require_once 'ver_auth';

    if(isset($_REQUEST["cancel"])) {

        $sql = "SELECT `status` FROM tblencomenda WHERE codigoencomenda = ". $_POST["codigoencomenda"];
        $check = $con->query($sql);
        $status = $check->fetch_array(MYSQLI_ASSOC)["status"];

        if($status == "Em processamento") {
            $vatlanches->alterar("tblencomenda", ["status" => "Cancelado"], ["codigoencomenda" => $_POST["codigoencomenda"]]);
            $feedback["message"] = "Seu pedido foi cancelado com sucesso.";
            $feedback["type"] = "success-box";
        } else {
            $feedback["message"] = "Erro: Este pedido não pode ser cancelado.";
            $feedback["type"] = "error-box";
        }
        
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pedidos - Vat Lanches</title>
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
                <div class="panel-view" style="height: 380px;">
                    <table align="center">
                        <tr>
                            <th class="gray-border"> Data   </th>
                            <th class="gray-border"> Itens  </th>
                            <th class="gray-border"> Status </th>
                            <th class="gray-border"> Opções </th>
                        </tr>
                        <?php
                            $tblencomenda = $vatlanches->buscar("tblencomenda", "tblencomenda.*", ["tblencomenda.codigocliente" => $_SESSION["codigocliente"]]);

                            if(is_array($tblencomenda)) {
                                foreach($tblencomenda as $linha_encomenda) { ?>
                                    <form action="pedidos.php" method="POST">
                                    <tr class="gray-border">
                                        <input type="hidden" name="codigoencomenda" value="<?=$linha_encomenda["codigoencomenda"]?>">
                                        <td class="gray-border"><?=$linha_encomenda["data"]?></td>
                                        <td class="gray-border" style="padding: 0;">
                                            <table>
                                                <?php

                                                    $sql = "SELECT tblproduto.descricao, tblitens.quantidade, tblproduto.preco FROM tblitens, tblproduto, tblencomenda WHERE tblitens.codigoencomenda = ". $linha_encomenda["codigoencomenda"] ." AND tblitens.codigoproduto = tblproduto.codigoproduto AND tblencomenda.codigoencomenda = tblitens.codigoencomenda";
                                                    $tblitens = $vatlanches->fetch_multiarray($sql, MYSQLI_ASSOC);

                                                    $preco = 0;

                                                    foreach($tblitens as $linha_itens) {
                                                        ?> <tr> <?php
                                                            foreach($linha_itens as $atributo => $item) { if($atributo == "preco") { $preco += $item * $linha_itens["quantidade"]; continue; }?>
                                                                <td class="gray-border"><?=$item?></td>
                                                            <?php }
                                                        ?> </tr> <?php
                                                    }

                                                ?>
                                                <tr>
                                                    <th class="gray-border" colspan="3">R$<?=$preco?></th>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="gray-border"><?=$linha_encomenda["status"]?></td>
                                        <td class="gray-border" style="width: 150px;">
                                            <input type="submit" name="cancel" value="Cancelar">
                                        </td>
                                    </tr>
                                    </form>
                                <?php }
                            } else { ?><tr><td class="gray-border" colspan="100"><?=$tblencomenda?></td><?php }
                        ?>
                    </table>
                </div>
            <br>
        <?php $footer_fixed = 'fixed'; include 'assets/footer.php'; ?>
    </body>
</html>