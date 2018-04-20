<h1>Entrar</h1>
<div class="row display-grid" style="margin-top: 100px">
    <form class="form-signin col-md-4 margin-auto-horizontal" role="form" action="" method="post">
        <div class="col-md-12 margin-bottom-30">
            <input type="text" id="username" name="username" class="form-control margin-bottom-10" placeholder="Usuário" required="true" autofocus>
            <input type="password" id="password" name="password" class="form-control" placeholder="Senha" required="true">
        </div>
        <? if (isset($messages) && isset($messages['login'])) { ?>
          <div class="col-md-12 <?=$messages['login']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['login']['message']?></div>
        <? } ?>
        <div class="col-md-12">
          <button class="btn btn-lg btn-success btn-block" type="submit" id="submit" name="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> Entrar</button>
        </div>
    </form>
</div>