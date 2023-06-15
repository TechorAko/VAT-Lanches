<header class="sticky-top">
<?php

    if(!isset($path)) {
        if(str_contains($_SERVER['SERVER_NAME'], "localhost")) { $path = "http://".$_SERVER["SERVER_NAME"]."/TechorAko/VAT-Lanches"; } else { $path = "http://".$_SERVER["SERVER_NAME"]; }
    }

    if(!str_contains($_SERVER["PHP_SELF"], "/admin")) {

        if(!isset($header_block)) { 

            ?>
                <nav class="navbar navbar-expand-md bg-danger navbar-dark">
    
                    <a class="navbar-brand" href="<?=$path?>/index.php">VAT Lanches</a>

                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item px-2">
                                <a class="nav-link" href="<?=$path?>/">Início</a>
                            </li>
                            <li class="nav-item px-2">
                                <a class="nav-link" href="<?=$path?>/pedidos.php">Pedidos</a>
                            </li>
                            <li class="nav-item px-2">
                                <a class="nav-link" href="<?=$path?>/perfil.php">Perfil</a>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">Perfil</a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a class="dropdown-item" href="<?=$path?>/perfil.php?edit=0">Editar Perfil</a></li>
                                    <li><a class="dropdown-item" href="<?=$path?>/login.php?sair=1">Sair</a></li>
                                </ul>
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

    } else {

        $path .= "/admin";

        if(!str_contains($_SERVER["PHP_SELF"], "login.php")) {
            ?>
    
            <nav class="navbar navbar-expand-md bg-danger navbar-dark">
    
                <a class="navbar-brand" href="<?=$path?>/index.php">VAT Lanches</a>
        
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item px-2">
                            <a class="nav-link" href="<?=$path?>/">Início</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="<?=$path?>/gerenciar/encomendas.php">Encomendas</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="<?=$path?>/gerenciar/produtos.php">Produtos</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="<?=$path?>/gerenciar/clientes.php">Clientes</a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="<?=$path?>/login.php?sair=0">Sair</a>
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

    if(isset($alert)) { ?>
        <div class="alert alert-<?=$alert["type"]?> alert-dismissible fade show" role="alert">
            <?=$alert["content"]?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
</header>