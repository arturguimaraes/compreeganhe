<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      	<div class="col-md-12 margin-bottom-30 padding-top-100">
        
	        <h2 class="col-md-12 margin-bottom-30 text-align-center">Cadastrar</h2>
	        
	        <?php if($codeExists) { 
		  		
				if (!isset($_POST['submit'])) { ?>
					<p class="text-align-center text-green">Parabéns! Você está se cadastrando no Compre & Ganhe na rede do usuário:<br><br><b><?=$user->name?></b><br><br>Insira seus dados no formulário abaixo para continuar.</p>
				<? } ?>
				
				<form id="signupForm" class="form-signin col-md-10 margin-auto-horizontal" role="form" action="" method="post">    
		          	
		          	<?php if (isset($messages) && isset($messages['submit'])) { ?>
						<div class="col-md-12 <?=$messages['submit']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['submit']['message']?></div>
					<? } ?>

		          	<div class="display-flex-desktop margin-bottom-30">
		                
		                <div class="col-md-6 col-12">
		                    <input type="text" id="name" name="name" class="form-control margin-bottom-10" placeholder="Nome Completo" required="true" autofocus value="<?=$this->user->getFromPost('name')?>">
		                    <input type="email" id="email" name="email" class="form-control margin-bottom-10" placeholder="E-mail" required="true" autofocus value="<?=$this->user->getFromPost('email')?>">
		                    <input type="text" id="cpf" name="cpf" class="form-control margin-bottom-10" placeholder="CPF" required="true" maxlength=14 value="<?=$this->user->getFromPost('cpf')?>" onblur="checkCPF(this.value);">
		                    <input type="text" id="rg" name="rg" class="form-control margin-bottom-10" placeholder="RG" required="true" maxlength="12" value="<?=$this->user->getFromPost('rg')?>">
		                    <input type="text" id="dob" name="dob" class="form-control margin-bottom-10" placeholder="Data de Nascimento" required="true" maxlength="10" value="<?=$this->user->getFromPost('dob')?>" onblur="checkDOB(this.value);">
		                    <input type="text" id="cep" name="cep" class="form-control margin-bottom-10" placeholder="CEP" required="true" maxlength="9" onblur="pesquisaCEP(this.value);" value="<?=$this->user->getFromPost('cep')?>">
		                </div>
		                <!-- /.col-md-6 -->

		                <div class="col-md-6 col-12">
		                    <input type="text" id="logradouro" name="logradouro" class="form-control margin-bottom-10" placeholder="Logradouro" required="true" value="<?=$this->user->getFromPost('logradouro')?>">
		                    <input type="text" id="numero" name="numero" class="form-control margin-bottom-10" placeholder="Nº" value="<?=$this->user->getFromPost('numero')?>" required>
		                    <input type="text" id="complemento" name="complemento" class="form-control margin-bottom-10" placeholder="Complemento" value="<?=$this->user->getFromPost('complemento')?>">
		                    <input type="text" id="bairro" name="bairro" class="form-control margin-bottom-10" placeholder="Bairro" value="<?=$this->user->getFromPost('bairro')?>" required>
		                    <input type="text" id="cidade" name="cidade" class="form-control margin-bottom-10" placeholder="Cidade" required="true" value="<?=$this->user->getFromPost('cidade')?>">
		                    <input type="text" id="estado" name="estado" class="form-control margin-bottom-10" placeholder="Estado" required="true" value="<?=$this->user->getFromPost('estado')?>">
		                </div>
		                <!-- /.col-md-6 -->

		            </div>
		            <!-- /.display-flex-desktop -->

		            <div class="col-md-12">
		              <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit" name="submit">Cadastrar</button>
		            </div>
		            <!-- /.col-md-12 -->

	    		</form>
	      	<?php } else { ?>
	        	<p class="text-align-center text-red"> Usuário não cadastrado no Compre & Ganhe.<br>Por favor, entre em contato clicando <a href="<?=base_url()?>#contact">aqui</a>.</p>
	      	<? } ?>
      	</div>
      	<div class="col-md-12 text-align-center"><a class="text-faded" href="<?=base_url()?>">Retornar ao site</a></div>
    </div>
</div>

<!-- FOOTER -->