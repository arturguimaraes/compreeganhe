<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $(function () {
    $( "#dateStart" ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#dateEnd" ).datepicker({ dateFormat: 'dd/mm/yy' });
  });

  function checkAll(check, field) {
  	if(field) {
	  	if(check) {
	  		$("input[name='aprovado']").prop('checked', false);
	  		$("input[name='cancelado']").prop('checked', false);
	  		$("input[name='aguardando']").prop('checked', false);
	  		$("input[name='enviado']").prop('checked', false);
	  	}
	  	else {
	  		$("input[name='todos']").prop('checked', false);
	  	}
	}
  }
</script>

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
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Meus Pedidos</h2>
        <!--<div class="margin-bottom-20">
          <span class="margin-bottom-10 margin-right-10">Organizar por</span>
          <a class="btn btn-<?=(isset($_GET['order']) && $_GET['order'] == 'reference') ? 'primary' : 'success'?> margin-bottom-10 margin-right-10" href="?order=reference">Referência</a>
          <a class="btn btn-<?=(isset($_GET['order']) && $_GET['order'] == 'createDate') ? 'primary' : 'success'?> margin-bottom-10 margin-right-10" href="?order=createDate">Data de Criação <i class="fa fa-sort-numeric-asc"></i></a>
          <a class="btn btn-<?=(isset($_GET['order']) && $_GET['order'] == 'createDateDesc') || (!isset($_GET['order'])) ? 'primary' : 'success'?> margin-bottom-10 margin-right-10" href="?order=createDateDesc">Data de Criação <i class="fa fa-sort-numeric-desc"></i></a>
        </div>
        <div class="margin-bottom-20">
          <form id="filterForm" method="get">
            <span class="margin-bottom-10 margin-right-10">Filtrar por Data</span>
            <input id="dateStart" name="dateStart" type="text" class="form-control margin-bottom-10 margin-right-10" style="width: 120px; display: initial;" maxlength="10" value="<?=isset($_GET['dateStart']) ? $_GET['dateStart'] : ''?>">
             a 
            <input id="dateEnd" name="dateEnd" type="text" class="form-control margin-bottom-10 margin-right-10" style="width: 120px; display: initial;" maxlength="10" value="<?=isset($_GET['dateEnd']) ? $_GET['dateEnd'] : ''?>">
            <button id="submit" name="submit" type="submit" value="submit" class="btn btn-success">Filtrar</button>
            <a href="/myorders" class="btn btn-warning margin-bottom-10 margin-right-10">Limpar</a>
          </form>
        </div>-->
        <div class="margin-bottom-20">
          <form id="filterForm" method="get" class="display-flex-desktop col-md-12">
          	<div class="check-box-container">
          		<p class="bold">Filtrar por status</p>
          	</div>
          	<div class="check-box-container">
	          	<input name="todos" type="checkbox" onclick="checkAll(true, this.checked);" <?= sizeof($_GET) == 0 || isset($_GET['todos']) ? "checked" : "" ?>>
	          	<label>Todos</label>
	        </div>
	        <div class="check-box-container">
	            <input name="aprovado" type="checkbox" onclick="checkAll(false, this.checked);" <?= isset($_GET['aprovado']) ? "checked" : "" ?>>
	          	<label>Aprovado</label>
	        </div>
	        <div class="check-box-container">
	            <input name="cancelado" type="checkbox" onclick="checkAll(false, this.checked);" <?= isset($_GET['cancelado']) ? "checked" : "" ?>>
	          	<label>Cancelado</label>
	        </div>
	        <div class="check-box-container">
	            <input name="aguardando" type="checkbox" onclick="checkAll(false, this.checked);" <?= isset($_GET['aguardando']) ? "checked" : "" ?>>
	          	<label>Aguardando Pgto.</label>
	        </div>
	        <div class="check-box-container">
	            <input name="enviado" type="checkbox" onclick="checkAll(false, this.checked);" <?= isset($_GET['enviado']) ? "checked" : "" ?>>
	          	<label>Enviado ao PagSeguro</label>
	        </div>
            <button type="submit" value="submit" class="btn btn-success">Filtrar</button>
          </form>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Data</th>
                <th>Referência</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($orders) > 0) {  
                foreach($orders as $order) { ?>
                  <tr style="<?=$order->backgroundColor?>">
                    <td><?=$this->util->dateTimeToString($order->createDate)?></td>
                    <td><a class="text-green" href="/order?id=<?=$order->id?>"><?=$order->reference?></a></td>
                    <td><?=$order->description?></td>
                    <td><?=$order->status?></td>
                    <td>R$ <?=number_format($order->total, 2, ',', '')?></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="5" class="text-align-center">Você não fez nenhum pedido ou não foram encontrados resultados.</td>
                </tr>
              <? } ?>
            </tbody>
          </table>
        </div>
        <?php if(count($orders) > 0) { ?>
          <div class="col-md-12 display-grid">
            <div class="margin-auto">
              <form id="filterForm" method="post">
                <button id="filter" name="filter" type="submit" value="submit" class="btn btn-success margin-right-10">Exportar</button>
                <a href="javascript:;" onclick="printPage();"><img id="share-buttons-print" src="https://simplesharebuttons.com/images/somacro/print.png" alt="Print"/></a>
              </form>
            </div>
          </div>
        <? } ?>
      </div>
    </div>
</div>

<!-- FOOTER -->