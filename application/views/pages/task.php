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
      url: "editTaskName",
      data: { taskId: <?=$task->id?>,
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
    $("#edit-title").html("<i class=\"fa fa-folder-open\"></i> <?=$task->code?>: " + edit + " <i class=\"fa fa-edit text-20 text-gray\" onclick=\"edit();\"></i>");
  }

  function comment() {
    var comment = $("#comment").val();
    if(comment == "") {
      alert("Escreva algo no comentário");
      return;
    }
    $("#comment-container").addClass("hidden");
    $(".comment-loader").removeClass("hidden");
    $.ajax({
      method: "POST",
      url: "comment",
      data: { taskId: <?=$task->id?>,
              comment: comment,
              authorId: <?=$user->id?>,
              authorName: "<?=$user->name?>",
              token: "small2018Vis",
              submit: true
            }
    }).done(function(responseJson) {
      //Hides loader container
      $('.comment-loader').addClass('hidden');
      //Shows class status container
      $('#comment-title').removeClass('hidden');
      var response = JSON.parse(responseJson);
      //Error
      if(response.errors.length != 0)
        console.log(response.errors);
      else
        console.log(response.response[0]);
      window.location.href = "task?id=<?=$task->id?>";
    });
  }
</script>

<style>
  .btn-block+.btn-block {
    margin-top:0;
  }
</style>

<div class="row margin-bottom-30">
    
    <?php if($user->adminEditor) { ?>

    <div class="col-md-12">
        <div class="edit-loader hidden"></div>
        <h1 class="page-header" id="edit-title"><i class="fa fa-folder-open"></i> <?=$page['title']?> <?=$task->deleted ? "<span class=\"text-red\">(ARQUIVADA)</span>" : ""?> <i class="fa fa-edit text-20 text-gray" onclick="edit();"></i></h1> 
    </div>
    <!-- /.col-md-12 -->

    <?php } else { ?>

      <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-folder-open"></i> <?=$page['title']?> <?=$task->deleted ? "<span class=\"text-red\">(ARQUIVADA)</span>" : ""?></h1> 
      </div>
      <!-- /.col-md-12 -->

    <? } ?> <!-- CHECK ADMIN OR EDITOR --> 


    <div class="col-md-4 task-detail">
        <p><b>Tarefa:</b> <?=$task->code?></p>
        <?php if ($taskGroup != NULL) { ?>
            <p><b>Grupo de Tarefas:</b> <a href="taskGroup?id=<?=$taskGroup->id?>"><?=$taskGroup->name?></a></p>
        <? } ?>
        <p><b>Projeto:</b> <a href="project?id=<?=$project->id?>"><?=$project->code?> - <?=$project->title?></a></p>
        <p><b>Cliente:</b> <i class="fa fa-user" style="color:#<?=$client->color?>"></i> <a href="client?id=<?=$client->id?>"><?=$client->code?> - <?=$client->name?></a></p>
        <p><b>Título:</b> <?=$task->title?></p>
        <p><b>Responsável:</b> <a href="user?id=<?=$task->responsibleUser->id?>"><?=$task->responsibleUser->name?> (<?=$task->responsibleUser->username?>)</a></p>
        <p><b>Criação:</b> <?=$this->string->dateTimeToString($task->createDate)?></p>
        <p><b>Última Atualização:</b> <?=$task->updateDate == NULL ? "" : $this->string->dateTimeToString($task->updateDate)?></p>
        <p><b>Finalização:</b> <?=$task->finishDate == NULL ? "" : $this->string->dateTimeToString($task->finishDate)?></p>
        <p>
          <b>Entrega:</b> <?=$this->string->dateTimeToString($task->deliverDate)?>
          <?=$task->late ? "<span class=\"badge badge-danger\">Atrasada</span>" : ""?>
          <?=$task->done ? "<span class=\"badge badge-success\">Completa</span>" : ""?>
          <?=($task->due && !$task->done) ? "<span class=\"badge badge-warning\">Entrega próxima</span>" : ""?>
        </p>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4 task-detail">
      <div class="loader hidden"></div>
      <div class="task-status">
          <p><b>Completa:</b> <i class="fa fa-<?=$task->done ? 'check text-green' : 'times text-red'?>"></i></p>
          <p><b>Status:</b> <?=$task->status?></p>
          <p><b>Progresso:</b> <?=$task->progress?> %</p>
          <div class="progress progress-striped active">
              <div class="progress-bar <?=$task->class?>" role="progressbar" aria-valuenow="<?=$task->progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$task->progress?>%">
                  <span class="sr-only"><?=$task->progress?>% <?=$task->color?></span>
              </div>
          </div>

          <!-- CHECK USER CAN CHANGE -->
          <?php if($user->canChange) { ?> 

          <div class="display-flex margin-bottom-20">
              <!-- ASSIGN MODAL -->
              <button type="button" class="btn btn-primary btn-lg btn-block margin-auto-horizontal margin-right-10" onclick="showAssign();">Atribuir</button>
              <!-- UPDATE MODAL -->
              <button type="button" class="btn btn-success btn-lg btn-block margin-auto-horizontal margin-left-10" onclick="showUpdate();">Atualizar</button>
          </div>

          <? } ?> <!-- CHECK USER CAN CHANGE -->

          <!-- CHECK ADMIN OR EDITOR -->
          <?php if($user->adminEditor) { ?> 

          <!-- DESKTOP ONLY -->
          <div class="display-flex margin-bottom-20 desktop-only">
              <!-- DELIVER MODAL -->
              <button type="button" class="btn btn-warning btn-lg btn-block margin-auto-horizontal margin-right-20" onclick="showDeliver();">Mudar Entrega</button>
              
              <?php if (!$task->deleted) { ?>
                  <!-- DELETE MODAL -->
                  <button type="button" class="btn btn-info btn-lg btn-block margin-auto-horizontal" onclick="showDelete();">Arquivar</button>
              <?php } else { ?>
                  <!-- RECOVER MODAL -->
                  <button type="button" class="btn btn-info btn-lg btn-block margin-auto-horizontal" onclick="showRecover();">Recuperar</button>
              <? } ?>

              <!-- PERMANENT DELETE MODAL -->
              <button type="button" class="btn btn-danger btn-lg btn-block margin-auto-horizontal margin-left-20" onclick="showPermanentDelete();">Excluir</button>

          </div>

          <!-- MOBILE ONLY -->
          <div class="display-flex margin-bottom-20 mobile-only">
              <!-- DELIVER MODAL -->
              <button type="button" class="btn btn-warning btn-lg btn-block margin-auto-horizontal margin-right-10" onclick="showDeliver();">Mudar Entrega</button>
              
              <?php if (!$task->deleted) { ?>
                  <!-- DELETE MODAL -->
                  <button type="button" class="btn btn-info btn-lg btn-block margin-auto-horizontal margin-left-10" onclick="showDelete();">Arquivar</button>
              <?php } else { ?>
                  <!-- RECOVER MODAL -->
                  <button type="button" class="btn btn-info btn-lg btn-block margin-auto-horizontal margin-left-10" onclick="showRecover();">Recuperar</button>
              <? } ?>

          </div>

          <div class="display-flex margin-bottom-20 mobile-only">
              <!-- PERMANENT DELETE MODAL -->
              <button type="button" class="btn btn-danger btn-lg btn-block margin-auto-horizontal" onclick="showPermanentDelete();">Excluir Tarefa</button>
          </div>

          <div class="display-flex margin-bottom-20">
              
          </div>

          <? } ?> <!-- CHECK ADMIN OR EDITOR -->

      </div>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4 task-detail task-detail-scroll">
        <p><b>Descrição:</b><br><?=$this->string->getStringWithLineBreakers($task->description)?></p>
    </div>
    <!-- /.col-md-4 -->
</div>
<!-- /.row -->

<div class="row margin-bottom-30">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-commenting"></i> Comentários
          <a data-toggle="collapse" href="#collapseComments" role="button" aria-expanded="false" aria-controls="collapseComments" onclick="changeIcon('Comments');">
            <i id="iconComments" class="fa fa-caret-right"></i>
          </a>
        </h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="collapse" id="collapseComments">
      <div class="card card-body">
        <div class="collapseCommentsContainer col-md-12">
          <?php if(count($comments) > 0) {
            foreach($comments as $comment) { ?>
              <div class="alert alert-success" role="alert">
                <p><b><i class="fa fa-comment"></i> <?=$comment->authorName?></b> comentou em <?=$this->string->dateTimeToString($comment->createDate)?>:</p>
                <p>"<?=$comment->comment?>"</p>
              </div>
            <?php } 
          } else { ?>
            <div class="alert alert-info" role="alert">
              <p>Ainda não há comentários para esta tarefa</p>
            </div>
          <? } ?>
        </div>
        <!-- /.col-md-12 -->

        <div class="col-md-12 form-group">
          <div class="loader comment-loader hidden"></div>
          <div id="comment-container">
            <label for="comment">Adicione seu comentário:</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" cols="50" placeholder="Digite seu comentário (máximo de 2000 caracteres)"></textarea>
          </div>
        </div>
        <!-- /.col-md-12 -->
        
        <div class="col-md-3 form-group">
          <button class="btn btn-lg btn-block btn-info" onclick="comment();">Comentar</button>
        </div>
        <!-- /.col-md-3 -->

      </div>
      <!-- /.card .card-body -->
    </div>
    <!-- /.collapse -->

</div>
<!-- /.row -->

<!-- CHECK USER CAN CHANGE -->
<?php if($user->canChange) { ?> 

<div class="row margin-bottom-30">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-file"></i> Anexos
          <a data-toggle="collapse" href="#collapseAttachments" role="button" aria-expanded="false" aria-controls="collapseAttachments" onclick="changeIcon('Attachments');">
            <i id="iconAttachments" class="fa fa-caret-right"></i>
          </a>
        </h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="collapse" id="collapseAttachments">
      <div class="card card-body">
        <div class="collapseAttachmentsContainer col-md-12">
          <?php if(count($attachments) > 0) {
            foreach($attachments as $attachment) { ?>
              <div class="alert alert-warning" role="alert">
                <p><b><i class="fa fa-file"></i> <?=$attachment->authorName?></b> anexou um arquivo em <?=$this->string->dateTimeToString($attachment->createDate)?>:</p>
                <?php if($this->string->getFileType($attachment->filename) == '.jpg' ||
                       $this->string->getFileType($attachment->filename) == '.jpeg' ||
                       $this->string->getFileType($attachment->filename) == '.png' ||
                       $this->string->getFileType($attachment->filename) == '.gif') { ?>
                  <div class="attach-image-container margin-top-10 margin-bottom-10">
                    <img src="data:image/jpeg;base64,<?=base64_encode($attachment->file)?>" class="attach-image" alt="<?=$attachment->filename?>"/>
                  </div>
                <?php } else if($this->string->getFileType($attachment->filename) == '.pdf') { ?>
                  <div class="margin-top-10 margin-bottom-10">
                    <object data="data:application/pdf;base64,<?=base64_encode($attachment->file)?>" class="attach-pdf" type="application/pdf"></object>
                  </div>
                <? } ?>
                <p><a href="attachment?id=<?=$attachment->id?>"><?=$attachment->filename?></a></p>
              </div>
            <?php } 
          } else { ?>
            <div class="alert alert-info" role="alert">
              <p>Ainda não há arquivos anexados à esta tarefa</p>
            </div>
          <? } ?>
        </div>
        <!-- /.col-md-12 -->

        <form method="POST" enctype="multipart/form-data">
        
          <div class="col-md-12 form-group">
            <div class="loader file-loader hidden"></div>
            <div class="col-md-3 no-padding" id="file-container">
              <label for="file">Adicione seu anexo:</label>
              <input type="hidden" name="authorId" value="<?=$user->id?>">
              <input type="hidden" name="authorName" value="<?=$user->name?>">
              <input type="hidden" name="taskId" value="<?=$task->id?>">
              <input class="form-control" type="file" id="file" name="file">
            </div>
          </div>
          <!-- /.col-md-12 -->
          
          <div class="col-md-3 form-group">
            <input type="submit" id="submit" name="submit" class="btn btn-lg btn-block btn-info">
          </div>
          <!-- /.col-md-3 -->

        </form>

      </div>
      <!-- /.card .card-body -->
    </div>
    <!-- /.collapse -->

</div>
<!-- /.row -->

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
        <div class="collapseLogsContainer col-md-12">
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
                        echo "<tr><td colspan=2 class='text-align-center'>Não há logs para esta tarefa.</td></tr>";
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

<? } ?> <!-- CHECK USER CAN CHANGE -->

<!-- CHECK USER CAN CHANGE -->
<?php if ($user->canChange) { ?>

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
      //Tests if anything has changed
      else if(responsibleUserId == '<?=$task->responsibleUserId?>')
        $('#assignModalError1').empty().append($('<p class="text-align-center italic text-red">Você não modificou nada.</p>'));
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
      //Tests if anything has changed
      else if(lider == '<?=$task->responsibleUserId?>')
        $('#assignModalError2').empty().append($('<p class="text-align-center italic text-red">Tarefa atribuída ao líder do time selecionado.</p>'));
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
        url: "assignTask",
        data: { taskId:             <?=$task->id?>,
                responsibleUserId:  responsibleUserId,
                teamId:             teamId,
                lider:              lider,
                changeType:         changeType,
                projectId:          <?=$project->id?>,
                taskGroupId:        <?=$taskGroup != NULL ? $taskGroup->id : 0?>,
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
          console.log(response.response[0]);
        window.location.href = "task?id=<?=$task->id?>";
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
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="Atribuir Tarefa" aria-hidden="true">
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
                  <label for="responsibleUserId">Atribuir a</label>
                  <select class="form-control" id="responsibleUserId" name="responsibleUserId" onchange="resetForm(2);">
                    <option value="">Selecionar Usuário</option>
                    <?php foreach($users as $companyUser) { ?>
                      <option value="<?=$companyUser->id?>" <?=$task->responsibleUserId == $companyUser->id ? 'selected' : '' ?>><?=$companyUser->name?> (<?=$companyUser->username?>)</option>
                    <? } ?>
                  </select>
                </div>
                <div class="form-group">
                    <a class="display-block text-align-center" href="createUser?companyId=<?=$user->companyId?>&redirect=task&redirectName=id&redirectValue=<?=$task->id?>">Cadastrar Novo Usuário</a>
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
                  <label for="teamId">Atribuir a</label>
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

<!-- UPDATE MODAL SCRIPT -->
<script>
  function showUpdate() {
    //Clears error div
    $('#updateModalError').empty();
    ///Shows modal
    $('#updateModal').modal('toggle');
  }

  function closeUpdate() {
    //Hides modal
    $('#updateModal').modal('hide');
  }

  function changeUpdate() {
    //Gets submitted values
    var description = $('#description').val();
    var status = $('#status').val();
    var progress = $('#progress').val()
    var done = $('#done').prop('checked') ? '1' : '0';
    //Tests if anything has changed
    if(description == '<?=$task->description?>' && status == '<?=$task->status?>' && progress == '<?=$task->progress?>' && done == '<?=$task->done?>')
      $('#updateModalError').empty().append($('<p class="text-align-center italic text-red">Você não modificou nada</p>'));
    //Sends ajaxs request to controller
    else {
      //Hides class status container
      $('.task-status').addClass('hidden');
      //Displays loader
      $('.loader').removeClass('hidden');
      //Hides modal
      $('#updateModal').modal('hide');
      $.ajax({
        method: "POST",
        url: "updateTask",
        data: { taskId: <?=$task->id?>,
                description: description,
                status: status, 
                progress: progress,
                done: done,
                projectId: <?=$project->id?>,
                taskGroupId: <?=$taskGroup != NULL ? $taskGroup->id : 0?>,
                token:              "small2018Vis",
                submit: true
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
          console.log(response.response[0]);
        window.location.href = "task?id=<?=$task->id?>";
      });
    }
  }

  function markComplete(value) {
    if(value) {
      $("#status").val('Completa');
      $("#progress").val('100');
    }
  }
</script>
<!-- UPDATE MODAL SCRIPT -->

<!-- UPDATE MODAL -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="Atualizar Tarefa" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-pencil"></i> <?="$task->code<br>$task->title"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeUpdate();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="description">Descrição</label>
            <textarea id="description" name="description" cols="50" rows="5" class="form-control" placeholder="Máximo de caractéres: 5000" required><?=$task->description?></textarea>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
              <option <?=$task->status == 'Atribuída' ? 'selected' : '' ?>>Atribuída</option>
              <option <?=$task->status == 'Recebida' ? 'selected' : '' ?>>Recebida</option>
              <option <?=$task->status == 'Em Andamento' ? 'selected' : '' ?>>Em Andamento</option>
              <option <?=$task->status == 'Em Homologação' ? 'selected' : '' ?>>Em Homologação</option>
              <option <?=$task->status == 'Completa' ? 'selected' : '' ?>>Completa</option>
            </select>
          </div>
          <div class="form-group">
            <label for="progress">Progresso</label>
            <select class="form-control" id="progress" name="progress">
              <option value="0"   <?=$task->progress ==   0 ? 'selected' : '' ?>>0 %</option>
              <option value="10"  <?=$task->progress ==  10 ? 'selected' : '' ?>>10 %</option>
              <option value="20"  <?=$task->progress ==  20 ? 'selected' : '' ?>>20 %</option>
              <option value="30"  <?=$task->progress ==  30 ? 'selected' : '' ?>>30 %</option>
              <option value="40"  <?=$task->progress ==  40 ? 'selected' : '' ?>>40 %</option>
              <option value="50"  <?=$task->progress ==  50 ? 'selected' : '' ?>>50 %</option>
              <option value="60"  <?=$task->progress ==  60 ? 'selected' : '' ?>>60 %</option>
              <option value="70"  <?=$task->progress ==  70 ? 'selected' : '' ?>>70 %</option>
              <option value="80"  <?=$task->progress ==  80 ? 'selected' : '' ?>>80 %</option>
              <option value="90"  <?=$task->progress ==  90 ? 'selected' : '' ?>>90 %</option>
              <option value="100" <?=$task->progress == 100 ? 'selected' : '' ?>>100 %</option>
            </select>
          </div>
          <div class="form-group">
            <input type="checkbox" id="done" name="done" onclick="markComplete(this.checked);" <?=$task->done ? 'checked' : ''?>> <label for="done">Completa</label>
          </div>
        </form>
        <div id="updateModalError"></div>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-success btn-lg" onclick="changeUpdate();">Atualizar</button>
      </div>
    </div>
  </div>
</div>
<!-- /. UPDATE MODAL -->

<? } ?> <!-- CHECK USER CAN CHANGE -->

<!-- CHECK ADMIN OR EDITOR -->
<?php if ($user->adminEditor) { ?>

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
    //Gets task deliver date and converts to form's type
    var taskDeliverDate = "<?=$task->deliverDate?>";
    taskDeliverDate = taskDeliverDate.replace(' ','T').substring(0,taskDeliverDate.length-3);
    //Tests if anything has changed
    if(deliverDate == taskDeliverDate)
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
      $('.task-status').addClass('hidden');
      //Displays loader
      $('.loader').removeClass('hidden');
      ///Hides modal
      $('#deliverModal').modal('hide');
      $.ajax({
        method: "POST",
        url: "changeDeliverTask",
        data: { taskId: <?=$task->id?>,
                deliverDate: deliverDate,
                projectId: <?=$project->id?>,
                taskGroupId: <?=$taskGroup != NULL ? $taskGroup->id : 0?>,
                token:              "small2018Vis",
                submit: true
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
          console.log(response.response[0]);
        window.location.href = "task?id=<?=$task->id?>";
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
<div class="modal fade" id="deliverModal" tabindex="-1" role="dialog" aria-labelledby="Mudar Data de Entrega da Tarefa" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-pencil"></i> <?="$task->code<br>$task->title"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeDeliver();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="deliverDate">Data de Entrega</label>
            <input id="deliverDate" name="deliverDate" class="form-control" type="datetime-local" min="<?=$this->string->dateTimeToFormString($now)?>" value="<?=$this->string->dateTimeToFormString($task->deliverDate)?>">
          </div>
        </form>
        <div id="deliverModalError"></div>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-warning btn-lg" onclick="changeDeliver();">Mudar Entrega</button>
      </div>
    </div>
  </div>
</div>
<!-- /. DELIVER MODAL -->

<!-- DELETE MODAL SCRIPT -->
<script>
	function showDelete() {
		///Shows modal
		$('#deleteModal').modal('toggle');
	}

  	function closeDelete() {
    	//Hides modal
    	$('#deleteModal').modal('hide');
  	}

  	function changeDelete() {
		//Hides class status container
		$('.task-status').addClass('hidden');
		//Displays loader
		$('.loader').removeClass('hidden');
		///Hides modal
		$('#deleteModal').modal('hide');
		$.ajax({
			method: "POST",
			url: "deleteTask",
			data: { taskId: <?=$task->id?>,
					    projectId: <?=$project->id?>,
              taskGroupId: <?=$taskGroup != NULL ? $taskGroup->id : 0?>,
              token:              "small2018Vis",
              submit: true
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
				console.log(response.response[0]);
			window.location.href = "task?id=<?=$task->id?>";
		});
	}
</script>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Arquivar Tarefa" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-pencil"></i> <?="$task->code<br>$task->title"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeDelete();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p class="text-align-center">Por favor, confirme que deseja <b>arquivar</b> a tarefa:<br><br><b><?="$task->code<br>$task->title"?></b><br><br>Esta tarefa não ficará mais visível à usuários.</p>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-info btn-lg" onclick="changeDelete();">Arquivar Tarefa</button>
      </div>
    </div>
  </div>
</div>
<!-- /. DELETE MODAL -->

<!-- PERMANENT DELETE MODAL SCRIPT -->
<script>
  function showPermanentDelete() {
    ///Shows modal
    $('#permanentDeleteModal').modal('toggle');
  }

    function closePermanentDelete() {
      //Hides modal
      $('#permanentDeleteModal').modal('hide');
    }

    function changePermanentDelete() {
    //Hides class status container
    $('.task-status').addClass('hidden');
    //Displays loader
    $('.loader').removeClass('hidden');
    ///Hides modal
    $('#permanentDeleteModal').modal('hide');
    $.ajax({
      method: "POST",
      url: "permanentDeleteTask",
      data: { taskId: <?=$task->id?>,
              projectId: <?=$project->id?>,
              taskGroupId: <?=$taskGroup != NULL ? $taskGroup->id : 0?>,
              token: "small2018Vis",
              submit: true
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
        console.log(response.response[0]);
      window.location.href = "project?id=<?=$project->id?>";
    });
  }
</script>

<!-- PERMANENT DELETE MODAL -->
<div class="modal fade" id="permanentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="Excluir Tarefa" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-pencil"></i> <?="$task->code<br>$task->title"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closePermanentDelete();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-align-center">Por favor, confirme que deseja <b>excluir</b> a tarefa:<br><br><b><?="$task->code<br>$task->title"?></b><br><br>Esta ação não poderá ser desfeita.</p>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-danger btn-lg" onclick="changePermanentDelete();">Excluir Tarefa</button>
      </div>
    </div>
  </div>
</div>
<!-- /. PERMANENT DELETE MODAL -->

<!-- RECOVER MODAL SCRIPT -->
<script>
	function showRecover() {
		///Shows modal
		$('#recoverModal').modal('toggle');
	}

  	function closeRecover() {
    	//Hides modal
    	$('#recoverModal').modal('hide');
  	}

  	function changeRecover() {
		//Hides class status container
		$('.task-status').addClass('hidden');
		//Displays loader
		$('.loader').removeClass('hidden');
		///Hides modal
		$('#recoverModal').modal('hide');
		$.ajax({
			method: "POST",
			url: "recoverTask",
			data: { taskId: <?=$task->id?>,
					projectId: <?=$project->id?>,
					taskGroupId: <?=$taskGroup != NULL ? $taskGroup->id : 0?>,
					token:              "small2018Vis",
					submit: true
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
				console.log(response.response[0]);
			window.location.href = "task?id=<?=$task->id?>";
		});
	}
</script>

<!-- RECOVER MODAL -->
<div class="modal fade" id="recoverModal" tabindex="-1" role="dialog" aria-labelledby="Recuperar Tarefa" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-pencil"></i> <?="$task->code<br>$task->title"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeRecover();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p class="text-align-center">Por favor, confirme que deseja <b>recuperar</b> a tarefa:<br><br><b><?="$task->code<br>$task->title"?></b><br><br>A partir de então, a tarefa ficará visível à usuários.</p>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-info btn-lg" onclick="changeRecover();">Recuperar Tarefa</button>
      </div>
    </div>
  </div>
</div>
<!-- /. RECOVER MODAL -->

<? } ?> <!-- CHECK ADMIN OR EDITOR -->