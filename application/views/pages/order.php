<!-- HEADER -->

<!-- NAVIGATION -->
<!-- PAGE CONTENT -->
<div id="page-content">
  <div class="container">
    <div class="col-md-12 padding-top-100 display-grid">
      <h2 class="col-md-12 margin-bottom-30 text-align-center"><?=$page['title']?></h2>
      <div>
        <p><b>Referência:</b> <?=$order->reference?></p>
        <p><b>Transação PagSeguro:</b> <?=$order->transactionId?></p>
        <p><b>Descrição:</b> <?=$order->description?></p>
        <p><b>Registro:</b> <?=$this->util->dateTimeToString($order->createDate)?></p>
        <p><b>Última Atualização:</b> <?=$this->util->dateTimeToString($order->updateDate)?></p>
        <p><b>Valor:</b> R$ <?=number_format($order->total, 2, ',', '')?></p>
        <p><b>Status:</b><span style="padding: 0 5px; <?=$order->backgroundColor?>"><?=$order->status?></span></p>
      </div>
    </div>
    <div>
    	<h2 class="col-md-12 margin-bottom-30 text-align-center">Histórico do Pedido</h2>
        <div style="max-height:300px;overflow-y:auto;">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Status Anterior</th>
                            <th>Status Atual</th>
                            <th>Data da Atualização</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($logs) > 0) {
						  foreach($logs as $log) { ?>
							<tr>
							  <td><?=$log->oldStatus?></td>
							  <td><?=$log->newStatus?></td>
							  <td><?=$this->util->dateTimeToString($log->createDate)?></td>
							</tr>
						  <?php }
						} else { 
						  echo '<tr><td colspan="3" class="text-align-center">Não existe histórico para este pedido.</td></tr>';
						} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-grid">
      <div class="margin-auto">
        <a href="myorders" class="btn btn-danger">Meus Pedidos</a>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->