<script>
  function edit() {
    $("#edit-title").html("<i class=\"fa fa-folder-open\"></i> <input type=\"text\" id=\"edit\" class=\"form-control name-edit-input\" placeholder=\"Digite o novo nome\"> <i class=\"fa fa-check text-green\" onclick=\"finishEdit();\"></i>");
  }

  function finishEdit() {
    var edit = $("#edit").val();
    if(edit == "") {
      alert("Escreva algum nome");
      return;
    }
    $("#edit-title").addClass("hidden");
    $(".edit-loader").removeClass("hidden");
    $.ajax({
      method: "POST",
      url: "editTaskGroupName",
      data: { taskGroupId: <?=$taskGroup->id?>,
              edit: edit,
              token: "small2018Vis",
              submit: true
            }
    }).done(function(responseJson) {
      //Hides loader container
      $('.edit-loader').addClass('hidden');
      //Shows class status container
      $('#edit-title').removeClass('hidden');
      var response = JSON.parse(responseJson);
      //Error
      if(response.errors.length != 0)
        console.log(response.errors);
      else
        console.log(response.response[0]);
    });
    $("#edit-title").html("<i class=\"fa fa-folder-open\"></i> " + edit + " <i class=\"fa fa-edit text-20 text-gray\" onclick=\"edit();\"></i>");
  }
</script>

<div class="row margin-bottom-30">
    
    <?php if($user->adminEditor) { ?>

    <div class="col-md-12">
        <div class="edit-loader hidden"></div>
        <h1 class="page-header" id="edit-title"><i class="fa fa-folder-open"></i> <?=$page['title']?> <i class="fa fa-edit text-20 text-gray" onclick="edit();"></i></h1> 
    </div>
    <!-- /.col-md-12 -->

    <?php } else { ?>

      <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-folder-open"></i> <?=$page['title']?></h1> 
      </div>
      <!-- /.col-md-12 -->

    <? } ?> <!-- CHECK ADMIN OR EDITOR --> 
    
    <div class="col-md-4">
        <p><b>Nome do Grupo:</b> <?=$taskGroup->name?></p>
        <p><b>Projeto:</b> <a href="project?id=<?=$project->id?>"><?=$project->code?> - <?=$project->title?></a></p>
        <p><b>Cliente:</b> <i class="fa fa-user" style="color:#<?=$client->color?>"></i> <a href="client?id=<?=$client->id?>"><?=$client->code?> - <?=$client->name?></a></p>
        <p><b>Responsável:</b> <a href="user?id=<?=$taskGroup->responsibleUser->id?>"><?=$taskGroup->responsibleUser->name?> (<?=$taskGroup->responsibleUser->username?>)</a></p>
        <p><b>Data de Criação:</b> <?=$this->string->dateTimeToString($taskGroup->createDate)?></p>
        <p><b>Última Atualização:</b> <?=$taskGroup->updateDate != NULL ? $this->string->dateTimeToString($taskGroup->updateDate) : ""?></p>
    </div>
    <!-- /.col-md-4 -->
    
    <div class="col-md-4" style="max-height:250px;overflow-y:auto;">
    	<p><b>Descrição:</b><br><?=$taskGroup->description?></p>
    </div>
    <!-- /.col-md-4 -->

    <!-- CHECK ADMIN OR EDITOR -->
    <?php if($user->adminEditor) { ?> 

    <div class="col-md-4">
        <div class="loader hidden"></div>
        <div class="task-status">
            <a class="btn btn-success btn-lg btn-block margin-bottom-10" href="createTask?projectId=<?=$project->id?>&taskGroupId=<?=$taskGroup->id?>">Criar uma Tarefa</a>
            
            <?php if(count($tasks) > 0) { ?>
                <!-- DELIVER MODAL -->
                <button type="button" class="btn btn-primary btn-lg btn-block margin-bottom-10" onclick="showAssign();">Atribuir Todas as Tarefas</button>
            <? } ?>

        </div>
    </div>
    <!-- /.col-md-4 -->

    <? } ?> <!-- CHECK ADMIN OR EDITOR --> 

</div>
<!-- /.row -->

<div class="row margin-bottom-30">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-pencil"></i> Tarefas Neste Grupo
          <a data-toggle="collapse" href="#collapseTasks" role="button" aria-expanded="false" aria-controls="collapseTasks" onclick="changeIcon('Tasks');">
            <i id="iconTasks" class="fa fa-caret-right"></i>
          </a>
        </h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="collapse" id="collapseTasks">
      <div class="card card-body">
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
                        echo "<tr><td colspan=10 class='text-align-center'>Não há tarefas para este grupo de tarefas.</td></tr>";
                    } ?>
                  </tbody>
                </table>
            </div>
        </div>
        <!-- /.col-md-12 -->
      </div>
      <!-- /.card .card-body -->
    </div>
    <!-- /.collapse -->

</div>
<!-- /.row -->

<!-- CHECK ADMIN OR EDITOR -->
<?php if ($user->adminEditor) { ?>

<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><span class="glyphicon glyphicon-list-alt"></span> Logs
          <a data-toggle="collapse" href="#collapseLogs" role="button" aria-expanded="false" aria-controls="collapseLogs" onclick="changeIcon('Logs');">
            <i id="iconLogs" class="fa fa-caret-right"></i>
          </a>
        </h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="collapse" id="collapseLogs">
      <div class="card card-body">
        <div class="col-md-12" style="max-height:400px;overflow-y:auto;">
            <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th scope="col" class="col-md-2">Data</th>
                        <th scope="col" class="col-md-10">Descrição</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($logs) > 0) {
                        foreach($logs as $log) { ?>
                            <tr>
                                <td><?=$this->string->dateTimeToString($log->createDate)?></td>
                                <td><?=$log->changeDescription?></td>
                            </tr>
                        <?php }
                    } else { 
                        echo "<tr><td colspan=2 class='text-align-center'>Não há logs para este grupo de tarefas.</td></tr>";
                    } ?>
                  </tbody>
                </table>
            </div>
        </div>
        <!-- /.col-md-12 -->
      </div>
      <!-- /.card .card-body -->
    </div>
    <!-- /.collapse -->

</div>
<!-- /.row -->

<!-- ASSIGN MODAL SCRIPT -->
<script>
  function showAssign() {
    //Clears error div
    $('#assignModalError1').empty();
    $('#assignModalError2').empty();
    ///Shows modal
    $('#assignModal').modal('toggle');
  }

  function closeAssign() {
    //Hides modal
    $('#assignModal').modal('hide');
  }

  function changeAssign(form) {
    var error = true;
    //If changes user
    if(form == 1) {
      var changeType = "user";
      //Gets submitted values
      var responsibleUserId = $('#responsibleUserId').val();
      var teamId = "";
      var lider = "";
      //Tests if anything was submitted
      if(responsibleUserId == "")
        $('#assignModalError1').empty().append($('<p class="text-align-center italic text-red">Você não selecionou nada.</p>'));
      else
        error = false;
    }
    //If changes team
    else if(form == 2) {
      var changeType = "team";
      //Gets submitted values
      var responsibleUserId = "";
      var teamId = $('#teamId').val().split(";")[0];
      var lider = $('#teamId').val().split(";")[1];
      //Tests if anything was submitted
      if(teamId == "")
        $('#assignModalError2').empty().append($('<p class="text-align-center italic text-red">Você não selecionou nada.</p>'));
      else
        error = false;
    }
    //Sends ajaxs request to controller
    if(!error) {
      //Hides class status container
      $('.task-status').addClass('hidden');
      //Displays loader
      $('.loader').removeClass('hidden');
      //Hides modal
      $('#assignModal').modal('hide');
      $.ajax({
        method: "POST",
        url: "assignTaskGroup",
        data: { taskGroupId:        <?=$taskGroup->id?>,
                responsibleUserId:  responsibleUserId,
                teamId:             teamId,
                lider:              lider,
                changeType:         changeType,
                projectId:          <?=$project->id?>,
                token:              "small2018Vis", 
                submit:             true
              }
      }).done(function(responseJson) {
        //Hides loader container
        $('.loader').addClass('hidden');
        //Shows class status container
        $('.task-status').removeClass('hidden');
        var response = JSON.parse(responseJson);
        //Error
        if(response.errors.length != 0)
          console.log(response.errors);
        else
          console.log(response.response);
        window.location.href = "taskGroup?id=<?=$taskGroup->id?>";
      });
    }
  }

  function resetForm(form) {
    switch(form) {
      case 1:
        $("#responsibleUserId").val("");
        break;
      case 2:
        $("#teamId").val("");
        break;
    }
  }
</script>
<!-- ASSIGN MODAL SCRIPT -->

<!-- ASSIGN MODAL -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="Atualizar Tarefa" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-pencil"></i> <?="$task->code<br>$task->title"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeAssign(1);">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs margin-bottom-20">
            <li class="active"><a href="#user" class="task-tab" data-toggle="tab">Atribuir a Usuário</a></li>
            <li class=""><a href="#team" class="task-tab" data-toggle="tab">Atribuir a Equipe</a></li>
        </ul>
        <div class="tabbable">
          <div class="tab-content">
            <div class="tab-pane active" id="user">
              <form>
                <div class="form-group">
                  <label for="responsibleUserId">Atribuir Todas as Tarefas a</label>
                  <select class="form-control" id="responsibleUserId" name="responsibleUserId" onchange="resetForm(2);">
                    <option value="">Selecionar Usuário</option>
                    <?php foreach($users as $companyUser) { ?>
                      <option value="<?=$companyUser->id?>"><?=$companyUser->name?> (<?=$companyUser->username?>)</option>
                    <? } ?>
                  </select>
                </div>
                <div class="form-group">
                    <a class="display-block text-align-center" href="createUser?companyId=<?=$user->companyId?>&redirect=taskGroup&redirectName=id&redirectValue=<?=$taskGroup->id?>">Cadastrar Novo Usuário</a>
                </div>
              </form>
              <div id="assignModalError1"></div>
              <div class="modal-footer text-align-center">
                <button type="button" class="btn btn-primary btn-lg" onclick="changeAssign(1);">Atribuir</button>
              </div>
            </div>
            <div class="tab-pane" id="team">
              <form>
                <div class="form-group">
                  <label for="teamId">Atribuir Todas as Tarefas a</label>
                  <select class="form-control" id="teamId" name="teamId" onchange="resetForm(1);">
                    <option value="">Selecionar Equipe</option>
                    <?php foreach($teams as $team) { ?>
                      <option value="<?=$team->id?>;<?=$team->lider?>"><?=$team->name?></option>
                    <? } ?>
                  </select>
                </div>
              </form>
              <div id="assignModalError2"></div>
              <div class="modal-footer text-align-center">
                <button type="button" class="btn btn-primary btn-lg" onclick="changeAssign(2);">Atribuir</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /. ASSIGN MODAL -->

<? } ?><!-- CHECK ADMIN OR EDITOR -->