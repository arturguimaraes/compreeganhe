<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js" type="text/javascript" ></script>

<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->
    
    <div class="col-md-6">
        <form id="updateUserForm" class="" method="post">

            <!-- USUÁRIO -->
            <div id="user" class="form-section fadeIn animated">
                <? if (isset($messages) && isset($messages['user'])) { ?>
                    <div class="col-md-12 <?=$messages['user']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['user']['message']?></div>
                <? } ?>
                <div class="form-group row">
                    <label for="name" class="col-md-3 col-form-label">Nome <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <input id="name" name="name" type="text" class="form-control" value="<?=$this->helper->getOrValue('name',$user->name)?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-3 col-form-label">E-mail <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <input id="email" name="email" type="email" class="form-control" value="<?=$this->helper->getOrValue('email',$user->email)?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dob" class="col-md-3 col-form-label">Data de Nascimento</label>
                    <div class="col-md-9">
                        <input id="dob" name="dob" type="date" class="form-control" value="<?=$this->string->dateTimeToDate($this->helper->getOrValue('dob',$user->dob))?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="documentType" class="col-md-3 col-form-label">Tipo de Documento</label>
                    <div class="col-md-9">
                        <input id="documentType" name="documentType" type="text" class="form-control" value="<?=$this->helper->getOrValue('documentType',$user->documentType)?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="document" class="col-md-3 col-form-label">Nº do Documento</label>
                    <div class="col-md-9">
                        <input id="document" name="document" type="text" class="form-control" value="<?=$this->helper->getOrValue('document',$user->document)?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="emailNotification" class="col-md-3 col-form-label">Notificações por E-mail? <span class="text-red bold">*</span></label>
                    <div class="col-md-9">
                        <select id="emailNotification" name="emailNotification" class="form-control" required>
                            <option value="sim" <?=$this->helper->getOrValue('emailNotification',$user->emailNotification) == 'sim' ? 'selected' : ''?>>Sim</option>
                            <option value="nao" <?=$this->helper->getOrValue('emailNotification',$user->emailNotification) == 'nao' ? 'selected' : ''?>>Não</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 padding-0">
                  <button class="btn btn-lg btn-success btn-block" type="submit" id="submit" name="submit">Atualizar</button>
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