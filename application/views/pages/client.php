<div class="row margin-bottom-50">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user" style="color:#<?=$client->color?>"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->
    
    <div class="col-md-4">
        <p><b>Código: </b><?=$client->code?></p>
        <p><b>Nome: </b><?=$client->name?></p>
        <p><b>Cor: </b><span style="background-color:#<?=$client->color?>">&nbsp;&nbsp;&nbsp;&nbsp;</span></p>
        <p><b>Razão Social: </b><?=$client->razaoSocial?></p>
        <p><b>CNPJ: </b><?=$client->cnpj?></p>
        <p><b>Inscrição Estadual: </b><?=$client->inscricaoEstadual?></p>
        <p><b>Inscrição Municipal: </b><?=$client->inscricaoMunicipal?></p>
    </div>
    <!-- /.col-md-4 -->
    
    <div class="col-md-4">
    	<p><b>Endereço: </b><?=$client->address?></p>
        <p><b>Endereço Fiscal: </b><?=$client->fiscalAddress != NULL ? $client->fiscalAddress : ""?></p>
        <p><b>Site: </b><a href="https://<?=$client->website?>"><?=$client->website?></a></p>
        <p><b>Telefone: </b><?=$client->phone?></p>
        <p><b>Cadastro no SmallVisor: </b><?=$this->string->dateTimeToString($client->createDate)?></p>
        <?php if($client->contact1 != NULL && $client->contact1 != "") { ?>
          <p><b>Contato 1: </b><?=$client->contact1?> | <?=$client->contact1Email?> | <?=$client->contact1Phone?></p>
        <?php } if($client->contact2 != NULL && $client->contact2 != "") { ?>
          <p><b>Contato 2: </b><?=$client->contact2?> | <?=$client->contact2Email?> | <?=$client->contact2Phone?></p>
        <?php } if($client->contact3 != NULL && $client->contact3 != "") { ?>
          <p><b>Contato 3: </b><?=$client->contact3?> | <?=$client->contact3Email?> | <?=$client->contact3Phone?></p>
        <?php } if($client->contact4 != NULL && $client->contact4 != "") { ?>
          <p><b>Contato 4: </b><?=$client->contact4?> | <?=$client->contact4Email?> | <?=$client->contact4Phone?></p>
        <? } ?>
    </div>
    <!-- /.col-md-4 -->

    <div class="col-md-4">
      <div class="loader hidden"></div>
      <div class="client-buttons">
        <!-- CHECK ADMIN OR EDITOR -->
        <?php if($user->adminEditor) { ?> 
        <a class="btn btn-primary btn-lg btn-block margin-bottom-10" href="createProject?clientId=<?=$client->id?>">Criar um Projeto</a>
        <? } ?> <!-- CHECK ADMIN OR EDITOR -->
        <!-- CHECK ADMIN -->
        <?php if($user->admin) { ?> 
          <a class="btn btn-danger btn-lg btn-block margin-bottom-10" onclick="showDelete();">Excluir Cliente</a>
        <? } ?><!-- CHECK ADMIN -->
      </div>
    </div>
    <!-- /.col-md-4 -->

</div>
<!-- /.row -->

<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-folder-open"></i> <?=$client->name?> - Projetos</h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Código</th>
              <th scope="col">Nome</th>
              <th scope="col">Criado por</th>
              <th scope="col">Data de criação</th>
              <th scope="col">Data de entrega</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($projects) > 0) {
                foreach($projects as $project) { ?>
                    <tr>
                      <th scope="row"><?=$project->code?></th>
                      <td><a href="project?id=<?=$project->id?>"><?=$project->title?></a></td>
                      <td><?=$project->adminUserName?></td>
                      <td><?=$this->string->dateTimeToString($project->createDate)?></td>
                      <td><?=$this->string->dateTimeToString($project->deliverDate)?></td>
                      <td><?=$project->status?></td>
                    </tr>
                <?php }
            } else { 
                echo "<tr><td colspan=6 class='text-align-center'>Não há projetos para este cliente.</td></tr>";
            } ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.col-md-12 -->

</div>
<!-- /.row -->

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
    $('.client-buttons').addClass('hidden');
    //Displays loader
    $('.loader').removeClass('hidden');
    ///Hides modal
    $('#deleteModal').modal('hide');
    $.ajax({
      method: "POST",
      url: "deleteClient",
      data: { 
        clientId: '<?=$client->id?>',
        token: "small2018Vis",
        submit: true
      }
    }).done(function(responseJson) {
      //Hides loader container
      $('.loader').addClass('hidden');
      //Shows class status container
      $('.client-buttons').removeClass('hidden');
      var response = JSON.parse(responseJson);
      //Error
      if(response.errors.length != 0)
        console.log(response.errors);
      else
        console.log(response.response);
      window.location.href = "clients";
    });
  }
</script>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Excluir Cliente" aria-hidden="true">
  <div class="modal-dialog modal-task" role="document">
    <div class="modal-content">
      <div class="modal-header display-flex">
        <h5 class="modal-title text-align-center margin-auto" id="modal"><?="$client->code - $client->name"?></h5>
        <button type="button" class="close" aria-label="Fechar" onclick="closeDelete();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-align-center">Por favor, confirme que deseja excluir o cliente:<br><br><b><?="$client->code: $client->name"?></b><br><br>Ao excluir esse cliente, todos os projetos, grupos de tarefas, e tarefas e todos os logs relacionados a ele serão excluídos também.</p>
      </div>
      <div class="modal-footer text-align-center">
        <button type="button" class="btn btn-danger btn-lg" onclick="changeDelete();">Excluir <?="$client->name"?></button>
      </div>
    </div>
  </div>
</div>
<!-- /. DELETE MODAL -->