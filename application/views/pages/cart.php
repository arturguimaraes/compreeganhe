<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<style>
  @media (min-width: 1200px) {
    #page-content .container {
      max-width: 90%;
    }
  }  
</style>

<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100 margin-bottom-50">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Carrinho</h2>
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
              <?php if(isset($_SESSION['shoppingCart']) && count($_SESSION['shoppingCart']) > 0) {
				        foreach($_SESSION['shoppingCart'] as $item) { ?>
                  <tr>
                    <td><?=$item->name?></td>
                    <td><?=$item->description?></td>
                    <td>R$ <?=number_format($item->value, 2, ',', '')?></td>
                  </tr>
                <?php $total += $item->value; } ?>
                <trstyle="font-weight: bold;">
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
          <div class="col-md-12 display-grid">
            <div class="margin-auto">
              <a href="/shop" class="btn btn-info margin-bottom-10">Continuar Comprando</a>
              <?php if(isset($_SESSION['shoppingCart']) && count($_SESSION['shoppingCart']) > 0) { ?>
                <a href="/emptyCart" class="btn btn-warning margin-bottom-10">Limpar Carrinho</a>
                <a href="/buy" class="btn btn-success margin-bottom-10">Finalizar Compra</a>
              <? } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Últimos 5 Pedidos</h2>
        <div class="table-responsive">
          <table class="table table-striped margin-bottom-30">
            <thead>
              <tr>
                <th>Referência</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Quantidade</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($orders) > 0) {  
                foreach($orders as $order) { ?>
                  <tr style="<?=$order->backgroundColor?>">
                    <td><a class="text-green" href="/order?id=<?=$order->id?>"><?=$order->reference?></a></td>
                    <td><?=$this->util->dateTimeToString($order->createDate)?></td>
                    <td><?=$order->description?></td>
                    <td><?=$order->status?></td>
                    <td><?=$order->productAmount?></td>
                    <td>R$ <?=number_format($order->total, 2, ',', '')?></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="6" class="text-align-center">Você não fez nenhum pedido.</td>
                </tr>
              <? } ?>
            </tbody>
          </table>
          <div class="col-md-12 display-grid">
            <div class="margin-auto">
              <a href="/myorders" class="btn btn-success margin-bottom-10">Ver Todos</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- FOOTER -->