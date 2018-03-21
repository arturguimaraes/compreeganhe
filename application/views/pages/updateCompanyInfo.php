<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js" type="text/javascript" ></script>

<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-briefcase"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->
    
    <div class="col-md-6">
        <form id="updateCompanyInfoForm" class="" method="post">

            <!-- DADOS PRINCIPAIS -->
            <div id="info" class="form-section fadeIn animated">
                <? if (isset($messages) && isset($messages['company'])) { ?>
                    <div class="col-md-12 <?=$messages['company']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['company']['message']?></div>
                <? } ?>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">Nome <span class="text-red bold">*</span></label>
                    <div class="col-md-10">
                        <input id="name" name="name" type="text" class="form-control" value="<?=$this->helper->getOrValue('name',$company->name)?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="razaoSocial" class="col-md-2 col-form-label">Razão Social</label>
                    <div class="col-md-10">
                        <input id="razaoSocial" name="razaoSocial" type="text" class="form-control" value="<?=$this->helper->getOrValue('razaoSocial',$company->razaoSocial)?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cnpj" class="col-md-2 col-form-label">CNPJ</label>
                    <div class="col-md-10">
                        <input id="cnpj" name="cnpj" type="text" class="form-control" value="<?=$this->helper->getOrValue('cnpj',$company->cnpj)?>" onblur="validarCNPJ(this);">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inscricaoEstadual" class="col-md-2 col-form-label">Inscrição Estadual</label>
                    <div class="col-md-10">
                        <input id="inscricaoEstadual" name="inscricaoEstadual" type="text" class="form-control" value="<?=$this->helper->getOrValue('inscricaoEstadual',$company->inscricaoEstadual)?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inscricaoMunicipal" class="col-md-2 col-form-label">Inscrição Municipal</label>
                    <div class="col-md-10">
                        <input id="inscricaoMunicipal" name="inscricaoMunicipal" type="text" class="form-control" value="<?=$this->helper->getOrValue('inscricaoMunicipal',$company->inscricaoMunicipal)?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="website" class="col-md-2 col-form-label">Site</label>
                    <div class="col-md-10">
                        <input id="website" name="website" type="text" class="form-control" placeholder="http://www.site.com.br" value="<?=$this->helper->getOrValue('website',$company->website)?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-md-2 col-form-label">Telefone Comercial</label>
                    <div class="col-md-10">
                        <input id="phone" name="phone" type="text" class="form-control" value="<?=$this->helper->getOrValue('phone',$company->phone)?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <a class="btn btn-lg btn-block btn-warning margin-right-20" href="company">Voltar</a>
                    </div>
                    <div class="col-md-6">
                        <button id="submit" name="submit" type="submit" class="btn btn-lg btn-block btn-success">Alterar</button>
                    </div>
                </div>
            </div>
            <!-- FIM DADOS PRINCIPAIS -->

        </form>
    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->

<!-- Custom Mask -->
<script src="assets/js/mask.js" type="text/javascript" ></script>