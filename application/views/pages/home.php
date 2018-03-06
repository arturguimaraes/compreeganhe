<!-- HEADER -->
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<!-- NAVIGATION -->
<nav class="navbar fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="../../assets/img/logo.png" </a>
    <div >
      <a class="btn btn-green nav-link" href="/login">ENTRAR</a>
    </div>
  </div>
</nav>

<!-- PAGE CONTENT -->
<header class="masthead text-center text-white d-flex">
  <div class="container my-auto">
    <div class="row" style="padding-top: 50px;">
      <div class="home-text" >
          <h2 class="text-uppercase">
            <strong>Compre, Compartilhe e Ganhe</strong>
          </h2>
          <hr>
          <p class="text-faded">Já pensou em ganhar dinheiro consumindo arroz, feijão, açucar, café, e outros produtos de super-mercado?<br>Torne-se um consumidor inteligente!</p>
          <div class="row">
            <a class="btn-green btn  btn-xl js-scroll-trigger margin-bottom-20" href="#how-01">SAIBA +</a>
            <a class="btn-orange btn  btn-xl js-scroll-trigger margin-bottom-20" href="#contact">CONTATO</a>
          </div>
      </div>
      <div class="slogan-circle">
        <div class="slogan-text">
          <h3>Compre e Ganhe</h3>
          <h6>Consumo Inteligente</h6>
        </div>
      </div>
    </div>
  </div>
  <a class="arrow-btn" href="#page-top">
    <div class="arrow arrow-first"></div>
    <div class="arrow arrow-second"></div>
  </a>
</header>

<section class="bg-wave" id="how-01">
  <div class="container  my-auto">
    <!-- <h3 class="section-heading ">Como Funciona?</h3> -->
    <div class="row">
      <div class="col-sm-5">
       <h2 class="section-heading ">Seja Convidado</h2>
      </div>
      <div class="col-sm-5 col-sm-offset-2">
        <div class="circle-illus white-bg">
          <img src="../../assets/img/illustrations/01.png">
        <div>
      </div>
    </div>
  </div>    
  <!-- <div class="row">
      <div class="col-md-12 text-center">
        
        <hr class="my-4 light">
      </div>
      <?php for($i=1; $i <= $images['count']; $i++) { ?>
        <div class="col-md-4 col-6 margin-bottom-30">
          <img class="w-100" src="<?=$images['url'] . $i . $images['extension']?>" alt="Saiba Como <?=$i?>">
        </div>
      <? } ?>  
    </div> -->

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