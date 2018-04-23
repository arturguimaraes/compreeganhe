<!-- PrintThis.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.12.3/printThis.min.js"></script>

<h1>Pedidos</h1>
<div class="row">
	<div class="col-md-12">
        <input id="reference" type="text" class="form-control margin-bottom-10 margin-right-10" placeholder="Referência (Ex: 234934902394)" maxlength="12" value="<?=isset($_GET['reference']) ? $_GET['reference'] : ""?>">
        <input id="dateStart" type="date" class="form-control margin-bottom-10 margin-right-10" placeholder="01/01/2018" onblur="setDateMin();" value="<?=isset($_GET['dateStart']) ? $_GET['dateStart'] : ""?>">
        <input id="dateEnd" type="date" class="form-control margin-bottom-10 margin-right-10" placeholder="02/01/2018" value="<?=isset($_GET['dateEnd']) ? $_GET['dateEnd'] : ""?>">
        <input class="btn margin-top-8 margin-bottom-10 margin-right-10" type="button" value="Buscar" onclick="filter();">
		<a href="adminOrders?limit=1000" class="btn btn-success margin-top-8 margin-bottom-10 margin-right-10">Últimos 1000</a>
    	<a href="adminOrders?limit=10000" class="btn btn-success margin-top-8 margin-bottom-10 margin-right-10">Últimos 10000</a>
    	<a href="adminOrders" class="btn btn-success margin-top-8 margin-bottom-10 margin-right-10">Todos</a>
    </div>
    <div class="col-md-12">
        <a onclick="exportAdmin1();" class="btn btn-info margin-top-8 margin-bottom-10 margin-right-10">Exportar Cadastros</a>
        <a onclick="exportAdmin2();" class="btn btn-info margin-top-8 margin-bottom-10 margin-right-10">Exportar Compras</a>
        <!--<form method="post" class="export-container">
            <button name="export1" type="submit" value="submit" class="btn btn-info">Exportar Cadastros</button>
        </form>
        <form method="post" class="export-container margin-left-10">
            <button name="export2" type="submit" value="submit" class="btn btn-info">Exportar Compras</button>
        </form>-->
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
                    <!--<th scope="col">Excluir</th>-->
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
                            <!--<td><a class="btn btn-danger" onclick="deleteOrder(<?=$order->id?>,'<?=$order->reference?>');">Excluir</a></td>-->
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