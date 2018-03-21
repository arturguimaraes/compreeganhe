<div class="row margin-bottom-30">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-users"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->
    <div class="col-md-12">
        <p><b>Nome: </b><?=$team->name?></p>
        <p><b>Líder:</b> <a href="user?id=<?=$team->liderUser->id?>"><?=$team->liderUser->name?> (<?=$team->liderUser->username?>)</a></p>
        <p><b>Descrição: </b><?=$team->description?></p>
        <p><b>Criação: </b><?=$this->string->dateTimeToString($team->createDate)?></p>
    </div>
    <!-- /.col-md-12 -->
</div>

<div class="row margin-bottom-30">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-users"></i> Integrantes</h1>
    </div>
    <div class="col-md-12">
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
                    <?php if(count($users > 0)) {
                        $i = 1;
                        foreach($users as $userTeam) { ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><a href="user?id=<?=$userTeam->id?>"><?=$userTeam->username?></a></td>
                                <td><?=$userTeam->name?></td>
                                <td><?=$userTeam->profile?></td>
                                <td><?=$userTeam->email?></td>
                            </tr>
                        <?php }
                    } else {
                        echo '<td colspan="5" class="text-align-center">Não há usuários nesta equipe.</td>';
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
            <a class="col-md-3 margin-auto btn btn-lg btn-primary" href="addUser?teamId=<?=$_GET['id']?>">Adicionar Integrante</a>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
<? } ?>