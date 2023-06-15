<?php

    include '../../bibliotecas/bancodedados.bli';
    include '../../bibliotecas/db_auth';
    include '../ver_auth';

    function status_bg($status) {
        switch($status) {
            case "Em processamento": return "text-secondary border border-secondary";
            case "Em andamento": return "text-warning border border-warning";
            case "A caminho": return "text-primary border border-primary";
            case "Enviado": return "text-success border border-success";
            case "Cancelado": return "text-danger border border-danger";
            default: return "bg-white";
        }
    }

    if(isset($_POST["status"])) {
        $vatlanches->alterar("tblencomenda", ["status" => $_POST["status"]], ["codigoencomenda" => $_POST["encomenda"]]);
        $alert = [
            "content" => "Status do pedido #". $_POST["encomenda"] ." alterado com sucesso.",
            "type" => "success"
        ];
    }

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <title>Clientes - VAT Lanches</title>
    <?php include_once '../../bibliotecas/bootstrap.html'; ?>
</head>
<body class="bg-lightgray">
    <?php include_once '../../assets/header.php'; ?>
    <div class="container bg-light my-lg-4 px-lg-5">
        <div class="row">
            <div class="col d-flex justify-content-center mt-4">
                <h1>Encomendas</h1>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table border border-muted table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="d-none d-md-table-cell">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Data</th>
                            <th scope="col">Status</th>
                            <th scope="col">Itens</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
    
                            $sql = "SELECT tblencomenda.codigoencomenda, tblcliente.nome, tblencomenda.data, tblencomenda.status, tblencomenda.codigocliente FROM tblencomenda, tblcliente WHERE tblencomenda.codigocliente = tblcliente.codigocliente";
                            $encomendas = $vatlanches->fetch_multiarray($sql, MYSQLI_ASSOC);

                            if(is_array($encomendas)) { foreach($encomendas as $encomenda) { ?>
                                <tr class="<?=status_bg($encomenda["status"])?>">
                                    <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                                        <th scope="row" class="d-none d-md-table-cell">
                                            <input type="hidden" name="encomenda" value="<?=$encomenda["codigoencomenda"]?>">
                                            <?=$encomenda["codigoencomenda"]?>
                                        </th>
                                        <td><?=$encomenda["nome"]?></td>
                                        <td><?=$encomenda["data"]?></td>
                                        <td>
                                            <select name="status" onchange="this.form.submit()">
                                                <?php

                                                    $status = ["Em processamento", "Em andamento", "A caminho", "Enviado", "Cancelado"];

                                                    foreach($status as $state) {
                                                        ?><option value="<?=$state?>" <?php if($state == $encomenda["status"]) { echo "selected"; } ?>><?=$state?></option><?php
                                                    }

                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="table-responsive table-sm">
                                                <table class="table table-hover bg-white border border-muted">
                                                    <tbody>
                                                        <?php

                                                            $sql = "SELECT tblproduto.codigoproduto, tblproduto.descricao, tblitens.quantidade, tblproduto.preco FROM tblitens, tblproduto, tblencomenda WHERE tblitens.codigoencomenda = ". $encomenda["codigoencomenda"] ." AND tblitens.codigoproduto = tblproduto.codigoproduto AND tblencomenda.codigoencomenda = tblitens.codigoencomenda";
                                                            $itens = $vatlanches->fetch_multiarray($sql, MYSQLI_ASSOC);

                                                            $total = 0;

                                                            foreach($itens as $item) { ?>
                                                                <tr>
                                                                    <th scope="row" class="d-none d-md-table-cell"><?=$item["codigoproduto"]?></th>
                                                                    <td><?=$item["descricao"]?></td>
                                                                    <td class="d-flex justify-content-end"><?=$item["preco"]?></td>
                                                                    <td class="d-none d-md-table-cell"><?=$item["quantidade"]?></td>
                                                                </tr> <?php
                                                                $total += $item["preco"] * $item["quantidade"];
                                                            } 
                                                        ?>
                                                    </tbody>
                                                    <tfoot class="tfoot-dark">
                                                        <th colspan="100">R$<?=$total?></th>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    <?php include_once '../../assets/footer.php'; ?>
</body>
</html>