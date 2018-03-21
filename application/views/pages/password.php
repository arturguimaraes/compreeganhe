<div class="row">
	<div class="col-md-12">
        <h1 class="page-header text-align-center"><i class="fa fa-lock"></i> <?=$page['title']?></h1>
    </div>
	<div class="col-md-4 col-md-offset-4">
    	<form class="form-signin" method="post">
            <div class="col-md-12 margin-bottom-20">
                <input type="password" id="oldPassword" name="oldPassword" class="form-control margin-bottom-10" placeholder="Senha Atual" required="true" autofocus>
                <input type="password" id="newPassword" name="newPassword" class="form-control margin-bottom-10" placeholder="Nova Senha" required="true">
                <input type="password" id="newPasswordRepeat" name="newPasswordRepeat" class="form-control margin-bottom-10" placeholder="Repita a Nova Senha" required="true">
            </div>
            <? if (isset($messages) && isset($messages['password'])) { ?>
              <div class="col-md-12 <?=$messages['password']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['password']['message']?></div>
            <? } ?>
            <div class="col-md-12">
              <button class="btn btn-lg btn-danger btn-block" type="submit" id="submit" name="submit">
              	<i class="fa fa-lock"></i> Alterar
              </button>
            </div>
        </form>
    </div>
</div>