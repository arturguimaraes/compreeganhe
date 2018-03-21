<!DOCTYPE html>
<html lang="pt-br">
<head>
    
    <meta charset="utf-8">
    <title><?=$page['title']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/icon-64.png">
    
    <!-- Bootstrap CSS -->
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link href="assets/css/admin.css" rel="stylesheet">
    <link href="assets/css/adminCustom.css" rel="stylesheet">
    <link href="assets/css/adminMedia.css" rel="stylesheet">

    <!-- jQuery JS -->
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <a href="<?=base_url()?>">
                    	<img src="assets/img/logo_cg_old.png" alt="Logo Compre & Ganhe" class="hidden-xs hidden-sm" style="height: 50px; padding: 0; width: auto;">
                        <img src="assets/img/icon-64.png" alt="Logo Compre & Ganhe" class="visible-xs visible-sm circle-logo">
                    </a>
                </div>
                <div class="navi">
                    <ul>
                        <?php if($this->adminModel->checkLogin()) { ?>
                            <li><a href="admin"><i class="fa fa-file-photo-o" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Carrossel</span></a></li>
                            <li><a href="adminSobre"><i class="fa fa-file-photo-o" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Como Funciona?</span></a></li>
                            <li><a href="adminTaxas"><i class="fa fa-percent" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Taxas</span></a></li>
                            <li><a href="adminPrecos"><i class="fa fa-dollar" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Preços</span></a></li>
                            <li><a href="adminAddProduct"><i class="fa fa-gift" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Adicionar Produto</span></a></li>
                            <li><a href="adminOrders?limit=100"><i class="fa fa-shopping-bag" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Gerenciar Pedidos</span></a></li>
                            <li><a href="adminUsers?limit=100"><i class="fa fa-user" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Gerenciar Usuários</span></a></li>
                            <li><a href="adminMessages"><i class="fa fa-envelope" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Enviar Mensagens</span></a></li>
                            <li><a href="logout"><i class="fa fa-sign-out" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Sair</span></a></li>
                        <? } ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                <!--<button type="button" class="slide-toggle">Slide Toggle</button> -->
                <div class="row">
                    <header class="navbar-header-main">
                        <div class="col-md-12">
                            <nav class="navbar-default pull-left">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </nav>
                        </div>
                    </header>
                </div>
                <div class="user-dashboard">

                    <!-- PAGE CONTENT -->

<!-- FOOTER -->