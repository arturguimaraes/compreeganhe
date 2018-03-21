<div class="row margin-bottom-30">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-briefcase"></i> Sua Empresa</h1>
    </div>
    <!-- /.col-md-12 -->
    <div class="col-md-4">
        <p><b>Nome: </b><?=$company->name?></p>
        <p><b>Razão Social: </b><?=$company->razaoSocial?></p>
        <p><b>CNPJ: </b><?=$company->cnpj?></p>
        <p><b>Inscrição Estadual: </b><?=$company->inscricaoEstadual?></p>
        <p><b>Inscrição Municipal: </b><?=$company->inscricaoMunicipal?></p>
        <p><b>Seu Perfil na Empresa: </b><?=$user->profileCompany->profile?></p>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4">
        <p><b>Endereço: </b><?=$company->address?></p>
        <p><b>Endereço Fiscal: </b><?=$company->fiscalAddress?></p>
        <p><b>Site: </b><?=$company->website != "" ? "<a href=\"https://<?=$company->website?>\">$company->website</a>" : ""?></p>
        <p><b>Telefone: </b><?=$company->phone?></p>
        <p><b>Cadastro no SmallVisor: </b><?=$this->string->dateTimeToString($company->createDate)?></p>
        <p><b>Última Atualização: </b><?=$this->string->dateTimeToString($company->updateDate)?></p>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4">
        
        <!-- CHECK ADMIN -->
        <?php if($user->admin) { ?>

        <a class="btn btn-primary btn-lg btn-block margin-bottom-10" href="updateCompanyInfo">Alterar Dados</a>
        <a class="btn btn-success btn-lg btn-block margin-bottom-10" href="updateCompanyAddress">Alterar Endereço</a>

        <? } ?><!-- CHECK ADMIN -->

    </div>
</div>

<!-- Checks if user is not a client -->
<?php if($user->notClient) { ?>

<div class="row margin-bottom-30">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-users"></i> Equipes</h1>
    </div>
    <div class="col-md-12 margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Criação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($company->teams) > 0) {
                        $i = 1;
                        foreach($company->teams as $team) { ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><a href="team?id=<?=$team->id?>"><?=$team->name?></a></td>
                                <td><?=substr($team->description,0,40)?><?=strlen($team->description)>40?'...':''?></td>
                                <td><?=$this->string->dateTimeToString($team->createDate)?></td>
                            </tr>
                        <?php }
                    } else { 
                        echo "<tr><td colspan=4 class='text-align-center'>Não há equipes na sua empresa.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col-md-12 -->

    <!-- CHECK ADMIN OR EDITOR -->
    <?php if($user->adminEditor) { ?>

    <div class="col-md-12 display-flex margin-bottom-50">
        <a class="col-md-3 margin-auto btn btn-lg btn-primary" href="createTeam?companyId=<?=$company->id?>">Criar Equipe</a>
    </div>
    <!-- /.col-md-12 -->

    <? } ?> <!-- CHECK ADMIN OR EDITOR -->

</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-users"></i> Usuários</h1>
    </div>

    

    <div class="col-md-12 margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Usuário</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">E-mail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($company->users > 0)) {
                        $i = 1;
                        foreach($company->users as $companyUser) { ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><a href="user?id=<?=$companyUser->id?>"><?=$companyUser->username?></a></td>
                                <td><?=$companyUser->name?></td>
                                <td><?=$companyUser->profile?></td>
                                <td><?=$companyUser->email?></td>
                            </tr>
                        <?php }
                    } else {
                        echo '<td colspan="5" class="text-align-center">Não há usuários na sua empresa.</td>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col-md-12 -->

    <!-- CHECK ADMIN OR EDITOR -->
    <?php if($user->adminEditor) { ?>    

    <div class="col-md-12 display-flex margin-bottom-50">
        <a class="col-md-3 margin-auto btn btn-lg btn-primary" href="createUser?companyId=<?=$company->id?>">Cadastrar Usuário</a>
    </div>
    <!-- /.col-md-12 -->

    <? } ?>

</div>
<!-- /.row -->

<? } ?> <!-- Checks if user is not a client -->