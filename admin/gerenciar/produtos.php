<?php

    include '../../bibliotecas/bancodedados.bli';
    include '../../bibliotecas/db_auth';
    include '../ver_auth';

    if(isset($_REQUEST["insert"])) {

        if(isset($_FILES["foto"]) && !empty($_FILES["foto"]["name"])) {
            $endereco = "../../assets/produto_foto/";
            $target_path = $endereco . basename($_FILES['foto']['name']);
            $novoNome = rand(0,10000000000000) . substr(basename($_FILES['foto']['name']), -4);
            
            if(!move_uploaded_file($_FILES['foto']['tmp_name'], $endereco.$novoNome)) { $alert = ["content" => "<strong>Aviso:</strong> A imagem não pode ser enviada.", "type" => "warning"]; }

            $_POST["produto"]["foto"] = $path."/assets/produto_foto/".$novoNome;
        }

        $vatlanches->inserir("tblproduto", $_POST["produto"]);
        if(!isset($alert)) { $alert = ["content" => "<strong>". $_POST["produto"]["descricao"] . "</strong> foi adicionado com sucesso com sucesso.", "type" => "success"]; }

    } else if(isset($_REQUEST["edit"])) {
        switch($_REQUEST["edit"]) {
            case 0: $tblproduto = $vatlanches->buscar("tblproduto", "*", ["codigoproduto" => $_POST["produto"]])[0]; // 
                break;
            case 1:

                if(isset($_FILES["foto"]) && !empty($_FILES["foto"]["name"])) {
                    $endereco = "../../assets/produto_foto/";
                    $target_path = $endereco . basename($_FILES['foto']['name']);
                    $novoNome = rand(0,10000000000000) . substr(basename($_FILES['foto']['name']), -4);
                    
                    if(!move_uploaded_file($_FILES['foto']['tmp_name'], $endereco.$novoNome)) { $alert = ["content" => "<strong>Aviso:</strong> A imagem não pode ser enviada.", "type" => "warning"]; }
        
                    $_POST["produto"]["foto"] = $path."/assets/produto_foto/".$novoNome;
                }
                $vatlanches->alterar("tblproduto", $_POST["produto"], ["codigoproduto" => $_POST["produto"]["codigoproduto"]]);
                if(!isset($alert)) {
                    $alert = [
                        "content" => "<strong>". $_POST["produto"]["descricao"] . "</strong> foi alterado com sucesso com sucesso.",
                        "type" => "success"
                    ];
                }
                break;
            default:
        }
    } else if(isset($_REQUEST["delete"])) {
        $descricao = $vatlanches->buscar("tblproduto", "*", ["codigoproduto" => $_POST["produto"]])[0]["descricao"];
        $vatlanches->excluir("tblproduto", ["codigoproduto" => $_POST["produto"]]);
        $alert = ["content" => "<strong>". $descricao . "</strong> foi excluído com sucesso.", "type" => "success"];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <title>Produtos - VAT Lanches</title>
    <?php include_once '../../bibliotecas/bootstrap.html'; ?>
</head>
<body class="bg-lightgray">
    <?php include_once '../../assets/header.php'; ?>
    <div class="container bg-light my-lg-4 px-lg-5">
        <div class="row">
            <div class="col d-flex justify-content-center mt-4">
                <h1>Produtos</h1>
            </div>
        </div>
        <div class="row">
            <div class="container my-3">
                <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST" class="form" enctype="multipart/form-data">
                    <?php if(isset($_POST["edit"]) && $_POST["edit"] == 0) { ?><input type="hidden" name="produto[codigoproduto]" value="<?=$_POST["produto"]?>"><?php } ?>
                    <div class="form-group row">
                        <div class="col-lg">
                            <label for="nome">Nome do Produto:</label>
                            <input type="text" class="form-control" id="nome" placeholder="Insira o nome de um produto" name="produto[descricao]" <?php if(isset($tblproduto["descricao"])) { ?>value="<?=$tblproduto["descricao"]?>"<?php } ?> required>
                        </div>
                        <div class="col-lg-2">
                            <label for="preco">Preço:</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">R$</div>
                                </div>
                                <input type="number" class="form-control" id="preco" placeholder="9.99" step="0.01" name="produto[preco]" <?php if(isset($tblproduto["preco"])) { ?>value="<?=$tblproduto["preco"]?>"<?php } ?> required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="categoria">Categoria:</label>
                            <select class="form-control" id="categoria">
                                <?php

                                    $categorias = ["Lanche", "Bebida", "Sobremesa"];
                                    foreach($categorias as $categoria) {
                                        ?><option value="<?=$categoria?>" <?php if(isset($tblproduto["categoria"]) && $tblproduto["categoria"] == $categoria ) { echo "selected"; } ?>><?=$categoria?></option><?php
                                    }

                                ?>
                            </select>
                        </div>
                        <div class="col-lg">
                            <label for="custom-file">Foto:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="foto" id="customFile" accept="image/*">
                                <label class="custom-file-label" for="customFile" id="custom-file-label">Escolha uma foto</label>
                                <script>
                                    $('#customFile').change(function(){
                                    var filename = $(this)[0].files[0].name;
                                    var max_length = 20;
                                    if(filename.length > max_length) {
                                        filename = filename.slice(0,max_length);
                                        filename = filename + "...";
                                    }
                                    document.getElementById("custom-file-label").innerHTML = filename;

                                    });
                                    function displayfilename() {
                                        $('#customFile').trigger('change');
                                    }
                            </script>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg"></div>
                        <div class="col-lg-4 d-flex justify-content-around">
                            <?php if(!isset($tblproduto)) { ?><button type="submit" name="insert" value="1" class="btn btn-success">Adicionar Produto</button><?php } else { ?><button type="submit" name="edit" value="1" class="btn btn-success">Alterar Produto</button> <button type="button" class="btn btn-danger" onclick="window.location.assign(window.location.href)">Cancelar</button><?php } ?>
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
                            <th scope="col" class="d-none d-sm-table-cell">#</th>
                            <th scope="col" class="d-none d-sm-table-cell">Foto</th>
                            <th scope="col">Produto</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <style>
                            #edit-button:hover { background-color: #28a745; border-color: #28a745; }
                            #delete-button:hover { background-color: #dc3545; border-color: #dc3545; }
                        </style>
                        <?php
    
                            $produtos = $vatlanches->buscar("tblproduto");
    
                            foreach($produtos as $produto) { ?>
                                <tr>
                                    <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                                        <th scope="row" class="d-none d-sm-table-cell">
                                            <input type="hidden" name="produto" value="<?=$produto["codigoproduto"]?>">
                                            <?=$produto["codigoproduto"]?>
                                        </th>
                                        <td class="d-none d-sm-table-cell"><img src="<?=$produto['foto']?>" class="rounded" width="100px" height="100px" style="object-fit: cover; object-position: 50% 50%;"></td>
                                        <td><?=$produto["descricao"]?></td>
                                        <td><?=$produto["preco"]?></td>
                                        <td><?=$produto["categoria"]?></td>
                                        <td class="d-flex justify-content-around">
                                            <button class="btn btn-secondary" id="edit-button" name="edit" value="0" type="submit"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-secondary" id="delete-button" name="delete" value="1" type="submit"><i class="fas fa-trash"></i></button>
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