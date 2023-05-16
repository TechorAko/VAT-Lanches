<style>
    label {
        text-align: right;
    }
    .cad-input {
        display: inline-block;
        width: 150px;
    }
</style>
<?php

    require_once "../bibliotecas/bancodedados.bli";
    require_once '../bibliotecas/db_auth';

    if(isset($_POST["submit"]) && $_POST["submit"] == "Inserir") {
        if(isset($_POST["data"])) {
            $DATA_TEMP = explode("T",$_POST["data"]);
            $_POST["data"] = implode(" ",$DATA_TEMP);
        }
        
        if($table != "tblitens") {
            if($vatlanches->inserir($table,$_POST[$table])) { $insert_feedback = ["message" => "Registro inserido com sucesso!", "type" => "success-box"];
            } else {
                $insert_feedback = ["message" => "Erro: Não foi possível inserir o registro. Por favor, tente novamente. ", "type" => "error-box"];
            }
        } else {
            foreach($_POST["quantidadeitem"] as $_POST["tblitens"]["codigoproduto"] => $_POST["tblitens"]["quantidade"]) {
                if($_POST["tblitens"]["quantidade"] > 0) {
                    $vatlanches->inserir($table,$_POST[$table]);
                }
            }
            if(isset($_POST["tblitens"]["codigoproduto"])) {
                $insert_feedback = ["message" => "Registro inserido com sucesso!", "type" => "success-box"];
            } else {
                $insert_feedback = ["message" => "Erro: Não foi possível inserir o registro. Por favor, tente novamente. ", "type" => "error-box"];
            }
        }
        ?><br><div class="<?=$insert_feedback["type"]?>" style="width: fit-content; padding: 5px; margin: auto;"><b><?=$insert_feedback["message"]?></b></div><br><?php
    }

    function select_foreign($ecommerce, $table, $foreign, $selected = NULL) { $data = $ecommerce->buscar($table);?>
        <div class="select_foreign" style="overflow: auto; height: 100px; border: 1px solid gray; margin: 5px;">
            <table border=1 style="border-collapse: collapse;" width="100%" height="100%" cellpadding="5px">
                <tr align="center">
                    <th>Selecionar</th>
                    <?php
                        foreach($ecommerce->descrever($table) as $attribute) {
                            if($attribute["Key"] == "PRI") { $ID = $attribute["Field"]; continue; }
                            ?><th><?=$attribute["Field"]?></th><?php
                        }
                        if(!isset($ID)) { $data = "Erro: Não existe chave primária dentro de $table."; }
                    ?>
                </tr>
                <?php
                    if(is_array($data)) { foreach($data as $row) {
                        ?> <tr align="center"> <td> <input type="radio" name="<?=$foreign?>" value="<?=$row[$ID]?>" <?php if($selected == $row[$ID]) { echo "checked"; } ?> > </td><?php
                            if(is_array($row)) {
                                foreach($row as $attribute => $value) {
                                    if($attribute == $ID) { continue; }
                                    ?><td><?=$value?></td><?php
                                }
                            } else { ?><td><?=$row?></td><?php }
                        ?> </tr> <?php
                    } } else { ?> <tr align="center"><td colspan="100"><?=$data?></td></tr> <?php }
                ?>
            </table>
        </div> <?php
    }

    function selected($reference, $compare, $button = FALSE) {
        $select = $button ? "checked" : "selected";
        if($reference == $compare) { return $select; }
    }

    if(!isset($table)) { $table = $vatlanches->tabelas[0]; }

    switch($table) {
        case "tblcliente":
            ?>
            <fieldset>
                <legend>Cliente</legend>
                <?php if(isset($edit)) { ?> <input type="hidden" name="<?=$table?>_primary[codigocliente]" value="<?php if(isset($edit)) { echo $edit["codigocliente"]; } ?>"> <?php } ?>
                <br><label class="cad-input"> Nome:      </label> <input class="cad-input" type="text" name="tblcliente[nome]"       <?php if(isset($edit)) { ?>value="<?=$edit["nome"]?>"       <?php } ?>>
                <br><label class="cad-input"> CPF:       </label> <input class="cad-input" type="text" name="tblcliente[cpf]"        <?php if(isset($edit)) { ?>value="<?=$edit["cpf"]?>"        <?php } ?>>
                <br><label class="cad-input"> Email:     </label> <input class="cad-input" type="text" name="tblcliente[email]"      <?php if(isset($edit)) { ?>value="<?=$edit["email"]?>"      <?php } ?>>
                <br><label class="cad-input"> Telefone:  </label> <input class="cad-input" type="text" name="tblcliente[telefone]"   <?php if(isset($edit)) { ?>value="<?=$edit["telefone"]?>"   <?php } ?>>
                <br><label class="cad-input"> Endereço:  </label> <input class="cad-input" type="text" name="tblcliente[endereco]"   <?php if(isset($edit)) { ?>value="<?=$edit["endereco"]?>"   <?php } ?>>
            </fieldset>
            <?php break;
        case "tblencomenda":
            $codigocliente = isset($edit) ? $edit["codigocliente"] : NULL;
            ?>
            <fieldset>
                <legend>Encomendas</legend>
                <?php if(isset($edit)) { ?> <input type="hidden" name="<?=$table?>_primary[codigoencomenda]" value="<?php if(isset($edit)) { echo $edit["codigoencomenda"]; } ?>"> <?php } ?>
                <br><label                  > Cliente:   </label> <?=select_foreign($vatlanches, "tblcliente", "tblencomenda[codigocliente]", $codigocliente)?>
                <br><label class="cad-input"> Data:      </label> <input class="cad-input" type="datetime-local" name="tblencomenda[data]" <?php if(isset($edit)) { ?>value="<?=$edit["data"]?>"<?php } ?>>
                <br><label class="cad-input"> Status:    </label> <select class="cad-input" name="tblencomenda[status]"> <?php
                    $cargos = ["Em processamento", "Em andamento", "A caminho", "Enviado", "Cancelado"];
                    foreach($cargos as $cargo) { ?><option value="<?=$cargo?>" <?php if(isset($edit["status"])) { echo selected($edit["status"], $cargo); } ?>><?=$cargo?></option><?php }
                ?>
                </select>
            </fieldset>
            <?php break;
        case "tblitens":
            $codigoproduto = isset($edit) ? $edit["codigoproduto"] : 0;
            $codigoencomenda = isset($edit) ? $edit["codigoencomenda"] : NULL;
            $data = $vatlanches->buscar("tblproduto");
            ?>
            <fieldset>
                <legend>Lista de Itens</legend>
                <br><label> Produtos: </label>
                <div style="overflow: auto; height: 100px; border: 1px solid gray; margin: 5px;">
                    <table border=1 style="border-collapse: collapse;" width="100%" height="100%" cellpadding="5px">
                        <tr align="center">
                            <?php
                                foreach($vatlanches->descrever("tblproduto") as $attribute) {
                                    if($attribute["Key"] == "PRI") { $ID = $attribute["Field"]; continue; }
                                    ?><th><?=$attribute["Field"]?></th><?php
                                }
                            ?>
                            <th style="width: 0;">Quantidade</th>
                        </tr>
                        <?php
                            foreach($data as $row) {
                                ?> <tr align="center"> <?php
                                    foreach($row as $attribute => $value) {
                                        if($attribute == $ID) { continue; }
                                        ?><td><?=$value?></td><?php
                                    } ?>
                                    <td><input type="number" name="quantidadeitem[<?=$row[$ID]?>]" size="2" min="0" value="0"></td>
                                </tr> <?php
                            }
                        ?>
                    </table>
                </div>
                <br><label> Encomenda: </label> <?=select_foreign($vatlanches, "tblencomenda", "tblitens[codigoencomenda]", $codigoencomenda)?>
            </fieldset>
            <?php break;
        case "tblproduto":
            ?>
            <fieldset>
                <legend>Produto</legend>
                <?php if(isset($edit)) { ?> <input type="hidden" name="<?=$table?>_primary[codigocliente]" value="<?php if(isset($edit)) { echo $edit["codigocliente"]; } ?>"> <?php } ?>
                <br><label class="cad-input"> Descrição: </label> <input class="cad-input" type="text"   name="tblproduto[descricao]"            <?php if(isset($edit)) { ?>value="<?=$edit["descricao"]?>"  <?php } ?>>
                <br><label class="cad-input"> Preço:     </label> <input class="cad-input" type="number" name="tblproduto[preco]" step="0.01"    <?php if(isset($edit)) { ?>value="<?=$edit["preco"]?>"      <?php } ?>>
                <br><label class="cad-input"> Categoria: </label> <select class="cad-input" name="tblproduto[categoria]"> <?php
                    $categorias = ["Bebida", "Lanche", "Sobremesa"];
                    foreach($categorias as $categoria) { ?><option value="<?=$categoria?>" <?php if(isset($edit["categoria"])) { echo selected($edit["categoria"], $categoria); } ?>><?=$categoria?></option><?php }
                ?>
                </select>
            </fieldset>
            <?php break;
        default: ?>
            <fieldset>
                <legend></legend>
                <br><label class="cad-input"></label> <input class="cad-input" type="" name="">
            </fieldset>
        <?php
    }

?>