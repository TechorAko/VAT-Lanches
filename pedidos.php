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
        <?php include_once 'bibliotecas/bootstrap.html'; ?>
    </head>
    <body class="bg-lightgray">
        <?php include 'assets/header.php'; ?>
                <div class="container bg-light my-sm-4 p-5">
                    <h1 class="d-flex justify-content-center mb-4">Pedidos</h1>
                    <div class="table-responsive">
                        <table class="table table-hover border border-muted">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"> Data   </th>
                                    <th scope="col"> Itens  </th>
                                    <th scope="col"> Status </th>
                                    <th scope="col"> Opções </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $tblencomenda = $vatlanches->buscar("tblencomenda", "tblencomenda.*", ["tblencomenda.codigocliente" => $_SESSION["codigocliente"]]);

                                    if(is_array($tblencomenda)) {
                                        foreach($tblencomenda as $linha_encomenda) { ?>
                                            <form action="pedidos.php" method="POST">
                                            <tr>
                                                <input type="hidden" name="codigoencomenda" value="<?=$linha_encomenda["codigoencomenda"]?>">
                                                <td><?=$linha_encomenda["data"]?></td>
                                                <td style="padding: 0;">
                                                    <table class="table">
                                                        <tbody>
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
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="3">R$<?=$preco?></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </td>
                                                <td><?=$linha_encomenda["status"]?></td>
                                                <td style="width: 150px;">
                                                    <button type="submit" class="btn btn-danger" name="cancel" value="1">Cancelar</button>
                                                </td>
                                            </tr>
                                            </form>
                                        <?php }
                                    } else { ?><tr><td class="gray-border" colspan="100"><?=$tblencomenda?></td><?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        <?php include 'assets/footer.php'; ?>
    </body>
</html>