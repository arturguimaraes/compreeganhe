<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Pedido Realizado</h2>
        <p><b>Número de Referência:</b> <?=$reference?></p>
        <p><b>Status do Pedido:</b> <?=$status?></p>
        <div class="table-responsive">
          <table class="table table-striped margin-bottom-30">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($_SESSION['shoppingCart']) > 0) {
				        foreach($_SESSION['shoppingCart'] as $item) { ?>
                  <tr>
                    <td><?=$item->name?></td>
                    <td><?=$item->description?></td>
                    <td>R$ <?=number_format($item->value, 2, ',', '')?></td>
                  </tr>
                <? } ?>
                <tr style="font-weight: bold;">
                  <td colspan="2">TOTAL:</td>
                  <td>R$ <?=number_format($total, 2, ',', '')?></td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="3">Não há itens no carrinho.</td>
                </tr>
              <? } ?>
            </tbody>
          </table>
          <?php if(count($_SESSION['shoppingCart']) > 0) { ?>
        		<!-- PAGSEGURO -->
            <form method="post" target="pagseguro" action="https://pagseguro.uol.com.br/v2/checkout/payment.html">
                <!-- Campos obrigatórios -->  
                <input name="receiverEmail" type="hidden" value="financeiro@compreeganhe.net">
                <input name="currency" type="hidden" value="BRL">  
                <input name="encoding" type="hidden" value="UTF-8">
          
          		<?php $i = 1;
                foreach($_SESSION['shoppingCart'] as $item) { ?>
                  <!-- Itens do pagamento (ao menos um item é obrigatório) -->  
                  <input name="itemId<?=$i?>" type="hidden" value="0001">  
                  <input name="itemDescription<?=$i?>" type="hidden" value="<?=$item->name?>">  
                  <input name="itemAmount<?=$i?>" type="hidden" value="<?=number_format($item->value, 2, '.', '')?>">  
                  <input name="itemQuantity<?=$i?>" type="hidden" value="1">  
                  <input name="itemWeight<?=$i?>" type="hidden" value="1000">
                  <?php $i++;
		             } ?>
          
                <!-- Código de referência do pagamento no seu sistema (opcional) -->  
                <input name="reference" type="hidden" value="<?=$reference?>">  
                 
                <!-- Dados do comprador (opcionais) -->  
                <input name="senderName" type="hidden" value="<?=$user->name?>"> 
                <input name="senderEmail" type="hidden" value="<?=$user->email?>">
                <input name="senderAreaCode" type="hidden" value="<?=$this->user->getAreaCode($user->telefone)?>">
                <input name="senderPhone" type="hidden" value="<?=$this->user->getPureNumber($user->telefone)?>">
                <input name="senderCPF" type="hidden" value="<?=$this->user->getPureCPF($user->cpf)?>">
                <input name="senderBornDate" type="hidden" value="<?=$user->dob?>">
                <input name="shippingAddressNumber" type="hidden" value="<?=$user->numero?>">
                <input name="addressComplement" type="hidden" value="<?=$user->complemento?>">
                
                <!-- Informações de frete (opcionais) -->  
                <input name="shippingType" type="hidden" value="1">  
                <input name="shippingAddressPostalCode" type="hidden" value="<?=$user->cep?>">  
                <input name="shippingAddressStreet" type="hidden" value="<?=$user->logradouro?>">  
                <input name="shippingAddressNumber" type="hidden" value="<?=$user->numero?>">  
                <input name="shippingAddressComplement" type="hidden" value="<?=$user->complemento?>">
                <input name="shippingAddressDistrict" type="hidden" value="<?=$user->bairro?>">  
                <input name="shippingAddressCity" type="hidden" value="<?=$user->cidade?>">                     
                <div style="width: 100%; display: grid;">
                    <!-- submit do form (obrigatório) -->  
                    <input alt="Pague com PagSeguro" name="submit"  type="image" style="width: 150px; margin: auto;"
                        src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif"/> 
                </div>
				    </form>
          <? } ?>
        </div>
      </div>
    </div>
</div>

<!-- FOOTER -->