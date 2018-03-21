<div class="row margin-bottom-30">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-users"></i> <?=$page['title']?></h1>
    </div>
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Líder</th>
                        <th scope="col">Criação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($company['teams']) > 0) {
                        $i = 1;
                        foreach($company['teams'] as $team) { ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><a href="team?id=<?=$team->id?>"><?=$team->name?></a></td>
                                <td><?=substr($team->description,0,40)?><?=strlen($team->description)>40?'...':''?></td>
                                <td><a href="user?id=<?=$team->liderUser->id?>"><?=$team->liderUser->name?></a></td>
                                <td><?=$this->string->dateTimeToString($team->createDate)?></td>
                            </tr>
                        <?php }
                    } else { 
                        echo "<tr><td colspan=5 class='text-align-center'>Não há equipes na sua empresa.</td></tr>";
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
            <a class="col-md-3 margin-auto btn btn-lg btn-primary" href="createTeam?companyId=<?=$company['info']->id?>">Criar Equipe</a>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
<? } ?>