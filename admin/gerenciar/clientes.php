<?php

    include '../../bibliotecas/bancodedados.bli';
    include '../../bibliotecas/db_auth';
    include '../ver_auth';

    if(isset($_REQUEST["insert"])) {
        $vatlanches->inserir("tblcliente", $_POST["cliente"]);
        $alert = ["content" => "<strong>". $_POST["cliente"]["nome"] . "</strong> foi adicionado com sucesso com sucesso.", "type" => "success"];

    } else if(isset($_REQUEST["edit"])) {
        switch($_REQUEST["edit"]) {
            case 0: $tblcliente = $vatlanches->buscar("tblcliente", "*", ["codigocliente" => $_POST["cliente"]])[0]; // 
                break;
            case 1:
                $vatlanches->alterar("tblcliente", $_POST["cliente"], ["codigocliente" => $_POST["cliente"]["codigocliente"]]);
                $alert = [
                    "content" => "<strong>". $_POST["cliente"]["nome"] . "</strong> foi alterado com sucesso com sucesso.",
                    "type" => "success"
                ];
                break;
            default:
        }
    } else if(isset($_REQUEST["delete"])) {
        $nome = $vatlanches->buscar("tblcliente", "*", ["codigocliente" => $_POST["cliente"]])[0]["nome"];
        $vatlanches->excluir("tblcliente", ["codigocliente" => $_POST["cliente"]]);
        $alert = ["content" => "<strong>". $nome . "</strong> foi excluído com sucesso.", "type" => "success"];
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
                <h1>Clientes</h1>
            </div>
        </div>
        <div class="row">
            <div class="container my-3">
                <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST" class="form" enctype="multipart/form-data">
                    <?php if(isset($_POST["edit"]) && $_POST["edit"] == 0) { ?><input type="hidden" name="cliente[codigocliente]" value="<?=$_POST["cliente"]?>"><?php } ?>
                    <div class="form-group row">
                        <div class="col-lg">
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" placeholder="Insira o nome de um cliente" name="cliente[nome]" <?php if(isset($tblcliente["nome"])) { ?>value="<?=$tblcliente["nome"]?>"<?php } ?> required>
                        </div>
                        <div class="col-lg-5">
                            <label for="cpf">CPF:</label>
                            <input type="text" class="form-control" id="cpf" placeholder="xxx.xxx.xxx-xx" name="cliente[cpf]" <?php if(isset($tblcliente["cpf"])) { ?>value="<?=$tblcliente["cpf"]?>"<?php } ?> required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg">
                            <label for="email">Email:</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input type="email" class="form-control" id="email" placeholder="exemplo@email.com" name="cliente[email]" <?php if(isset($tblcliente["email"])) { ?>value="<?=$tblcliente["email"]?>"<?php } ?> required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg">
                            <label for="nome">Endereço:</label>
                            <input type="text" class="form-control" id="nome" placeholder="Rua ... - Bairro ..." name="cliente[endereco]" <?php if(isset($tblcliente["endereco"])) { ?>value="<?=$tblcliente["endereco"]?>"<?php } ?> required>
                        </div>
                        <div class="col-lg">
                            <label for="telefone">Telefone:</label>
                            <input type="telephone" class="form-control" id="telefone" placeholder="+xx (xx) xxxx-xxxx" name="cliente[telefone]" <?php if(isset($tblcliente["telefone"])) { ?>value="<?=$tblcliente["telefone"]?>"<?php } ?> required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg"></div>
                        <div class="col-lg-4 d-flex justify-content-around">
                            <?php if(!isset($tblcliente)) { ?><button type="submit" name="insert" value="1" class="btn btn-success">Adicionar Cliente</button><?php } else { ?><button type="submit" name="edit" value="1" class="btn btn-success">Alterar Cliente</button> <button type="button" class="btn btn-danger" onclick="window.location.assign(window.location.href)">Cancelar</button><?php } ?>
                        </div>
                        <div class="col-lg"></div>
                    </div>
                  </form>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table border border-muted table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"  class="d-none d-sm-table-cell">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Email</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <style>
                            #edit-button:hover { background-color: #28a745; border-color: #28a745; }
                            #delete-button:hover { background-color: #dc3545; border-color: #dc3545; }
                        </style>
                        <?php
    
                            $clientes = $vatlanches->buscar("tblcliente");
    
                            foreach($clientes as $cliente) { ?>
                                <tr>
                                    <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                                        <th scope="row" class="d-none d-sm-table-cell">
                                            <input type="hidden" name="cliente" value="<?=$cliente["codigocliente"]?>">
                                            <?=$cliente["codigocliente"]?>
                                        </th>
                                        <td><?=$cliente["nome"]?></td>
                                        <td><?=$cliente["email"]?></td>
                                        <td><?=$cliente["cpf"]?></td>
                                        <td><?=$cliente["telefone"]?></td>
                                        <td><?=$cliente["endereco"]?></td>
                                        <td class="d-flex justify-content-around">
                                            <button class="btn btn-secondary" id="edit-button" name="edit" value="0" type="submit"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-secondary" id="delete-button" type="button" data-toggle="modal" data-target="#confirmDelete<?=$cliente["codigocliente"]?>"><i class="fas fa-trash"></i></button>
                                            <div class="modal fade" id="confirmDelete<?=$cliente["codigocliente"]?>" tabindex="-1" aria-labelledby="confirmDelete<?=$cliente["codigocliente"]?>Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmDelete<?=$cliente["codigocliente"]?>Label">Confirmar exclusão</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Você está prestes a excluir <strong><?=$cliente["nome"]?></strong>. Tem certeza de quer fazer isso?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <button class="btn btn-danger" type="submit" name="delete" value="1">Confirmar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    <?php include_once '../../assets/footer.php'; ?>
</body>
</html>