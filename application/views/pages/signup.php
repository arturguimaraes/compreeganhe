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
				
				<form id="signupForm" class="form-signin col-md-10 no-padding margin-auto-horizontal" role="form" action="" method="post">    
		          	
		          	<?php if (isset($messages) && isset($messages['submit'])) { ?>
						<div class="col-md-12 <?=$messages['submit']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['submit']['message']?></div>
					<? } ?>

		          	<div class="display-flex-desktop margin-bottom-30">
		                
		                <div class="col-md-6 col-12 no-padding-mobile">
		                    <input type="text" id="name" name="name" class="form-control margin-bottom-10" placeholder="Nome Completo" required autofocus value="<?=$this->user->getFromPost('name')?>">
		                    <input type="email" id="email" name="email" class="form-control margin-bottom-10" placeholder="E-mail" required value="<?=$this->user->getFromPost('email')?>">
		                    <input type="text" id="cpf" name="cpf" class="form-control margin-bottom-10" placeholder="CPF" required maxlength=14 value="<?=$this->user->getFromPost('cpf')?>" onblur="checkCPF(this.value);">
		                    <input type="text" id="rg" name="rg" class="form-control margin-bottom-10" placeholder="RG" required maxlength="25" value="<?=$this->user->getFromPost('rg')?>">
		                    <input type="text" id="dob" name="dob" class="form-control margin-bottom-10" placeholder="Data de Nascimento" required maxlength="10" value="<?=$this->user->getFromPost('dob')?>" onblur="checkDOB(this.value);">
		                    <input type="text" id="telefone" name="telefone" class="form-control margin-bottom-10" placeholder="Telefone" required maxlength="15" value="<?=$this->user->getFromPost('telefone')?>">
		                    <input type="text" id="motherName" name="motherName" class="form-control margin-bottom-10" placeholder="Nome da mãe" required value="<?=$this->user->getFromPost('motherName')?>">
		                    <input type="text" id="fatherName" name="fatherName" class="form-control margin-bottom-10" placeholder="Nome do pai" required value="<?=$this->user->getFromPost('fatherName')?>">
		                    <select id="estadoCivil" name="estadoCivil" class="form-control margin-bottom-10" required>
		                      <option value="">Selecione o estado civil</option>
		                      <option value="solteiro" <?=$this->user->getFromPost('estadoCivil') == 'solteiro' ? 'selected' : ''?>>Solteiro(a)</option>
		                      <option value="casado" <?=$this->user->getFromPost('estadoCivil') == 'casado' ? 'selected' : ''?>>Casado(a)</option>
		                      <option value="viuvo" <?=$this->user->getFromPost('estadoCivil') == 'viuvo' ? 'selected' : ''?>>Viúvo(a)</option>
		                      <option value="outro" <?=$this->user->getFromPost('estadoCivil') == 'outro' ? 'selectec' : ''?>>Outro</option>
		                    </select>
		                </div>
		                <!-- /.col-md-6 -->

		                <div class="col-md-6 col-12 no-padding-mobile">
		                	<select id="sexo" name="sexo" class="form-control margin-bottom-10" required>
		                      <option value="">Selecione o sexo</option>
		                      <option value="masculino" <?=$this->user->getFromPost('sexo') == 'masculino' ? 'selected' : ''?>>Masculino</option>
		                      <option value="feminino" <?=$this->user->getFromPost('sexo') == 'feminino' ? 'selected' : ''?>>Feminino</option>
		                    </select>
		                    <select id="escolaridade" name="escolaridade" class="form-control margin-bottom-10" required>
		                      <option value="">Selecione o grau de escolaridade</option>
		                      <option value="fundamentalIncompleto" <?=$this->user->getFromPost('escolaridade') == 'fundamentalIncompleto' ? 'selected' : ''?>>Ensino Fundamental Incompleto</option>
		                      <option value="fundamentalCompleto" <?=$this->user->getFromPost('escolaridade') == 'fundamentalCompleto' ? 'selected' : ''?>>Ensino Fundamental Completo</option>
		                      <option value="medio" <?=$this->user->getFromPost('escolaridade') == 'medio' ? 'selected' : ''?>>Ensino Médio</option>
		                      <option value="tecnico" <?=$this->user->getFromPost('escolaridade') == 'tecnico' ? 'selected' : ''?>>Ensino Técnico</option>
		                      <option value="superior" <?=$this->user->getFromPost('escolaridade') == 'superior' ? 'selected' : ''?>>Ensino Superior</option>
		                      <option value="pos" <?=$this->user->getFromPost('escolaridade') == 'pos' ? 'selected' : ''?>>Pós Graduado (mestrado / doutorado)</option>
		                    </select>
		                    <input type="text" id="profissao" name="profissao" class="form-control margin-bottom-10" placeholder="Profissão" required value="<?=$this->user->getFromPost('profissao')?>">
		                	<input type="text" id="cep" name="cep" class="form-control margin-bottom-10" placeholder="CEP" required maxlength="9" onblur="pesquisaCEP(this.value);" value="<?=$this->user->getFromPost('cep')?>">
		                    <input type="text" id="logradouro" name="logradouro" class="form-control margin-bottom-10" placeholder="Logradouro" required value="<?=$this->user->getFromPost('logradouro')?>">
		                    <input type="text" id="numero" name="numero" class="form-control margin-bottom-10" placeholder="Nº" value="<?=$this->user->getFromPost('numero')?>" required>
		                    <input type="text" id="complemento" name="complemento" class="form-control margin-bottom-10" placeholder="Complemento" value="<?=$this->user->getFromPost('complemento')?>">
		                    <input type="text" id="bairro" name="bairro" class="form-control margin-bottom-10" placeholder="Bairro" value="<?=$this->user->getFromPost('bairro')?>" required>
		                    <input type="text" id="cidade" name="cidade" class="form-control margin-bottom-10" placeholder="Cidade" required value="<?=$this->user->getFromPost('cidade')?>">
		                    <input type="text" id="estado" name="estado" class="form-control margin-bottom-10" placeholder="Estado" required value="<?=$this->user->getFromPost('estado')?>">
		                </div>
		                <!-- /.col-md-6 -->

		            </div>
		            <!-- /.display-flex-desktop -->

		            <div class="col-md-4 no-padding margin-auto-horizontal">
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