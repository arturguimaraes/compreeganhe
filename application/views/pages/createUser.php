<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js" type="text/javascript" ></script>

<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->
    
    <div class="col-md-6">
        <form id="registerUserForm" class="" method="post">

            <!-- USUÁRIO -->
            <div id="user" class="form-section fadeIn animated">
                <? if (isset($messages) && isset($messages['user'])) { ?>
                    <div class="col-md-12 <?=$messages['user']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['user']['message']?></div>
                <? } ?>
                <div class="form-group row">
                    <label for="name" class="col-md-3 col-form-label">Nome <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <input id="name" name="name" type="text" class="form-control" value="<?=$this->helper->get('name')?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-3 col-form-label">E-mail <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <input id="email" name="email" type="email" class="form-control" value="<?=$this->helper->get('email')?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="profileCompanyId" class="col-md-3 col-form-label">Perfil <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <select id="profileCompanyId" name="profileCompanyId" class="form-control" required>
                            <option value=""></option>
                            <?php foreach($profiles as $profile) { ?>
                                <option value="<?=$profile->id?>" <?=$this->helper->get('profileCompanyId') == $profile->id ? 'selected' : ''?>><?=$profile->profile?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dob" class="col-md-3 col-form-label">Data de Nascimento</label>
                    <div class="col-md-9">
                        <input id="dob" name="dob" type="date" class="form-control" value="<?=$this->helper->get('dob')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="documentType" class="col-md-3 col-form-label">Tipo de Documento</label>
                    <div class="col-md-9">
                        <input id="documentType" name="documentType" type="text" class="form-control" value="<?=$this->helper->get('documentType')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="document" class="col-md-3 col-form-label">Nº do Documento</label>
                    <div class="col-md-9">
                        <input id="document" name="document" type="text" class="form-control" value="<?=$this->helper->get('document')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-md-3 col-form-label">Usuário <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <input id="username" name="username" type="text" class="form-control" value="<?=$this->helper->get('username')?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-3 col-form-label">Senha <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <input id="password" name="password" type="password" class="form-control" value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="passwordRepeat" class="col-md-3 col-form-label">Repetir Senha <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <input id="passwordRepeat" name="passwordRepeat" type="password" class="form-control" value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button id="submit" name="submit" type="submit" class="btn btn-lg btn-block btn-success">Cadastrar</button>  
                    </div>
                </div>
            </div>
            <!-- FIM USUÁRIO -->

        </form>
    </div>
    <!-- /.col-md-6 -->

</div>
<!-- /.row -->

<!-- Custom Mask -->
<script src="assets/js/mask.js" type="text/javascript" ></script>