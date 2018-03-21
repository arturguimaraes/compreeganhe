<div class="row" id="projectsDiv">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-folder-open"></i> Projetos</h1>
    </div>
    <!-- /.col-md-12 -->
    <?php if(count($clients) > 0 ) {
		foreach($clients as $client) { ?>
            <div class="col-md-12">
                <h4><i class="fa fa-user" style="color:#<?=$client['client']->color?>"></i> <a href="client?id=<?=$client['client']->id?>"><?=$client['client']->name?></a></h4>
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
                        <?php if(count($client['projects']) > 0) {
                            foreach($client['projects'] as $project) { ?>
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
        <?php }
	} else {
    	echo "<p>Sua empresa não tem clientes cadastrados.</p>";
	} ?>
</div>
<!-- /.row -->