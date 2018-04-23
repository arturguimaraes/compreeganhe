<!-- HEADER -->

<!-- NAVIGATION -->
<style>
  @media (min-width: 1200px) {
    #page-content .container {
      max-width: 90%;
    }
  }  
</style>

<!-- PAGE CONTENT -->
<div id="page-content">
  <div class="container">
    <div class="col-md-12 padding-top-100 display-grid-desktop">
      <h2 class="col-md-12 margin-bottom-30 text-align-center">Pagamento Não Recebido</h2>
      <div class="table-responsive">
        <table class="table margin-bottom-50">
          <thead>
            <tr>
              <th scope="col">Referência</th>
              <th scope="col">Transação PagSeguro</th>
              <th scope="col">Registro</th>
              <th scope="col">Última Atualização</th>
              <th scope="col">Status</th>
              <th scope="col">Valor</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><?=$order->reference?></th>
              <td><?=$order->transactionId?></td>
              <td><?=$order->createDate?></td>
              <td><?=$order->updateDate?></td>
              <td><?=$order->status?></td>
              <td>R$ <?=number_format($order->total, 2, ',', '')?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p>Parece que seu pagamento está com o seguinte status: <b><?=$order->status?></b></p>
      <?php if($order->status == "Aguardando Pagto") { ?>
        <p>Isso significa que o pagamento ainda está sendo processado. Nossa recomendação é que você aguarde um pouco antes de fazer outro pedido. Se você pagou por boleto, aguarde pelo menos 2 dias úteis antes de fazer um novo pedido.</p>
      <? } ?>
      <p>Entre no site do <b><a href="https://pagseguro.uol.com.br/">PagSeguro</a></b> e verifique o status da compra.</p>
      <p>Se preferir, entre e contato com a equipe do <b><a href="/sendMessage?id=1&ln=true">Compre & Ganhe</a></b>, peça o cancelamento dos pedidos anteriores e faça outro pedido para realizar o pagamento da taxa de inscrição.</p>
      <div class="col-md-3 margin-auto-horizontal hidden">
        <a class="btn btn-success btn-block btn-lg" href="/product?id=1">Pagar Taxa de Inscrição</a>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->