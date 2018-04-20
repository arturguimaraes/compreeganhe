<!-- HEADER -->
<div id="mainNav" class="hidden"></div>
<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      	<div class="col-md-12 margin-bottom-20 padding-top-100">
          	<form id="loginForm" class="form-signin col-md-4 margin-auto-horizontal" role="form" action="" method="post">
              	<h2 class="col-md-12 margin-bottom-30 text-align-center">Entrar</h2>
				<div class="col-md-12 margin-bottom-20">
					<input type="text" id="cpf" name="cpf" class="form-control margin-bottom-10" placeholder="CPF" required="true" autofocus maxlength="14">
					<input type="password" id="password" name="password" class="form-control" placeholder="Senha" required="true">
				</div>
				<? if (isset($messages) && isset($messages['login'])) { ?>
					<div class="col-md-12 <?=$messages['login']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['login']['message']?></div>
				<? } ?>
				<div class="col-md-12 margin-bottom-20">
					<div class="g-recaptcha" data-sitekey="6LeFX08UAAAAACPgY-VYHGyxei0dmZtH7pi0fCKG"></div>
				</div>
				<div class="col-md-12">
					<button class="btn btn-lg btn-primary btn-block" type="submit" id="submit" name="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> Entrar</button>
				</div>
          	</form>
      	</div>
		<div class="col-md-12 margin-bottom-10 text-align-center">
			<a class="text-faded" href="resetPassword">Esqueci minha senha</a>
		</div>
		<div class="col-md-12 text-align-center">
			<a class="text-faded" href="<?=base_url()?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retornar ao site</a>
		</div>
    </div>
</div>

<!-- FOOTER -->