<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Finalizar Compra</h2>
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
          <div class="col-md-12 display-grid">
            <div class="margin-auto">
              <a href="/cart" class="btn btn-warning margin-bottom-10">Voltar ao Carrinho</a>
              <?php if(count($_SESSION['shoppingCart']) > 0) { ?>
            	 <a href="/confirm" class="btn btn-success margin-bottom-10">Realizar Pagamento</a>
              <? } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- FOOTER -->