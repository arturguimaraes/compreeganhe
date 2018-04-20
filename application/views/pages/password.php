<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container padding-top-100">
        <h2 class="col-md-12 margin-bottom-50 text-align-center"><?=$page['title']?></h2>
        <form class="form-signin col-md-4 margin-auto-horizontal" role="form" action="" method="post">
            <div class="col-md-12 margin-bottom-20">
                <input type="password" id="oldPassword" name="oldPassword" class="form-control margin-bottom-10" placeholder="Senha Atual" required="true" autofocus>
                <input type="password" id="newPassword" name="newPassword" class="form-control margin-bottom-10" placeholder="Nova Senha" required="true">
                <input type="password" id="newPasswordRepeat" name="newPasswordRepeat" class="form-control margin-bottom-10" placeholder="Repita a Nova Senha" required="true">
            </div>
            <? if (isset($messages) && isset($messages['password'])) { ?>
              <div class="col-md-12 <?=$messages['password']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['password']['message']?></div>
            <? } ?>
            <div class="col-md-12">
              <button class="btn btn-lg btn-danger btn-block" type="submit" id="submit" name="submit"><i class="fa fa-lock" aria-hidden="true"></i> Trocar Senha</button>
            </div>
        </form>
    </div>
</div>

<!-- FOOTER -->