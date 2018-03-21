<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js" type="text/javascript" ></script>

<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user"></i> Cadastrar Novo Cliente</h1>
    </div>
    <!-- /.col-md-12 -->
    
    <div class="col-md-6">
        <form id="registerClientForm" class="" method="post">

            <!-- DADOS PRINCIPAIS -->
            <div id="info" class="form-section fadeIn animated <?=$step == 1 ? '' : 'hidden'?>">
                <h3 class="form-header">Dados Principais</h3>        
                <? if (isset($messages) && isset($messages['client1'])) { ?>
                    <div class="col-md-12 <?=$messages['client1']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['client1']['message']?></div>
                <? } ?>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">Nome <span class="text-red bold">*</span></label>
                    <div class="col-md-10">
                        <input id="name" name="name" type="text" class="form-control" value="<?=$this->helper->get('name')?>" onblur="verificaNome(this.value);" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="razaoSocial" class="col-md-2 col-form-label">Razão Social</label>
                    <div class="col-md-10">
                        <input id="razaoSocial" name="razaoSocial" type="text" class="form-control" value="<?=$this->helper->get('razaoSocial')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cnpj" class="col-md-2 col-form-label">CNPJ</label>
                    <div class="col-md-10">
                        <input id="cnpj" name="cnpj" type="text" class="form-control" value="<?=$this->helper->get('cnpj')?>" onblur="validarCNPJ(this);">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inscricaoEstadual" class="col-md-2 col-form-label">Inscrição Estadual</label>
                    <div class="col-md-10">
                        <input id="inscricaoEstadual" name="inscricaoEstadual" type="text" class="form-control" value="<?=$this->helper->get('inscricaoEstadual')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inscricaoMunicipal" class="col-md-2 col-form-label">Inscrição Municipal</label>
                    <div class="col-md-10">
                        <input id="inscricaoMunicipal" name="inscricaoMunicipal" type="text" class="form-control" value="<?=$this->helper->get('inscricaoMunicipal')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="website" class="col-md-2 col-form-label">Site</label>
                    <div class="col-md-10">
                        <input id="website" name="website" type="text" class="form-control" placeholder="http://www.site.com.br" value="<?=$this->helper->get('website')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-md-2 col-form-label">Telefone Comercial</label>
                    <div class="col-md-10">
                        <input id="phone" name="phone" type="text" class="form-control" value="<?=$this->helper->get('phone')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <a id="advance1" class="btn btn-lg btn-block btn-primary" onclick="advance(2);">Avançar</a>
                    </div>
                </div>
            </div>
            <!-- FIM DADOS PRINCIPAIS -->
            
            <!-- ENDEREÇO -->
            <div id="address" class="form-section fadeIn animated <?=$step == 2 ? '' : 'hidden'?>">
                <h3 class="form-header">Endereço</h3>
                <? if (isset($messages) && isset($messages['client2'])) { ?>
                    <div class="col-md-12 <?=$messages['client2']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['client2']['message']?></div>
                <? } ?>
                <div class="form-group row">
                    <label for="cep" class="col-md-2 col-form-label">CEP</label>
                    <div class="col-md-10">
                        <input id="cep" name="cep" type="text" class="form-control" onblur="pesquisacep(this.value);" value="<?=$this->helper->get('cep')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="street" class="col-md-2 col-form-label">Rua</label>
                    <div class="col-md-10">
                        <input id="street" name="street" type="text" class="form-control" value="<?=$this->helper->get('street')?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="complement" class="col-md-2 col-form-label">Complemento</label>
                    <div class="col-md-10">
                        <input id="complement" name="complement" type="text" class="form-control" value="<?=$this->helper->get('complement')?>" <?=$this->helper->get('complement') == "" ? 'readonly' : ''?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="area" class="col-md-2 col-form-label">Bairro</label>
                    <div class="col-md-10">
                        <input id="area" name="area" type="text" class="form-control" value="<?=$this->helper->get('area')?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-md-2 col-form-label">Cidade</label>
                    <div class="col-md-10">
                        <input id="city" name="city" type="text" class="form-control" value="<?=$this->helper->get('city')?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-md-2 col-form-label">Estado</label>
                    <div class="col-md-10">
                        <input id="state" name="state" type="text" class="form-control" value="<?=$this->helper->get('state')?>" readonly>
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
                            <input id="cep2" name="cep2" type="text" class="form-control" onblur="pesquisacep2(this.value);" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="street2" class="col-md-2 col-form-label">Rua</label>
                        <div class="col-md-10">
                            <input id="street2" name="street2" type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="complement2" class="col-md-2 col-form-label">Complemento</label>
                        <div class="col-md-10">
                            <input id="complement2" name="complement2" type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="area2" class="col-md-2 col-form-label">Bairro</label>
                        <div class="col-md-10">
                            <input id="area2" name="area2" type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="city2" class="col-md-2 col-form-label">Cidade</label>
                        <div class="col-md-10">
                            <input id="city2" name="city2" type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="state2" class="col-md-2 col-form-label">Estado</label>
                        <div class="col-md-10">
                            <input id="state2" name="state2" type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <a class="btn btn-lg btn-block btn-warning" onclick="back(1);" style="margin-right: 20px;">Voltar</a>
                    </div>
                    <div class="col-md-6">
                    	<a id="advance2" class="btn btn-lg btn-block btn-primary" onclick="advance(3);">Avançar</a>
                    </div>
                </div>
                <!-- FIM ENDEREÇO FISCAL-->

            </div>
            <!-- FIM ENDEREÇO -->

            <!-- CONTATO -->
            <div id="contact" class="form-section fadeIn animated <?=$step == 3 ? '' : 'hidden'?>">
                <h3 class="form-header">Contatos</h3>
                <? if (isset($messages) && isset($messages['client3'])) { ?>
                    <div class="col-md-12 <?=$messages['client3']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['client3']['message']?></div>
                <? } ?>     
                <div class="form-group row">
                    <label for="contact1" class="col-md-2 col-form-label">Nome do Contato 1</label>
                    <div class="col-md-10">
                        <input id="contact1Name" name="contact1Name" type="text" class="form-control" value="<?=$this->helper->get('contact1Name')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contact1Email" class="col-md-2 col-form-label">E-mail do Contato 1</label>
                    <div class="col-md-10">
                        <input id="contact1Email" name="contact1Email" type="email" class="form-control" value="<?=$this->helper->get('contact1Email')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contact1Phone" class="col-md-2 col-form-label">Telefone do Contato 1</label>
                    <div class="col-md-10">
                        <input id="contact1Phone" name="contact1Phone" type="text" class="form-control" value="<?=$this->helper->get('contact1Phone')?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10 col-md-offset-2">
                        <input class="form-check-input" type="checkbox" id="contact2Check" name="contact2Check" onclick="verificaContato(2, this.checked);" <?=$this->helper->get('contact2Check') == 'on' ? 'checked' : ''?>>
                        <label class="form-check-label" for="contact2Check"> Possui 2º Contato</label>
                    </div>
                </div>
                <div id="contact2" class="form-section fadeIn animated <?=$this->helper->get('contact2Check') == 'on' ? '' : 'hidden'?>">
                	<div class="form-group row">
                        <label for="contact2" class="col-md-2 col-form-label">Nome do Contato 2</label>
                        <div class="col-md-10">
                            <input id="contact2Name" name="contact2Name" type="text" class="form-control" value="<?=$this->helper->get('contact2Name')?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contact2Email" class="col-md-2 col-form-label">E-mail do Contato 2</label>
                        <div class="col-md-10">
                            <input id="contact2Email" name="contact2Email" type="email" class="form-control" value="<?=$this->helper->get('contact2Email')?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contact2Phone" class="col-md-2 col-form-label">Telefone do Contato 2</label>
                        <div class="col-md-10">
                            <input id="contact2Phone" name="contact2Phone" type="text" class="form-control" value="<?=$this->helper->get('contact2Phone')?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="color" class="col-md-2 col-form-label">Cor <span class="text-red bold">*</span></label>
                    <div class="col-md-10">
                        <input id="color" name="color" type="color" class="form-control" value="<?=$this->helper->getOrValue('color','#ff0000')?>" required>
                    </div>
                    <? if (isset($messages) && isset($messages['color'])) { ?>
                        <div class="col-md-12 <?=$messages['color']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['color']['message']?></div>
                    <? } ?> 
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                    	<a class="btn btn-lg btn-block btn-warning" onclick="back(2);" style="margin-right: 20px;">Voltar</a>
                    </div>
                    <div class="col-md-6">
                    	<button id="submit" name="submit" type="submit" class="btn btn-lg btn-block btn-success" <?=$this->helper->get('name') == "" ? 'disabled' : ''?>>Cadastrar</button>
                    </div>
                </div>
            </div>
            <!-- FIM CONTATO -->

        </form>
    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->

<!-- Custom Mask -->
<script src="assets/js/mask.js" type="text/javascript" ></script>