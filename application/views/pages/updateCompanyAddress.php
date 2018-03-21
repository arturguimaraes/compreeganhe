<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js" type="text/javascript" ></script>

<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-briefcase"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->
    
    <div class="col-md-6">
        <form id="updateCompanyAddressForm" class="" method="post">

            <!-- ENDEREÇO -->
            <div id="address" class="form-section fadeIn animated">
                <h3 class="form-header">Endereço</h3>
                <? if (isset($messages) && isset($messages['company'])) { ?>
                    <div class="col-md-12 <?=$messages['company']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['company']['message']?></div>
                <? } ?>
                <div class="form-group row">
                    <label for="cep" class="col-md-2 col-form-label">CEP</label>
                    <div class="col-md-10">
                        <input id="cep" name="cep" type="text" class="form-control" onblur="pesquisacep(this.value);" value="<?=$this->helper->getOrValue('cep')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="street" class="col-md-2 col-form-label">Rua</label>
                    <div class="col-md-10">
                        <input id="street" name="street" type="text" class="form-control" value="<?=$this->helper->getOrValue('street')?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="complement" class="col-md-2 col-form-label">Complemento</label>
                    <div class="col-md-10">
                        <input id="complement" name="complement" type="text" class="form-control" value="<?=$this->helper->getOrValue('complement')?>" <?=$this->helper->getOrValue('complement') == "" ? 'readonly' : ''?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="area" class="col-md-2 col-form-label">Bairro</label>
                    <div class="col-md-10">
                        <input id="area" name="area" type="text" class="form-control" value="<?=$this->helper->getOrValue('area')?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-md-2 col-form-label">Cidade</label>
                    <div class="col-md-10">
                        <input id="city" name="city" type="text" class="form-control" value="<?=$this->helper->getOrValue('city')?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-md-2 col-form-label">Estado</label>
                    <div class="col-md-10">
                        <input id="state" name="state" type="text" class="form-control" value="<?=$this->helper->getOrValue('state')?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10 col-md-offset-2">
                        <input class="form-check-input" type="checkbox" id="isFiscalAddress" name="isFiscalAddress" onclick="verificaEnderecoFiscal(this.checked);" checked> 
                        <label class="form-check-label" for="isFiscalAddress"> Este é o endereço fiscal</label>
                    </div>
                </div>

                <!-- ENDEREÇO FISCAL-->
                <div id="fiscalAddress" class="form-section fadeIn animated hidden">
                    <h3 class="form-header">Endereço Fiscal</h3>
                    <div class="form-group row">
                        <label for="cep2" class="col-md-2 col-form-label">CEP</label>
                        <div class="col-md-10">
                            <input id="cep2" name="cep2" type="text" class="form-control" onblur="pesquisacep2(this.value);" value="<?=$this->helper->getOrValue('cep2')?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="street2" class="col-md-2 col-form-label">Rua</label>
                        <div class="col-md-10">
                            <input id="street2" name="street2" type="text" class="form-control" value="<?=$this->helper->getOrValue('street2')?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="complement2" class="col-md-2 col-form-label">Complemento</label>
                        <div class="col-md-10">
                            <input id="complement2" name="complement2" type="text" class="form-control" value="<?=$this->helper->getOrValue('complement2')?>" <?=$this->helper->getOrValue('complement2') == "" ? 'readonly' : ''?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="area2" class="col-md-2 col-form-label">Bairro</label>
                        <div class="col-md-10">
                            <input id="area2" name="area2" type="text" class="form-control" value="<?=$this->helper->getOrValue('area2')?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="city2" class="col-md-2 col-form-label">Cidade</label>
                        <div class="col-md-10">
                            <input id="city2" name="city2" type="text" class="form-control" value="<?=$this->helper->getOrValue('city2')?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="state2" class="col-md-2 col-form-label">Estado</label>
                        <div class="col-md-10">
                            <input id="state2" name="state2" type="text" class="form-control" value="<?=$this->helper->getOrValue('state2')?>" readonly>
                        </div>
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
                <!-- FIM ENDEREÇO FISCAL-->

            </div>
            <!-- FIM ENDEREÇO -->

        </form>
    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->

<!-- Custom Mask -->
<script src="assets/js/mask.js" type="text/javascript" ></script>