<?php

    require_once 'bibliotecas/bancodedados.bli';
    require_once 'bibliotecas/db_auth';
    require_once 'ver_auth';

    date_default_timezone_set("America/Fortaleza");

    if(isset($_POST["quantidade"])) {
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

        
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Encomendas - Vat Lanches</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <?php include_once 'bibliotecas/bootstrap.html'; ?>
    </head>
    <body class="bg-lightgray">
        <?php include 'assets/header.php'; ?>
        <div class="container bg-light my-sm-4 p-5">
            <h1 class="d-flex justify-content-center mb-4">Cardápio</h1>
            <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                <div class="row table-responsive">
                    <table class="table table-hover border border-muted">
                        <thead class="thead-dark">
                            <tr>
                                <th> Produto    </th>
                                <th> Categoria  </th>
                                <th> Preço      </th>
                                <th> quantidade </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $buscar = $vatlanches->buscar("tblproduto", "codigoproduto, descricao, categoria, preco");
                                if(is_array($buscar)) {
                                    foreach($buscar as $linha) { ?>
                                        <tr>
                                            <?php
                                                foreach($linha as $atributo => $registro) { 
                                                        if($atributo == "codigoproduto") { continue; }
                                                        ?> <td><?=$registro?></td> <?php
                                                }
                                            ?>
                                            <td style="width: 120px;">
                                                <input type="number" class="form-control" name="quantidade[<?=$linha["codigoproduto"]?>]" min="0" value="0">
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?><tr><td colspan="100"><?=$buscar?></td><?php }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row d-flex justify-content-around">
                    <button class="btn btn-primary" type="submit">Encomendar</button> <button class="btn btn-secondary" type="reset">Cancelar</button>
                </div>
            </form>
        </div>
        <?php include 'assets/footer.php'; ?>
    </body>
</html>
