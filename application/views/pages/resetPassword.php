<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
  <?php if(!$changeAuth) { ?>
    <div class="container">
      <div class="col-md-12 margin-bottom-20 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Recuperar Senha</h2>
        <form class="form-signin col-md-7 margin-auto-horizontal" id="resetPasswordForm" role="form" method="post">    
            <div class="col-md-12 margin-bottom-20">
                <input type="email" id="email" name="email" class="form-control margin-bottom-10" placeholder="E-mail cadastrado" required="true" autofocus>
                <input type="text" id="cpf" name="cpf" class="form-control" placeholder="CPF" maxlength=14 required="true">
            </div>
            <? if (isset($messages) && isset($messages['submit'])) { ?>
              <div class="col-md-12 <?=$messages['submit']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['submit']['message']?></div>
            <? } ?>
            <div class="col-md-12">
              <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit" name="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> Enviar</button>
            </div>
        </form>
      </div>
      <div class="col-md-12 text-align-center">
        <a class="text-faded" href="login"><i class="fa fa-sign-in" aria-hidden="true"></i> Entrar</a>
      </div>
      <div class="col-md-12 text-align-center">
      	<a class="text-faded" href="<?=base_url()?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retornar ao site</a>
      </div>
    </div>
  <?php } else { ?>
    <div class="container padding-top-100">
        <h2 class="col-md-12 margin-bottom-50 text-align-center">Recuperar Senha</h2>
        <form class="form-signin col-md-4 margin-auto-horizontal" role="form" action="" method="post">
            <div class="col-md-12 margin-bottom-20">
                <input type="password" id="newPassword" name="newPassword" class="form-control margin-bottom-10" placeholder="Nova Senha" required="true">
                <input type="password" id="newPasswordRepeat" name="newPasswordRepeat" class="form-control margin-bottom-10" placeholder="Repita a Nova Senha" required="true">
            </div>
            <? if (isset($messages) && isset($messages['password'])) { ?>
              <div class="col-md-12 <?=$messages['password']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['password']['message']?></div>
            <? } ?>
            <div class="col-md-12">
              <button class="btn btn-lg btn-danger btn-block" type="submit" id="submit" name="submitChange"><i class="fa fa-lock" aria-hidden="true"></i> Trocar Senha</button>
            </div>
        </form>
        <div class="col-md-12 text-align-center">
          <a class="text-faded" href="login"><i class="fa fa-sign-in" aria-hidden="true"></i> Entrar</a>
        </div>
        <div class="col-md-12 text-align-center">
          <a class="text-faded" href="<?=base_url()?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retornar ao site</a>
        </div>
    </div>
  <? } ?>
</div>

<!-- FOOTER -->