<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#dateStart" ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#dateEnd" ).datepicker({ dateFormat: 'dd/mm/yy' });
  } );
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
        <div class="margin-bottom-20">
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
                  <td colspan="5" class="text-align-center">Você não fez nenhum pedido.</td>
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