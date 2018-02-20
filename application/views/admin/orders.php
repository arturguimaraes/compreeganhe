<h1>Pedidos</h1>
<div class="row display-flex margin-bottom-10">
	<div class="col-md-12">
        <input id="reference" type="text" onfocus="autoFillReference();" class="form-control filter-search margin-bottom-10 margin-right-10" placeholder="Buscar por Referência (ex: CG-0934203409023902934)" style="width:240px;display:initial;">
        <input class="btn margin-bottom-10 margin-right-10" type="button" onclick="filter();" value="Buscar">
		<a href="adminOrders?limit=1000" class="btn btn-success margin-bottom-10 margin-right-10">Últimos 1000</a>
    	<a href="adminOrders?limit=10000" class="btn btn-success margin-bottom-10 margin-right-10">Últimos 10000</a>
    	<a href="adminOrders" class="btn btn-success margin-bottom-10 margin-right-10">Todos</a>
    </div>
</div>
<div class="row admin-table margin-bottom-20">
	<div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                	<th scope="col">#</th>
                    <th scope="col">Referência</th>
                    <th scope="col">Transação no PagSeguro</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Registro</th>
                    <th scope="col">Última Atualização</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($orders) > 0) {
					$i = 1;  
                    foreach($orders as $order) { ?>
                        <tr style="<?=$order->backgroundColor?>">
                            <td scope="row"><?=$i++?></td>
                            <td><?=$order->reference?></td>
                            <td><?=$order->transactionId?></td>
                            <td><?=$order->user->username?></td>
                            <td><?=$this->util->dateTimeToString($order->createDate)?></td>
                            <td><?=$this->util->dateTimeToString($order->updateDate)?></td>
                            <td>R$ <?=number_format($order->total, 2, ',', '')?></td>
                            <td><select name="status<?=$order->id?>" class="form-control" onchange="changeStatus(<?=$order->id?>,this.value);">
                                	<option <?=$order->status == 'Pedido Registrado' ? 'selected' : ''?> value="Pedido Registrado">Pedido Registrado</option>
                                    <option <?=$order->status == 'Enviado ao PagSeguro' ? 'selected' : ''?> value="Enviado ao PagSeguro">Enviado ao PagSeguro</option>
                                    <option <?=$order->status == 'Aguardando Pagto' ? 'selected' : ''?> value="Aguardando Pagto">Aguardando Pagto</option>
                                    <option <?=$order->status == 'Aprovado' ? 'selected' : ''?> value="Aprovado">Aprovado</option>
                                    <option <?=$order->status == 'Cancelado' ? 'selected' : ''?> value="Cancelado">Cancelado</option>
                                    <?php if($order->status != 'Pedido Registrado' &&
											 $order->status != 'Enviado ao PagSeguro' &&
											 $order->status != 'Aguardando Pagto' &&
											 $order->status != 'Aprovado' &&
											 $order->status != 'Cancelado') { ?>
                                    	<option value="<?=$order->status?>" selected><?=$order->status?></option>
                                    <? } ?>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                    	<td colspan="8" class="text-align-center">Não foram encontrados pedidos.</td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
</div>