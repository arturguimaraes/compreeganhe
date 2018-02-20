<!-- HEADER -->

<!-- NAVIGATION -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="#page-top"><img class="img-header" src="assets/img/logo_cg.png"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#services">Como Funciona?</a>
        </li>
        <?php if(!$this->user->checkLogin()) { ?>
            <li class="nav-item">
              <a class="nav-link" href="/login">Entrar</a>
            </li>
        <?php } else { ?>
        	<li class="nav-item">
            <a class="nav-link" href="myaccount">Minha Conta</a>
          </li>
		<? } ?>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#contact">Contato</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- PAGE CONTENT -->
<header class="masthead text-center text-white d-flex">
  <div class="container my-auto">
    <div class="row" style="padding-top: 50px;">
      <div id="Caroulsel" class="col-md-12 carousel slide margin-top-50 margin-bottom-30" data-ride="carousel">
        <div class="carousel-inner">
          <?php for($i=1; $i <= $carrousel['count']; $i++) { ?>
            <div class="carousel-item <?=($i==1 ? 'active' : '')?>">
              <img class="d-block w-100 margin-auto" src="<?=$carrousel['url'] . $i . $carrousel['extension']?>" alt="Compre & Ganhe <?=$i?>">
            </div>
          <? } ?>
        </div>
        <a class="carousel-control-prev" href="#Caroulsel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#Caroulsel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Próximo</span>
        </a>
      </div>

      <div class="col-md-12"><a class="btn btn-primary btn-xl js-scroll-trigger margin-bottom-20" href="#services">Saiba Como</a></div>

      <!--<div class="col-md-4">
        <h2 class="text-uppercase">
          <strong>Quanto você ganha para indicar o supermercado onde faz compras?</strong>
        </h2>
        <hr>
        <p class="text-faded">Já pensou em ganhar dinheiro consumindo arroz, feijão, açucar, café, etc.?<br>Torne-se um consumidor inteligente!</p>
        <a class="btn btn-primary btn-xl js-scroll-trigger margin-bottom-20" href="#services">Saiba Como</a>
      </div>
      <div class="col-md-1"></div>-->

    </div>
  </div>
</header>

<section class="bg-primary" id="services">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <h2 class="section-heading text-white">Como Funciona?</h2>
        <hr class="my-4 light">
      </div>
      <?php for($i=1; $i <= $images['count']; $i++) { ?>
        <div class="col-md-4 col-6 margin-bottom-30">
          <img class="w-100" src="<?=$images['url'] . $i . $images['extension']?>" alt="Saiba Como <?=$i?>">
        </div>
      <? } ?>  
    </div>
  </div>    

  <!--<div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <h2 class="section-heading text-white">Um novo meio de ganhar dinheiro</h2>
        <hr class="my-4 light">
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-md-6 text-center">
        <div class="service-box mt-5 mx-auto text-white">
          <i class="fa fa-4x fa-address-book mb-3 sr-icons text-white"></i>
          <h3 class="mb-3">Indique Amigos</h3>
        </div>
      </div>
      <div class="col-md-3 col-md-6 text-center">
        <div class="service-box mt-5 mx-auto text-white">
          <i class="fa fa-4x fa-address-card mb-3 sr-icons text-white"></i>
          <h3 class="mb-3">Cadastro Via Link Único</h3>
        </div>
      </div>
      <div class="col-md-3 col-md-6 text-center">
        <div class="service-box mt-5 mx-auto text-white">
          <i class="fa fa-4x fa-shopping-cart mb-3 sr-icons text-white"></i>
          <h3 class="mb-3">Acompanhe o Faturamento de Sua Rede</h3>
        </div>
      </div>
      <div class="col-md-3 col-md-6 text-center">
        <div class="service-box mt-5 mx-auto text-white">
          <i class="fa fa-4x fa-bank mb-3 sr-icons text-white"></i>
          <h3 class="mb-3">Administre Seus Lucros</h3>
        </div>
      </div>
    </div>
  </div>-->
</section>

<section id="login" style="display:none;">
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto text-center">
        <h2 class="col-md-12 mb-5 section-heading">Já é cadastrado?</h2>
        <a class="btn btn-light btn-xl js-scroll-trigger" href="login">Entrar</a>
      </div>
    </div>
  </div>
</section>

<section id="contact">
  <div class="container">
    <div class="row mb-4">
      <div class="col-md-8 mx-auto text-center">
        <h2 class="section-heading">Contato</h2>
        <hr class="my-4">
        <p class="">Informe seus dados abaixo e entraremos em contato com você!</p>
      </div>
    </div>

    <div class="row mb-5">
      <form id="contactForm" class="form-horizontal col-md-4 margin-auto" method="post">
        <div class="form-group">
          <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
        </div>
        <div class="form-group">
          <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Whatsapp" maxlength="15" required>
        </div>
        <div class="form-group" style="display:flex;">
          <input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-success margin-auto">
        </div>
      </form>
    </div>

    <div class="row">
      <div class="col-md-4 ml-auto text-center">
        <i class="fa fa-phone fa-3x mb-3 sr-contact"></i>
        <p>(11) 2222-2222</p>
      </div>
      <div class="col-md-4 ml-auto text-center">
        <i class="fa fa-facebook fa-3x mb-3 sr-contact"></i>
        <p><a href="www.facebook.com/compreeganhe">Compre e Ganhe</a></p>
      </div>
      <div class="col-md-4 mr-auto text-center">
        <i class="fa fa-envelope-o fa-3x mb-3 sr-contact"></i>
        <p><a href="mailto:contato@compreeganhe.net">contato@compreeganhe.net</a></p>
      </div>
    </div>
  </div>
</section>

<?php if($contactEmail) { ?>
  <script>
    $(document).ready(function() {
        setTimeout(function () {
          alert("Obrigado por entrar em contato!\nRetornaremos em breve.");
        }, 1000);
    });
  </script>
<? } ?>

<!-- FOOTER -->   