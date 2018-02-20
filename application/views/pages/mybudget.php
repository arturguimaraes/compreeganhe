<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<style>

	#share-buttons-print {
		width: 37px;
		border: 0;
		box-shadow: none;
		display: inline;
	}

	@media (min-width: 1200px) {
  	#page-content .container {
    		max-width: 90%;
  	}
	}  
  
</style>

<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Meu Extrato</h2>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($transactions) > 0) {  
                foreach($transactions as $transaction) { ?>
                  <tr>
                    <td><?=$this->util->dateTimeToString($transaction->createDate)?></td>
                    <td><?=$transaction->action?></td>
                    <td>R$ <?=number_format($transaction->value, 2, ',', '')?></td>
                  </tr>
                <?php } ?>
                <tr>
                  <td></td>
                  <td><b>TOTAL</b></td>
                  <td><b>R$ <?=number_format($total, 2, ',', '')?></b></td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="3" class="text-align-center">Não há movimentações em sua conta.</td>
                </tr>
              <? } ?>
            </tbody>
          </table>
        </div>
        <?php if(count($transactions) > 0) { ?>
          <div class="col-md-12 display-grid">
            <div class="margin-auto">
              <a class="btn btn-success margin-right-10" href="/export?content=mybudget">Exportar</a>
              <a href="javascript:;" onclick="printPage();"><img id="share-buttons-print" src="https://simplesharebuttons.com/images/somacro/print.png" alt="Print"/></a>
            </div>
          </div>
        <? } ?>
      </div>
    </div>
</div>

<!-- FOOTER -->