<div class="row margin-bottom-30">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-users"></i> Clientes</h1>
    </div>
    <!-- /.col-md-12 -->
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Cor</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Razão Social</th>
                        <th scope="col">CNPJ</th>
                        <th scope="col">Registro</th>
                        <th scope="col" class="text-align-center">Nº de Projetos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($clients) > 0 ) { 
                        foreach ($clients as $client) { ?>
                            <tr>
                                <th scope="row"><?=$client->code?></th>
                                <td><i class="fa fa-user" style="color:#<?=$client->color?>"></td>
                                <td><a href="client?id=<?=$client->id?>"><?=$client->name?></a></td>
                                <td><?=$client->razaoSocial?></td>
                                <td><?=$client->cnpj?></td>
                                <td><?=$this->string->dateTimeToString($client->createDate)?></td>
                                <td class="text-align-center"><?=$client->projects?></td>
                            </tr>
                        <?php } 
                    } else { 
                        echo "<tr><td colspan=7 class='text-align-center'>Não há clientes cadastrados para a sua empresa.</td></tr>";
                    } ?>
              </tbody>
            </table>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->

<!-- SOMENTE PARA USUÁRIOS ADMINISTRADORES OU EDITORES -->
<?php if($user->adminEditor) { ?>
    <div class="row">
        <div class="col-md-12 display-flex">
        	<a class="col-md-3 margin-auto btn btn-lg btn-primary" href="registerClient">Cadastrar Novo</a>
    	</div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
<? } ?>