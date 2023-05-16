<style>
    .header {
        border-bottom: 1px solid gray;
        background-color: white;
        width: 100%;
    }
</style>
<div class="header" style="position: fixed; top: 0; left: 0; width: 100%;">
    <a href="./" style="color: black; text-decoration: none;"><h1 style="line-height: 15px;">VAT Lanches</h1>
        <?php
            $header_height = 55;

            if(str_contains($_SERVER["PHP_SELF"], "admin")) {
                ?><h2 style="line-height: 10px; color: #656565">Administração</h2><?php
                $header_height += 25;
            }
        ?>
    </a>
    <?php
        if(isset($_SESSION["codigocliente"]) || isset($_SESSION["user"])) { ?>
            <form action="login.php" method="GET">
                <input type="submit" name="sair" value="Sair" style="position: absolute; right: 35px; top: 21px;">
            </form>
        <?php }

        if(isset($header_tables)) {
            $header_height += 40;
            ?> <table style="border: 0px; border-top: 1px solid gray; width: 100%;">
                <tr>
                    <?php
                        foreach($header_tables as $header_table => $header_link) {
                            ?><td style="padding: 10px; width: <?=100/count($header_tables)?>%;"><a href="<?=$header_link?>"><?=$header_table?></a></td><?php
                        }
                    ?>
                </tr>
            </table>
    <?php } ?>
</div>
<div style="height: <?=$header_height?>px;"></div>
<?php if(isset($feedback)) { ?><br><div class="<?=$feedback["type"]?>" style="width: fit-content; padding: 5px; margin: auto;"><b><?=$feedback["message"]?></b></div><br><?php }?>