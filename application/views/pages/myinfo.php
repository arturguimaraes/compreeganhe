<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12  margin-bottom-50  padding-top-100">
        
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Meus Dados Cadastrais</h2>
        
        <form id="signupForm" class="form-signin col-md-12 margin-auto-horizontal" role="form" action="" method="post">
          
          <? if (isset($messages) && isset($messages['submit'])) { ?>
            <div class="col-md-12 <?=$messages['submit']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['submit']['message']?></div>
          <? } ?>
            
          <div class="display-flex-desktop">
            
            <div class="col-md-6 col-12">
              <div class="form-group row">
              	<label for="name" class="col-sm-3 col-form-label">Nome</label>
                  <div class="col-sm-9">
                    <input type="text" id="name" name="name" class="form-control margin-bottom-10" required="true" value="<?=$this->user->get($user, 'name')?>">
                  </div>
              </div>
              <div class="form-group row">
              	<label for="email" class="col-sm-3 col-form-label">E-mail</label>
                  <div class="col-sm-9">
                    <input type="email" id="email" name="email" class="form-control margin-bottom-10" required="true" value="<?=$this->user->get($user, 'email')?>">
                  </div>
              </div>
            	<div class="form-group row hidden">
              	<label for="cpf" class="col-sm-3 col-form-label">CPF</label>
                  <div class="col-sm-9">
                    <input type="text" id="cpf" name="cpf" class="form-control margin-bottom-10" required="true" maxlength=14 value="<?=$this->user->get($user, 'cpf')?>">
                  </div>
              </div>
            	<div class="form-group row hidden">
              	<label for="rg" class="col-sm-3 col-form-label">RG</label>
                  <div class="col-sm-9">
                    <input type="text" id="rg" name="rg" class="form-control margin-bottom-10" required="true" maxlength="12" value="<?=$this->user->get($user, 'rg')?>">
                  </div>
              </div>
            	<div class="form-group row">
              	<label for="dob" class="col-sm-3 col-form-label">Data de Nascimento</label>
                  <div class="col-sm-9">
                    <input type="text" id="dob" name="dob" class="form-control margin-bottom-10" required="true" maxlength="10" value="<?=$this->user->dateToDateString($this->user->get($user, 'dob'))?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="telefone" class="col-sm-3 col-form-label">Telefone</label>
                  <div class="col-sm-9">
                    <input type="text" id="telefone" name="telefone" class="form-control margin-bottom-10" required="true" maxlength="15" value="<?=$this->user->get($user, 'telefone')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="motherName" class="col-sm-3 col-form-label">Nome da Mãe</label>
                  <div class="col-sm-9">
                    <input type="text" id="motherName" name="motherName" class="form-control margin-bottom-10" value="<?=$this->user->get($user, 'motherName')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="fatherName" class="col-sm-3 col-form-label">Nome do Pai</label>
                  <div class="col-sm-9">
                    <input type="text" id="fatherName" name="fatherName" class="form-control margin-bottom-10" value="<?=$this->user->get($user, 'fatherName')?>">
                  </div>
              </div>
            </div>
            <!-- /.col-md-6 -->

            <div class="col-md-6 col-12">
              <div class="form-group row">
                <label for="cep" class="col-sm-3 col-form-label">CEP</label>
                  <div class="col-sm-9">
                    <input type="text" id="cep" name="cep" class="form-control margin-bottom-10" required="true" maxlength="9" onblur="pesquisaCEP(this.value);" maxlength="10" value="<?=$this->user->get($user, 'cep')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="logradouro" class="col-sm-3 col-form-label">Logradouro</label>
                  <div class="col-sm-9">
                    <input type="text" id="logradouro" name="logradouro" class="form-control margin-bottom-10" required="true" value="<?=$this->user->get($user, 'logradouro')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="numero" class="col-sm-3 col-form-label">Número</label>
                  <div class="col-sm-9">
                    <input type="text" id="numero" name="numero" class="form-control margin-bottom-10" maxlength="8" value="<?=$this->user->get($user, 'numero')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="complemento" class="col-sm-3 col-form-label">Complemento</label>
                  <div class="col-sm-9">
                    <input type="text" id="complemento" name="complemento" class="form-control margin-bottom-10" value="<?=$this->user->get($user, 'complemento')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="bairro" class="col-sm-3 col-form-label">Bairro</label>
                  <div class="col-sm-9">
                    <input type="text" id="bairro" name="bairro" class="form-control margin-bottom-10" value="<?=$this->user->get($user, 'bairro')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="cidade" class="col-sm-3 col-form-label">Cidade</label>
                  <div class="col-sm-9">
                    <input type="text" id="cidade" name="cidade" class="form-control margin-bottom-10" required="true" value="<?=$this->user->get($user, 'cidade')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="estado" class="col-sm-3 col-form-label">Estado</label>
                  <div class="col-sm-9">
                    <input type="text" id="estado" name="estado" class="form-control margin-bottom-10" required="true" value="<?=$this->user->get($user, 'estado')?>">
                  </div>
              </div>
              <div class="form-group row">
                <label for="estadoCivil" class="col-sm-3 col-form-label">Estado Civíl</label>
                  <div class="col-sm-9">
                    <select id="estadoCivil" name="estadoCivil" class="form-control margin-bottom-10">
                      <option>-</option>
                      <option value="solteiro" <?=$this->user->get($user, 'estadoCivil') == 'solteiro' ? 'selected' : ''?>>Solteiro(a)</option>
                      <option value="casado" <?=$this->user->get($user, 'estadoCivil') == 'casado' ? 'selected' : ''?>>Casado(a)</option>
                      <option value="viuvo" <?=$this->user->get($user, 'estadoCivil') == 'viuvo' ? 'selected' : ''?>>Viúvo(a)</option>
                      <option value="outro" <?=$this->user->get($user, 'estadoCivil') == 'outro' ? 'selectec' : ''?>>Outro</option>
                    </select>
                  </div>
              </div>
            </div>
            <!-- /.col-md-6 -->
            
          </div>
          <!-- /.display-flex-desktop -->

          <div class="col-md-12">
            <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit" name="submit">Atualizar</button>
          </div>

        </form>
      </div>
    </div>
</div>

<!-- FOOTER -->


<!--<div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Usuário</label>
                  <div class="col-sm-9">
                    <input type="text" id="username" name="username" class="form-control margin-bottom-10" value="<?=$this->user->get($user, 'username')?>">
                  </div>
              </div>-->
              <!--<input type="password" id="password" name="password" class="form-control margin-bottom-10" placeholder="Senha">-->
              <!--<input type="password" id="passwordRepeat" name="passwordRepeat" class="form-control margin-bottom-10" placeholder="Repetir Senha">--> 