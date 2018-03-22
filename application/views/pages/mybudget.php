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

<script>
  function setMinDate() {
    if($("#dateStart").val() != "")
      $("#dateEnd").attr({"min" : $("#dateStart").val()}).val($("#dateStart").val());
  }

  function checkDates() {
    if (($("#dateStart").val() == "" && $("#dateEnd").val() != "") || ($("#dateStart").val() != "" && $("#dateEnd").val() == "")) {
      alert("Você deve preencher as duas datas!");
      return false;
    }
    else 
      return true;
  }

  function checkAll(check, field) {
    if(field) {
      if(check) {
        $("input[name='direta']").prop('checked', false);
        $("input[name='indireta']").prop('checked', false);
        $("input[name='graduacao']").prop('checked', false);
      }
      else {
        $("input[name='todos']").prop('checked', false);
      }
  }
  }
</script>

<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Meu Extrato</h2>
        
        <form id="filterForm" method="get" onsubmit="return checkDates();">
          <div class="margin-bottom-20">
            <div class="col-md-6 col-12 no-padding">
              <span class=" margin-bottom-10 margin-right-10">Filtrar por Data</span>
            </div>
            <div class="col-md-6 col-12 no-padding">
              <input id="dateStart" name="dateStart" type="date" class="form-control margin-bottom-10 margin-right-10" style="width: auto; display: initial;" value="<?=isset($_GET['dateStart']) ? $_GET['dateStart'] : ''?>" onblur="setMinDate();">&nbsp;a&nbsp;
              <input id="dateEnd" name="dateEnd" type="date" class="form-control margin-bottom-10 margin-right-10" style="width: auto; display: initial;" value="<?=isset($_GET['dateEnd']) ? $_GET['dateEnd'] : ''?>">
            </div>
          </div>
          <div class="display-flex-desktop margin-bottom-20">
            <div class="check-box-container">
              <p>Filtrar por tipo</p>
            </div>
            <div class="check-box-container">
              <input name="todos" type="checkbox" onclick="checkAll(true, this.checked);" <?= sizeof($_GET) == 0 || isset($_GET['todos']) ? "checked" : "" ?>>
              <label>Todos</label>
            </div>
            <div class="check-box-container">
              <input name="direta" type="checkbox" onclick="checkAll(false, this.checked);" <?= isset($_GET['direta']) ? "checked" : "" ?>>
              <label>Indicação Direta</label>
            </div>
            <div class="check-box-container">
              <input name="indireta" type="checkbox" onclick="checkAll(false, this.checked);" <?= isset($_GET['indireta']) ? "checked" : "" ?>>
              <label>Indicação Indireta</label>
            </div>
            <div class="check-box-container">
              <input name="graduacao" type="checkbox" onclick="checkAll(false, this.checked);" <?= isset($_GET['graduacao']) ? "checked" : "" ?>>
              <label>Bônus de Graduação</label>
            </div>
          </div>
          <div class="col-md-6 no-padding margin-bottom-20 display-flex">
            <button type="submit" value="submit" class="btn btn-success margin-right-10">Filtrar</button>
            <a href="/mybudget" class="btn btn-warning">Limpar</a>
          </div>
        </form>
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
                  <td colspan="3" class="text-align-center">Não há movimentações em sua conta ou não foram encontrados resultados.</td>
                </tr>
              <? } ?>
            </tbody>
          </table>
        </div>
        <?php if(count($transactions) > 0) { ?>
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