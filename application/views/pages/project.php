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
      url: "editProjectName",
      data: { projectId: <?=$project->id?>,
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
    $("#edit-title").html("<i class=\"fa fa-folder-open\"></i> <?=$project->code?>: " + edit + " <i class=\"fa fa-edit text-20 text-gray\" onclick=\"edit();\"></i>");
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
    
    <div class="col-md-4" style="max-height:250px;overflow-y:auto;">
        <p><b>Código:</b> <?=$project->code?></p>
        <p><b>Cliente:</b> <i class="fa fa-user" style="color:#<?=$client->color?>"></i> <a href="client?id=<?=$client->id?>"><?=$client->code?> - <?=$client->name?></a></p>
        <p><b>Título:</b> <?=$project->title?></p>
        <p><b>Descrição:</b><br><?=$project->briefing?></p>
    </div>
    <!-- /.col-md-4 -->
    
    <div class="col-md-4">
    	<p><b>Status:</b> <?=$project->status?></p>
        <p><b>Criação:</b> <?=$this->string->dateTimeToString($project->createDate)?></p>
        <p><b>Última Atualização:</b> <?=$project->updateDate != NULL ? $this->string->dateTimeToString($project->updateDate) : ""?></p>
        <p><b>Entrega:</b> <?=$this->string->dateTimeToString($project->deliverDate)?></p>
    </div>
    <!-- /.col-md-4 -->

    <!-- CHECK ADMIN OR EDITOR -->
    <?php if($user->adminEditor) { ?> 

    <div class="col-md-4">
        <div class="loader hidden"></div>
        <div class="project-buttons">
            <a class="btn btn-primary btn-lg btn-block margin-bottom-10" href="createTaskGroup?projectId=<?=$project->id?>">Criar um Grupo de Tarefas</a>
            <a class="btn btn-success btn-lg btn-block margin-bottom-10" href="createTask?projectId=<?=$project->id?>">Criar uma Tarefa</a>
            <!-- UPDATE MODAL -->
            <button type="button" class="btn btn-warning btn-lg btn-block margin-bottom-10" onclick="showStatus();">Atualizar Status</button>
            <!-- DELIVER MODAL -->
            <button type="button" class="btn btn-danger btn-lg btn-block margin-bottom-10" onclick="showDeliver();">Atualizar Data de Entrega</button>
        </div>
    </div>
    <!-- /.col-md-4 -->

    <? } ?> <!-- CHECK ADMIN OR EDITOR -->

</div>
<!-- /.row -->

<div class="row margin-bottom-30">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-pencil"></i> Grupos de Tarefas
          <a data-toggle="collapse" href="#collapseTaskGroup" role="button" aria-expanded="false" aria-controls="collapseTaskGroup" onclick="changeIcon('TaskGroup');">
            <i id="iconTaskGroup" class="fa fa-caret-right"></i>
          </a>
        </h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="collapse" id="collapseTaskGroup">
      <div class="card card-body">
        <div class="col-md-12" style="max-height:400px;overflow-y:auto;">
            <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Responsável</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($taskGroups) > 0) {
                        foreach($taskGroups as $taskGroup) { ?>
                            <tr>
                                <td><a href="taskGroup?id=<?=$taskGroup->id?>"><?=$taskGroup->name?></a></td>
                                <td><?=$taskGroup->description?></td>
                                <td><a href="user?id=<?=$taskGroup->responsibleUser->id?>"><?=$taskGroup->responsibleUser->name?></a></td>
                            </tr>
                        <?php }
                    } else { 
                        echo "<tr><td colspan=3 class='text-align-center'>Não há grupos de tarefas para este projeto.</td></tr>";
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

<div class="row  margin-bottom-30">
    
    <div class="col-md-12">
    	<div class="float-right">
        	<a href="deletedTasks?projectId=<?=$_GET['id']?>">Tarefas Arquivadas</a>
        </div>
        <h1 class="page-header"><i class="fa fa-pencil"></i> Todas as Tarefas
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
                        echo "<tr><td colspan=10 class='text-align-center'>Não há tarefas para este projeto.</td></tr>";
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
                        echo "<tr><td colspan=2 class='text-align-center'>Não há logs para este projeto.</td></tr>";
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

<? } ?><!-- CHECK ADMIN OR EDITOR -->

<!-- CHECK ADMIN OR EDITOR -->
<?php if ($user->adminEditor) { ?>

<!-- STATUS MODAL SCRIPT -->
<script>
  function showStatus() {
    //Clears error div
    $('#statusModalError').empty();
    ///Shows modal
    $('#statusModal').modal('toggle');
  }

  function closeStatus() {
    //Hides modal
    $('#statusModal').modal('hide');
  }

  function changeStatus() {
    //Gets submitted values
    var status = $('#status').val();
    //Tests if anything has changed
    if(status == '<?=$project->status?>')
      $('#statusModalError').empty().append($('<p class="text-align-center italic text-red">Você não modificou nada</p>'));
    //Sends ajaxs request to controller
    else {
      //Hides class status container
      $('.project-buttons').addClass('hidden');
      //Displays loader
      $('.loader').removeClass('hidden');
      //Hides modal
      $('#statusModal').modal('hide');
      $.ajax({
        method: "POST",
        url: "updateProjectStatus",
        data: { projectId: <?=$project->id?>,
                status: status, 
                token: "small2018Vis",
                submit: true
              }
      }).done(function(responseJson) {
        //Hides loader container
        $('.loader').addClass('hidden');
        //Shows class status container
        $('.project-buttons').removeClass('hidden');
        var response = JSON.parse(responseJson);
        //Error
        if(response.errors.length != 0)
          console.log(response.errors);
        else
          console.log(response.response);
        window.location.href = "project?id=<?=$project->id?>";
      });
    }
  }
</script>

<!-- STATUS MODAL -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="Atualizar Projeto" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-folder-open"></i> <?="$project->code<br>$project->title"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeStatus();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
              <option <?=$project->status == 'Planejamento' ? 'selected' : '' ?>>Planejamento</option>
              <option <?=$project->status == 'Implementação' ? 'selected' : '' ?>>Implementação</option>
              <option <?=$project->status == 'Testes' ? 'selected' : '' ?>>Testes</option>
              <option <?=$project->status == 'Homologação' ? 'selected' : '' ?>>Homologação</option>
              <option <?=$project->status == 'Finalizado' ? 'selected' : '' ?>>Finalizado</option>
            </select>
          </div>
        </form>
        <div id="statusModalError"></div>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-danger btn-lg" onclick="changeStatus();">Mudar Status</button>
      </div>
    </div>
  </div>
</div>
<!-- /. STATUS MODAL -->

<!-- DELIVER MODAL SCRIPT -->
<script>
  function showDeliver() {
    //Clears error div
    $('#deliverModalError').empty();
    ///Shows modal
    $('#deliverModal').modal('toggle');
  }

  function closeDeliver() {
    //Hides modal
    $('#deliverModal').modal('hide');
  }

  function changeDeliver() {
    //Gets submitted values
    var deliverDate = $('#deliverDate').val();
    //Gets project deliver date and converts to form's type
    var projectDeliverDate = "<?=$project->deliverDate?>";
    projectDeliverDate = projectDeliverDate.replace(' ','T').substring(0,projectDeliverDate.length-3);
    //Tests if anything has changed
    if(deliverDate == projectDeliverDate)
      $('#deliverModalError').empty().append($('<p class="text-align-center italic text-red">Escolha uma data diferente da atual</p>'));
    //Tests if date is in the future
    else if(new Date(deliverDate.replace('T',' ')).getTime() <= new Date().getTime())
      $('#deliverModalError').empty().append($('<p class="text-align-center italic text-red">Escolha uma data no futuro</p>'));
    //Check if date is valid
	else if(!isValidDate(deliverDate))
	  $('#deliverModalError').empty().append($('<p class="text-align-center italic text-red">A data escolhida não é válida.</p>'));
	//Sends ajaxs request to controller
    else {
      //Hides class status container
      $('.project-buttons').addClass('hidden');
      //Displays loader
      $('.loader').removeClass('hidden');
      ///Hides modal
      $('#deliverModal').modal('hide');
      $.ajax({
        method: "POST",
        url: "changeDeliverProject",
        data: { projectId: <?=$project->id?>,
                deliverDate: deliverDate,
                token:              "small2018Vis",
                submit: true
              }
      }).done(function(responseJson) {
        //Hides loader container
        $('.loader').addClass('hidden');
        //Shows class status container
        $('.project-buttons').removeClass('hidden');
        var response = JSON.parse(responseJson);
        //Error
        if(response.errors.length != 0)
          console.log(response.errors);
        else
          console.log(response.response);
        window.location.href = "project?id=<?=$project->id?>";
      });
    }
  }
  
  function isValidDate(dateNotFormatted) {
	  	var year = dateNotFormatted.substring(0, 4);
		var month = dateNotFormatted.substring(5, 7);
		var day = dateNotFormatted.substring(8, 10);
		var s = day + "/" + month + "/" + year;
		// format D(D)/M(M)/(YY)YY
		var dateFormat = /^\d{1,4}[\.|\/|-]\d{1,2}[\.|\/|-]\d{1,4}$/;
	
		if (dateFormat.test(s)) {
			// remove any leading zeros from date values
			s = s.replace(/0*(\d*)/gi,"$1");
			var dateArray = s.split(/[\.|\/|-]/);
		  
				  // correct month value
			dateArray[1] = dateArray[1]-1;
	
			// correct year value
			if (dateArray[2].length<4) {
				// correct year value
				dateArray[2] = (parseInt(dateArray[2]) < 50) ? 2000 + parseInt(dateArray[2]) : 1900 + parseInt(dateArray[2]);
			}
	
			var testDate = new Date(dateArray[2], dateArray[1], dateArray[0]);
			if (testDate.getDate()!=dateArray[0] || testDate.getMonth()!=dateArray[1] || testDate.getFullYear()!=dateArray[2]) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
</script>

<!-- DELIVER MODAL -->
<div class="modal fade" id="deliverModal" tabindex="-1" role="dialog" aria-labelledby="Atualizar Projeto" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-folder-open"></i> <?="$project->code<br>$project->title"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeDeliver();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="deliverDate">Data de Entrega</label>
            <input id="deliverDate" name="deliverDate" class="form-control" type="datetime-local" min="<?=$this->string->dateTimeToFormString($now)?>" value="<?=$this->string->dateTimeToFormString($project->deliverDate)?>">
          </div>
        </form>
        <div id="deliverModalError"></div>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-danger btn-lg" onclick="changeDeliver();">Mudar Data de Entrega</button>
      </div>
    </div>
  </div>
</div>
<!-- /. DELIVER MODAL -->

<? } ?> <!-- CHECK ADMIN OR EDITOR -->