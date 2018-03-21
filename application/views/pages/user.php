<style>
    .btn-block+.btn-block {
        margin:0;
    }
</style>

<div class="row margin-bottom-30">

    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="col-md-8">
        <p><b>Nome: </b><?=$userView->name?></p>
        <p><b>Usuário: </b><?=$userView->username?></p>
        <p><b>E-mail: </b><?=$userView->email?></p>
        <p><b>Data de Nascimento: </b><?=$userView->dob == "0000-00-00 00:00:00" ? "" : $this->string->dateTimeToStringNoTime($userView->dob)?></p>
        <p><b>Perfil na Empresa: </b><?=$userView->profileCompany->profile?></p>
        <p><b>Cadastro no SmallVisor: </b><?=$this->string->dateTimeToString($userView->createDate)?></p>
    </div>
    <!-- /.col-md-8 -->

    <div class="col-md-4">
        
        <!-- CHECK ADMIN -->
        <?php if($user->admin) { ?> 

            <div class="loader hidden"></div>
            <div class="user-change">
                <div class="display-flex margin-bottom-20">
                    <!-- CHANGE PROFILE MODAL -->
                    <button type="button" class="btn btn-primary btn-lg btn-block margin-auto-horizontal margin-right-20" onclick="showProfile();">Mudar Perfil</button>
                    <!-- DELETE USER MODAL -->
                    <button type="button" class="btn btn-danger btn-lg btn-block margin-auto-horizontal margin-right-20" onclick="showDelete();">Excluir Usuário</button>
                </div>
            </div>

        <? } ?> <!-- CHECK ADMIN -->

    </div>
    <!-- /.col-md-4 -->

</div>
<!-- /.row -->

<!-- CHECK ADMIN -->
<?php if($user->admin) { ?>

<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-pencil"></i> Tarefas</h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="col-md-12">
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
                    <th scope="col">Criação</th>
                    <th scope="col">Entrega</th>
                    <th scope="col">Finalização</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($userView->tasks) > 0) {
                    foreach($userView->tasks as $task) { ?>
                        <tr>
                            <td><?=$task->code?></td>
                            <td><a href="task?id=<?=$task->id?>"><?=$this->string->getStringMax($task->title,20)?></a></td>
                            <td><?=$task->status?></td>
                            <td class="text-align-center"><?=$task->progress?>%</td>
                            <td class="text-align-center"><i class="fa fa-<?=$task->done ? 'check text-green' : 'times text-red'?>"></i></td>
                            <td><?=$this->string->getStringMax($task->description,40)?></td>
                            <td><?=$this->string->dateTimeToString($task->createDate)?></td>
                            <td><?=$this->string->dateTimeToString($task->deliverDate)?></td>
                            <td><?=$task->finishDate == NULL ? "" : $this->string->dateTimeToString($task->finishDate)?></td>
                        </tr>
                    <?php }
                } else { 
                    echo "<tr><td colspan=10 class='text-align-center'>Não há tarefas para este usuário.</td></tr>";
                } ?>
              </tbody>
            </table>
        </div>
    </div>
    <!-- /.col-md-12 -->

</div>
<!-- /.row -->

<!-- PROFILE MODAL SCRIPT -->
<script>
  function showProfile() {
    //Clears error div
    $('#profileModalError').empty();
    ///Shows modal
    $('#profileModal').modal('toggle');
  }

  function closeProfile() {
    //Hides modal
    $('#profileModal').modal('hide');
  }

  function changeProfile() {
    //Gets submitted values
    var profileCompanyId = $('#profileCompanyId').val();
    //Hides container
    $('.user-change').addClass('hidden');
    //Displays loader
    $('.loader').removeClass('hidden');
    //Hides modal
    $('#profileModal').modal('hide');
    //Sends ajaxs request to controller
    $.ajax({
        method: "POST",
        url: "changeProfile",
        data : {
            userId: <?=$userView->id?>,
            profileCompanyId: profileCompanyId,
            token:              "small2018Vis",
            submit: true
        }
    }).done( function(responseJson) {
        //Hides loader container
        $('.loader').addClass('hidden');
        //Shows container
        $('.user-change').removeClass('hidden');
        var response = JSON.parse(responseJson);
        //Error
        if(response.errors.length != 0)
            console.log(response.errors);
        else
            console.log(response.response[0]);
        window.location.href = "user?id=<?=$userView->id?>";
    });
  }
</script>
<!-- PROFILE MODAL SCRIPT -->

<!-- PROFILE MODAL -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="Mudar Perfil" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-user"></i> <?=$userView->name?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeProfile();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="profileCompanyId">Perfil</label>
            <select id="profileCompanyId" name="profileCompanyId" class="form-control" required>
                <?php foreach($profiles as $profile) { ?>
                    <option value="<?=$profile->id?>" <?=$userView->profileCompanyId == $profile->id ? 'selected' : ''?>><?=$profile->profile?></option>
                <? } ?>
            </select>
          </div>
        </form>
        <div id="profileModalError"></div>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-primary btn-block btn-lg" onclick="changeProfile();">Atualizar</button>
      </div>
    </div>
  </div>
</div>
<!-- /. PROFILE MODAL -->

<!-- DELETE MODAL SCRIPT -->
<script>
  function showDelete() {
    //Clears error div
    $('#deleteModalError').empty();
    ///Shows modal
    $('#deleteModal').modal('toggle');
  }

  function closeDelete() {
    //Hides modal
    $('#deleteModal').modal('hide');
  }

  function changeDelete() {
    //Checks if user is trying to delete himself
    if(<?=$userView->id?> == <?=$user->id?>)
        $('#deleteModalError').empty().append($('<p class="text-align-center italic text-red">Você não pode excluir a si mesmo.</p>'));
    else {
        //Hides container
        $('.user-change').addClass('hidden');
        //Displays loader
        $('.loader').removeClass('hidden');
        //Hides modal
        $('#deleteModal').modal('hide');
        //Sends ajaxs request to controller
        $.ajax({
            method: "POST",
            url: "deleteUser",
            data : {
                userId: <?=$userView->id?>,
                newUserId: <?=$user->id?>,
                token:              "small2018Vis",
                submit: true
            }
        }).done( function(responseJson) {
            //Hides loader container
            $('.loader').addClass('hidden');
            //Shows container
            $('.user-change').removeClass('hidden');
            var response = JSON.parse(responseJson);
            //Error
            if(response.errors.length != 0)
                console.log(response.errors);
            else
                console.log(response.response[0]);
            window.location.href = "user?id=<?=$userView->id?>";
        });
    }
  }
</script>
<!-- DELETE MODAL SCRIPT -->

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Excluir Usuário" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><i class="fa fa-user"></i> <?=$userView->name?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeDelete();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Tem certeza que deseja excluir esse usuário? Essa ação não pode ser desfeita.</p>
        <p><b>Obs:</b> Todas as tarefas atribuídas a este usuário serão atribuídas a você.</p>
        <div id="deleteModalError"></div>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-danger btn-block btn-lg" onclick="changeDelete();">Excluir</button>
      </div>
    </div>
  </div>
</div>
<!-- /. DELETE MODAL -->

<? } ?> <!-- CHECK ADMIN -->