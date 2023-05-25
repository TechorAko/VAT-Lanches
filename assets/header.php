<header>
<?php

    if(!isset($path)) {
        if(str_contains($_SERVER['SERVER_NAME'], "localhost")) { $path = "http://".$_SERVER["SERVER_NAME"]."/TechorAko/VAT-Lanches"; } else { $path = "http://".$_SERVER["SERVER_NAME"]; }
    }

    if(!str_contains($_SERVER["PHP_SELF"], "/admin")) {

        if(!str_contains($_SERVER["PHP_SELF"], "login.php")) { 

            ?>

            <?php

        } else {

            ?>
            
            <?php

        }

    } else {

        $path .= "/admin";

        if(!str_contains($_SERVER["PHP_SELF"], "login.php")) {
            ?>
    
            <nav class="navbar navbar-expand-md bg-danger navbar-dark sticky-top">
    
                <a class="navbar-brand" href="<?=$path?>/index.php">VAT Lanches</a>
        
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$path?>/encomendas.php">Encomendas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$path?>/produtos.php">Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$path?>/clientes.php">Clientes</a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="<?=$path?>/login.php?sair=0">
                                Sair
                            </a>
                        </li>
                    </ul>
                </div>
        
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
            </nav>
    
            <?php
            
        } else {
            ?>
            
            <nav class="navbar navbar-expand-md bg-danger navbar-dark sticky-top justify-content-center">
    
                <a class="navbar-brand" href="./">VAT Lanches</a>
        
            </nav>
    
            <?php
        }

    }

?>
</header>