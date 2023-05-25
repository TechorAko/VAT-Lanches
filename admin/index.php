<?php

    include 'ver_auth';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once '../bibliotecas/bootstrap.html'; ?>
</head>
<body>
    <?php include_once '../assets/header.php'; ?>
</body>
</html>
<?php
    die();
?>

<?php

    require_once '../bibliotecas/bancodedados.bli';
    require_once '../bibliotecas/db_auth';
    require_once 'ver_auth';

    $table = isset($_REQUEST["table"]) ? $_REQUEST["table"] : "tblencomenda";

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
                $edit = $_POST[$table];
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

    function selected($reference, $compare, $button = FALSE) {
        $select = $button ? "checked" : "selected";
        if($reference == $compare) { return $select; }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Administração - VAT Lanches</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            label {
                text-align: right;
            }
            .cad-input {
                display: inline-block;
                width: 150px;
            }
        </style>
    </head>
    <body style="text-align: center;">
        <?php $header_tables = ["Cliente" => "./?table=tblcliente", "Encomendas" => "./?table=tblencomenda", "Produtos" => "./?table=tblproduto",]; include '../assets/header.php'; ?>
        <?php switch($table) {
            case "tblcliente":
                $submit_type = isset($edit) ? "Alterar" : "Cadastrar";
                ?>
                <h3>Gerenciar Clientes</h3>
                <form action="./?table=tblcliente" method="POST">
                    <fieldset class="panel-view" style="height: min-content;">
                        <legend>Cliente</legend>
                        <?php if(isset($edit)) { ?> <input type="hidden" name="<?=$table?>_primary[codigocliente]" value="<?php if(isset($edit)) { echo $edit["codigocliente"]; } ?>"> <?php } ?>
                        <br><label class="cad-input"> Nome:      </label> <input class="cad-input" type="text" name="tblcliente[nome]"       <?php if(isset($edit)) { ?>value="<?=$edit["nome"]?>"       <?php } ?>>
                        <br><label class="cad-input"> CPF:       </label> <input class="cad-input" type="text" name="tblcliente[cpf]"        <?php if(isset($edit)) { ?>value="<?=$edit["cpf"]?>"        <?php } ?>>
                        <br><label class="cad-input"> Email:     </label> <input class="cad-input" type="text" name="tblcliente[email]"      <?php if(isset($edit)) { ?>value="<?=$edit["email"]?>"      <?php } ?>>
                        <br><label class="cad-input"> Telefone:  </label> <input class="cad-input" type="text" name="tblcliente[telefone]"   <?php if(isset($edit)) { ?>value="<?=$edit["telefone"]?>"   <?php } ?>>
                        <br><label class="cad-input"> Endereço:  </label> <input class="cad-input" type="text" name="tblcliente[endereco]"   <?php if(isset($edit)) { ?>value="<?=$edit["endereco"]?>"   <?php } ?>>
                        <br>
                        <br><input type="submit" name="submit" value="<?=$submit_type?>"> <input type="reset" value="Limpar">
                    </fieldset>
                </form>
                <br>
                <div class="panel-view">
                    <table class="gray-border panelview-table" align="center">
                        <tr>
                            <?php
                                $tblcliente_describe = $vatlanches->descrever($table);
                                if(is_array($tblcliente_describe)) {
                                    foreach($tblcliente_describe as $describe_attribute) {
                                        if($describe_attribute["Key"] == "PRI") { $tblcliente_key = $describe_attribute["Field"]; }
                                        ?><th class="gray-border panelview-th"><?=$describe_attribute["Field"]?></th><?php
                                    }
                                    ?><th class="gray-border panelview-th">Opções</th><?php
                                } else { ?><th><?=$table?></th><?php }
                            ?>
                        </tr>
                        <?php
                            $tblcliente = $vatlanches->buscar($table);
                            if(is_array($tblcliente)) {
                                foreach($tblcliente as $tblcliente_attributes) {
                                    ?>
                                        <tr>
                                            <?php
                                                if(is_array($tblcliente_attributes)) {
                                                    ?><form action="<?=$_SERVER["PHP_SELF"]?>?table=tblcliente" method="POST"><?php
                                                    foreach($tblcliente_attributes as $tblcliente_attribute => $tblcliente_value) { ?>
                                                            <td class="gray-border panelview-td"><?=$tblcliente_value?></td>
                                                            <input type="hidden" name="tblcliente[<?=$tblcliente_attribute?>]" value="<?=$tblcliente_value?>">
                                                    <?php } ?>
                                                    <td class="gray-border panelview-td" style="width: 120px;"><input type="submit" name="edit" value="Alterar"> <input type="submit" name="edit" value="Excluir"></td>
                                                    </form>
                                                <?php } else { ?>
                                                    <td class="gray-border panelview-td"><?=$tblcliente_attributes?></td>
                                                <?php }
                                            ?>
                                        </tr>
                                    <?php
                                }
                            } else {
                                ?><tr><td class="gray-border panelview-td"colspan="100">Nenhum registro encontrado.</td><tr><?php
                            }
                        ?>
                    </table>
                </div>
                <?php
                break;
                case "tblproduto":
                    $submit_type = isset($edit) ? "Alterar" : "Cadastrar";
                    ?>
                    <h3>Gerenciar Produtos</h3>
                    <form action="./?table=tblproduto" method="POST">
                        <fieldset class="panel-view" style="height: min-content;">
                            <legend>Produto</legend>
                            <?php if(isset($edit)) { ?> <input type="hidden" name="<?=$table?>_primary[codigoproduto]" value="<?php if(isset($edit)) { echo $edit["codigoproduto"]; } ?>"> <?php } ?>
                            <br><label class="cad-input"> Descrição: </label> <input class="cad-input" type="text"   name="tblproduto[descricao]"            <?php if(isset($edit)) { ?>value="<?=$edit["descricao"]?>"  <?php } ?>>
                            <br><label class="cad-input"> Preço:     </label> <input class="cad-input" type="number" name="tblproduto[preco]" step="0.01"    <?php if(isset($edit)) { ?>value="<?=$edit["preco"]?>"      <?php } ?>>
                            <br><label class="cad-input"> Categoria: </label> <select class="cad-input" name="tblproduto[categoria]"> <?php
                                $categorias = ["Bebida", "Lanche", "Sobremesa"];
                                foreach($categorias as $categoria) { ?><option value="<?=$categoria?>" <?php if(isset($edit["categoria"])) { echo selected($edit["categoria"], $categoria); } ?>><?=$categoria?></option><?php }
                            ?>
                            </select>
                            <br>
                            <br><input type="submit" name="submit" value="<?=$submit_type?>"> <input type="reset" value="Limpar">
                        </fieldset>
                    </form>
                    <br>
                    <div class="panel-view">
                        <table class="gray-border panelview-table" align="center">
                            <tr>
                                <?php
                                    $tblproduto_describe = $vatlanches->descrever($table);
                                    if(is_array($tblproduto_describe)) {
                                        foreach($tblproduto_describe as $describe_attribute) {
                                            if($describe_attribute["Key"] == "PRI") { $tblproduto_key = $describe_attribute["Field"]; }
                                            ?><th class="gray-border panelview-th"><?=$describe_attribute["Field"]?></th><?php
                                        }
                                        ?><th class="gray-border panelview-th">Opções</th><?php
                                    } else { ?><th><?=$table?></th><?php }
                                ?>
                            </tr>
                            <?php
                                $tblproduto = $vatlanches->buscar($table);
                                if(is_array($tblproduto)) {
                                    foreach($tblproduto as $tblproduto_attributes) {
                                        ?>
                                            <tr>
                                                <?php
                                                    if(is_array($tblproduto_attributes)) {
                                                        ?><form action="<?=$_SERVER["PHP_SELF"]?>?table=tblproduto" method="POST"><?php
                                                        foreach($tblproduto_attributes as $tblproduto_attribute => $tblproduto_value) { ?>
                                                                <td class="gray-border panelview-td"><?=$tblproduto_value?></td>
                                                                <input type="hidden" name="tblproduto[<?=$tblproduto_attribute?>]" value="<?=$tblproduto_value?>">
                                                        <?php } ?>
                                                        <td class="gray-border panelview-td" style="width: 120px;"><input type="submit" name="edit" value="Alterar"> <input type="submit" name="edit" value="Excluir"></td>
                                                        </form>
                                                    <?php } else { ?>
                                                        <td class="gray-border panelview-td"><?=$tblproduto_attributes?></td>
                                                    <?php }
                                                ?>
                                            </tr>
                                        <?php
                                    }
                                } else {
                                    ?><tr><td class="gray-border panelview-td"colspan="100">Nenhum registro encontrado.</td><tr><?php
                                }
                            ?>
                        </table>
                    </div>
                    <?php
                    break;
            case "tblencomenda":
                ?>
                <h3>Gerenciar Encomendas</h3>
                <div class="panel-view">
                    <table class="gray-border panelview-table" align="center">
                        <tr>
                            <?php
                                $tblencomenda_describe = $vatlanches->descrever($table);
                                if(is_array($tblencomenda_describe)) {
                                    foreach($tblencomenda_describe as $describe_attribute) { if($describe_attribute["Key"] == "PRI") { $tblencomenda_key = $describe_attribute["Field"]; } }
                                    ?>
                                        <th class="gray-border panelview-th">Codigo Encomenda   </th>
                                        <th class="gray-border panelview-th">Cliente            </th>
                                        <th class="gray-border panelview-th">Data               </th>
                                        <th class="gray-border panelview-th">Status             </th>
                                        <th class="gray-border panelview-th">Itens              </th>
                                        <th class="gray-border panelview-th">Alterar            </th>
                                    <?php
                                } else { ?><th><?=$table?></th><?php }
                            ?>
                        </tr>
                        <?php
                            $sql = "SELECT tblencomenda.codigoencomenda, tblcliente.nome, tblencomenda.data, tblencomenda.status, tblencomenda.codigocliente FROM tblencomenda, tblcliente WHERE tblencomenda.codigocliente = tblcliente.codigocliente";
                            $tblencomenda = $vatlanches->fetch_multiarray($sql, MYSQLI_ASSOC);
                            if(is_array($tblencomenda)) {
                                foreach($tblencomenda as $tblencomenda_attributes) {
                                    ?>
                                        <tr>
                                            <?php
                                                if(is_array($tblencomenda_attributes)) {
                                                    ?><form action="<?=$_SERVER["PHP_SELF"]?>?table=tblencomenda" method="POST">
                                                    <?php
                                                    foreach($tblencomenda_attributes as $tblencomenda_attribute => $tblencomenda_value) {
                                                            switch($tblencomenda_attribute) {
                                                                case "codigoencomenda": ?>
                                                                    <td class="gray-border panelview-td"><?=$tblencomenda_value?></td>
                                                                    <input type="hidden" name="tblencomenda_primary[<?=$tblencomenda_attribute?>]" value="<?=$tblencomenda_value?>">
                                                                    <?php break;
                                                                    break;
                                                                case "status": ?>
                                                                    <td class="gray-border panelview-td">
                                                                        <select class="cad-input" name="tblencomenda[status]"> <?php
                                                                            $status = ["Em processamento", "Em andamento", "A caminho", "Enviado", "Cancelado"];
                                                                            foreach($status as $value) { ?><option value="<?=$value?>" <?=selected($tblencomenda_value, $value)?>><?=$value?></option><?php }
                                                                        ?> </select>
                                                                    </td>
                                                                    <?php break;
                                                                    break;
                                                                case "nome": ?>
                                                                    <td class="gray-border panelview-td"><?=$tblencomenda_value?></td>
                                                                    <?php break;
                                                                case "codigocliente": ?>
                                                                    <input type="hidden" name="tblencomenda[<?=$tblencomenda_attribute?>]" value="<?=$tblencomenda_value?>">
                                                                    <?php break;
                                                                default: ?>
                                                                    <td class="gray-border panelview-td"><?=$tblencomenda_value?></td>
                                                                    <input type="hidden" name="tblencomenda[<?=$tblencomenda_attribute?>]" value="<?=$tblencomenda_value?>">
                                                                <?php
                                                            }
                                                    } ?>
                                                    <td class="gray-border panelview-td">
                                                        <table>
                                                            <tr>
                                                                <?php

                                                                    $sql = "SELECT tblproduto.descricao, tblitens.quantidade, tblproduto.preco FROM tblitens, tblproduto, tblencomenda WHERE tblitens.codigoencomenda = ". $tblencomenda_attributes["codigoencomenda"] ." AND tblitens.codigoproduto = tblproduto.codigoproduto AND tblencomenda.codigoencomenda = tblitens.codigoencomenda";
                                                                    $tblitens = $vatlanches->fetch_multiarray($sql, MYSQLI_ASSOC);

                                                                    $preco = 0;

                                                                    foreach($tblitens as $tblitens_attributes) {
                                                                        ?> <tr> <?php
                                                                            foreach($tblitens_attributes as $tblitens_attribute => $item) { if($tblitens_attribute == "preco") { $preco += $item * $tblitens_attributes["quantidade"]; continue; }?>
                                                                                <td class="gray-border"><?=$item?></td>
                                                                            <?php }
                                                                        ?> </tr> <?php
                                                                    }

                                                                ?>
                                                            </tr>
                                                            <tr>
                                                                <th class="gray-border" colspan="3">R$<?=$preco?></th>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td class="gray-border panelview-td"><input type="submit" name="submit" value="Alterar">
                                                    </form>
                                                <?php } else { ?>
                                                    <td class="gray-border panelview-td"><?=$tblencomenda_attributes?></td>
                                                <?php }
                                            ?>
                                        </tr>
                                    <?php
                                }
                            } else {
                                ?><tr><td class="gray-border panelview-td"colspan="100">Nenhum registro encontrado.</td><tr><?php
                            }
                        ?>
                    </table>
                </div>
                <?php
                break;
            default: 
        } ?>
        <br>
        <?php $footer_fixed = "fixed"; include '../assets/footer.php'; ?>
    </body>
</html>