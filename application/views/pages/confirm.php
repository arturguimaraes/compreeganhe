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

            <div id="payment-form-container">
              <div id="payment-form-subcontainer">
            		<!-- PAGSEGURO -->
                  <image id="pagseguro-submit" onclick="sendPagSeguro();" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif" alt="Pague com PagSeguro - é rápido, grátis e seguro!"/>           
                  <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
                  <form id="pagSeguroForm" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" class="" onsubmit="return sendPagSeguro();">
                    <input type="hidden" id="code" name="code" value=""/>
                  </form>
                  <!-- SCRIPT PAGSEGURO -->
                  <script>
                    function sendPagSeguro() {
                      PagSeguroLightbox({
                          code: '<?=$payment->code?>'
                        }, {
                        success : function(transactionCode) {
                          setTimeout(function(){ 
                            window.location.href = "purchase?transaction_id=" + transactionCode.replace(/-/g, "");
                          }, 1000);
                        }
                      });
                      return false;
                    }
                  </script>
                  <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>

                <?php if($user->balance >= $total) { ?>

                  <!-- Pagamento com saldo C&G -->
                  <form method="post" action="/updateOrder" 
                  onsubmit="return confirm('ATENÇÃO: Ao proceder com essa ação, a quantia de R$ <?=number_format($item->value, 2, ',', '')?> será reduzida do seu saldo. Deseja prosseguir?');">
                      <!-- Código de referência do pagamento no seu sistema (opcional) -->  
                      <input name="Referencia" type="hidden" value="<?=$reference?>">
                      <input name="TipoPagamento" type="hidden" value="Saldo no Compre & Ganhe">
                      <input name="TransacaoID" type="hidden" value="Pedido pago com o saldo no Compre & Ganhe">
                      <input name="StatusTransacao" type="hidden" value="Aprovado">
                      <input name="return" type="hidden" value="true">
                      <!-- submit do form (obrigatório) -->  
                      <input name="submit" type="submit" id="paywithbalance-submit" value="Pagar com saldo" class="btn btn-success btn-lg"/> 
                  </form>

                <? } ?>

              </div>
            </div>
          <? } ?>
        </div>
      </div>
    </div>
</div>

<!-- FOOTER -->