<!-- NAVIGATION -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="<?=base_url()?>"><img class="img-header" src="assets/img/logo.png"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <?php if($this->user->checkLogin()) { ?>
      	<ul class="navbar-nav">
        	<li class="nav-item">
          		<a class="nav-link" href="myaccount">Bem vindo, <?=$user->names[0]?> (<?=$user->username?>)</a>
          	</li>
      	</ul>
      <? } ?>
      <ul class="navbar-nav ml-auto">
        <?php if(!$this->user->checkLogin()) { ?>
        	<li class="nav-item">
          		<a class="nav-link" href="login">Entrar</a>
          	</li>
		<?php } else { 
          if(!isset($page['lockedNav'])) { ?>
          	<li class="nav-item">
            	<div class="dropdown">
                <button class="dropdown-toggle nav-link" type="button" data-toggle="dropdown"><i class="fa fa-user"></i> Conta
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="mybudget" class="dropdown-menu-item"><i class="fa fa-calculator"></i> Extrato</a></li>
                  <li><a href="mynetwork" class="dropdown-menu-item"><i class="fa fa-group"></i> Rede</a></li>
                  <li><a href="withdraw" class="dropdown-menu-item"><i class="fa fa-dollar"></i> Saque</a></li>
                  <li><a href="paybill" class="dropdown-menu-item"><i class="fa fa-barcode"></i> Pagar Fatura</a></li>
                  <li><a href="myinfo" class="dropdown-menu-item"><i class="fa fa-drivers-license"></i> Dados Cadastrais</a></li>
                  <li><a href="password" class="dropdown-menu-item"><i class="fa fa-lock"></i> Trocar Senha</a></li>
                  <!--<li><a href="messages" class="dropdown-menu-item"><i class="fa fa-envelope"></i> Mensagens</a></li>-->
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <div class="dropdown">
                  <button class="dropdown-toggle nav-link" type="button" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i> Comprar
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="shop" class="dropdown-menu-item" ><i class="fa fa-search"></i> Produtos</a></li>
                    <li><a href="cart" class="dropdown-menu-item" ><i class="fa fa-shopping-cart"></i> Carrinho</a></li>
                    <li><a href="myorders" class="dropdown-menu-item" ><i class="fa fa-credit-card"></i> Pedidos</a></li>
                  </ul>
              </div>
            </li>
            <li class="nav-item"><a href="messages" class="nav-link"><i class="fa fa-envelope"></i> Mensagens<?=$user->unreadMessages?></a></li>
          <? } ?>
          <li class="nav-item">
            <a class="nav-link not-clickable" href="javascript:;">
              Saldo: R$ <?=$user->balance == NULL || $user->balance == 0 ? "0,00" : number_format($user->balance, 2, ',', '')?>
            </a>
          </li>
          <li class="nav-item">
            <a id="navbar-rank" class="nav-link" href="rank" style="background:<?=$user->color?>;"><?=$user->graduation == NULL ? "BRONZE" : $user->graduation?></a>
          </li>
          <li class="nav-item">
          	<a class="nav-link" href="logout"><i class="fa fa-sign-out"></i> Sair</a>
          </li>
        <? } ?>
      </ul>
    </div>
  </div>
</nav>