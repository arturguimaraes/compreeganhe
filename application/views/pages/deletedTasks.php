<!-- CHECK ADMIN OR EDITOR -->
<?php if ($user->adminEditor) { ?>

<div class="row  margin-bottom-30">

    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-pencil"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="col-md-12" style="max-height:400px;overflow-y:auto;">
        <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                    <th scope="col">Código</th>    
                    <th scope="col">Título</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-align-center">Progresso</th>
                    <th scope="col" class="text-align-center">Completa</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Responsável</th>
                    <th scope="col">Criação</th>
                    <th scope="col">Entrega</th>
                    <th scope="col">Finalização</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($tasks) > 0) {
                    foreach($tasks as $task) { ?>
                        <tr>
                            <td><?=$task->code?></td>
                            <td><a href="task?id=<?=$task->id?>"><?=$this->string->getStringMax($task->title,20)?></a></td>
                            <td><?=$task->status?></td>
                            <td class="text-align-center"><?=$task->progress?>%</td>
                            <td class="text-align-center"><i class="fa fa-<?=$task->done ? 'check text-green' : 'times text-red'?>"></i></td>
                            <td><?=$this->string->getStringMax($task->description,40)?></td>
                            <td><a href="user?id=<?=$task->responsibleUser->id?>"><?=explode(' ',trim($task->responsibleUser->name))[0]?></a></td>
                            <td><?=$this->string->dateTimeToString($task->createDate)?></td>
                            <td><?=$this->string->dateTimeToString($task->deliverDate)?></td>
                            <td><?=$task->finishDate == NULL ? "" : $this->string->dateTimeToString($task->finishDate)?></td>
                        </tr>
                    <?php }
                } else { 
                    echo "<tr><td colspan=10 class='text-align-center'>Não há tarefas para este projeto.</td></tr>";
                } ?>
              </tbody>
            </table>
        </div>
    </div>
    <!-- /.col-md-12 -->

    <div class="col-md-12 margin-top-20">
        <a href="project?id=<?=$_GET['projectId']?>" class="btn btn-warning btn-lg">Voltar ao Projeto</a>
    </div>
    <!-- /.col-md-12 -->

</div>
<!-- /.row -->

<? } ?> <!-- CHECK ADMIN OR EDITOR -->