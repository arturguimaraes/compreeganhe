<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12 margin-bottom-50 padding-top-100">
          <form class="form-signin col-md-4 margin-auto-horizontal" role="form" action="" method="post">
              <h2 class="col-md-12 margin-bottom-30 text-align-center">Entrar</h2>
              <div class="col-md-12 margin-bottom-20">
                  <input type="text" id="username" name="username" class="form-control margin-bottom-10" placeholder="Usuário" required="true" autofocus>
                  <input type="password" id="password" name="password" class="form-control" placeholder="Senha" required="true">
              </div>
              <? if (isset($messages) && isset($messages['login'])) { ?>
                <div class="col-md-12 <?=$messages['login']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['login']['message']?></div>
              <? } ?>
              <div class="col-md-12">
                <div class="col-md-12"><p>Digite a palavra abaixo:</p></div>
                <div class="col-md-12 margin-bottom-10 captcha">
                    <?php echo $captcha['image']; ?>
                </div>
                <? if (isset($messages) && isset($messages['captcha'])) { ?>
                  <div class="col-md-12 <?=$messages['captcha']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['captcha']['message']?></div>
                <? } ?>
                <div class="col-md-12 margin-bottom-20">
                  <input type="text" class="form-control" name="captcha" value=""/>
                </div>
              </div>
              <div class="col-md-12">
                <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit" name="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> Entrar</button>
              </div>
          </form>
      </div>
      <div class="col-md-12 text-align-center"><a class="text-faded" href="<?=base_url()?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retornar ao site</a></div>
    </div>
</div>

<!-- FOOTER -->