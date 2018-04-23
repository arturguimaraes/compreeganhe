<h1>Usuários</h1>
<div class="row display-flex margin-bottom-10">
    <div class="col-md-12">
        <input id="username" type="text" class="form-control filter-search margin-bottom-10 margin-right-10" placeholder="Buscar por Usuário (ex: 1230081)" style="width:240px;display:initial;">
        <input class="btn margin-bottom-10 margin-right-10" type="button" onclick="filterUser();" value="Buscar">
        <a href="adminUsers?limit=1000" class="btn btn-success margin-bottom-10 margin-right-10">Mostrar 1000</a>
        <a href="adminUsers" class="btn btn-success margin-bottom-10 margin-right-10">Todos</a>
    </div>
</div>
<div class="row admin-table margin-bottom-20">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Usuário Pai</th>
                    <th scope="col">Registro</th>
                    <th scope="col">Última Atualização</th>
                    <th scope="col">Graduação</th>
                    <th scope="col">Data de Ativação</th>
                    <th scope="col">Pedido de cadastro</th>
                    <th scope="col">Saldo</th>
                    <th scope="col">Alterar Dados</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($users) > 0) {
                    $i = 1; 
                    foreach($users as $user) { ?>
                        <tr style="background:<?=$user->color?>">
                            <td  scope="row"><?=$i++?></td>
                            <td><?=$user->username?></td>
                            <td><?=$user->firstName?></td>
                            <td><?=$user->father?></td>
                            <td><?=$this->util->dateTimeToString($user->createDate)?></td>
                            <td><?=$this->util->dateTimeToString($user->updateDate)?></td>
                            <td><select name="graduation<?=$user->id?>" class="form-control" onchange="changeGraduation(<?=$user->id?>,this.value);">
                                    <option <?=$user->graduation == 'INICIANTE' ? 'selected' : ''?> value="INICIANTE">INICIANTE</option>
                                    <option <?=$user->graduation == 'BRONZE' ? 'selected' : ''?> value="BRONZE">BRONZE</option>
                                    <option <?=$user->graduation == 'PRATA' ? 'selected' : ''?> value="PRATA">PRATA</option>
                                    <option <?=$user->graduation == 'OURO' ? 'selected' : ''?> value="OURO">OURO</option>
                                    <option <?=$user->graduation == 'DIAMANTE' ? 'selected' : ''?> value="DIAMANTE">DIAMANTE</option>
                                    <?php if($user->graduation != 'INICIANTE' &&
                                             $user->graduation != 'BRONZE' &&
                                             $user->graduation != 'PRATA' &&
                                             $user->graduation != 'OURO' &&
                                             $user->graduation != 'DIAMANTE') { ?>
                                        <option value="<?=$user->graduation?>" selected><?=$user->graduation?></option>
                                    <? } ?>
                                </select>
                            </td>
                            <td><?=$user->userPaymentDate?></td>
                            <td><?=$user->reference?></td>
                            <!--<td>
                            	<select name="paymentOrder<?=$user->id?>" class="form-control" onchange="changePaymentReference(<?=$user->id?>,this.value);">
                            		<?php foreach($user->paymentOrders as $paymentOrder) { ?>
                            			<option <?=$paymentOrder->reference == $user->reference ? 'selected' : ''?> value="<?=$paymentOrder->reference?>"><?=$paymentOrder->reference?></option>
                            		<? } ?>
                                </select>
                            </td>-->
                            <td>R$ <?=number_format($user->balance, 2, ',', '')?></td>
                            <td><a class="btn btn-warning" onclick="modalDadosUsuario(<?=$user->id?>);">Alterar</a></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="9" class="text-align-center">Não foram encontrados usuários.</td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
</div>