<!-- Full Calendar Imports -->
<link href='/assets/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='/assets/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='/assets/fullcalendar/lib/moment.min.js'></script>
<script src='/assets/fullcalendar/fullcalendar.min.js'></script>
<script src='/assets/fullcalendar/locale/pt-br.js'></script>
<!-- Calendar JavaScript -->
<script src="assets/js/calendar.js" type="text/javascript" ></script>

<!-- Calendar Events -->
<?=$this->string->addEventsToCalendar($clients, $user->id, $user->adminEditor)?>

<style>
  .btn-block+.btn-block {
    margin-top:0;
  }
</style>

<div class="row">

	<div id="long-data-loader" class="margin-top-200 margin-top-150-desktop">
		<div class="loader"></div>
		<p class="italic text-gray text-align-center">Carregando dados...</p>
	</div>

	<div id="long-data-container" class="hidden">
		<div id="calendarDiv" class="col-md-12 display-table margin-bottom-50 padding-0" style="max-height: 400px;">
		    <div class="col-md-12">
		        <h1 class="page-header"><i class="fa fa-calendar"></i> Calendário</h1>
		    </div>
		    <!-- /.col-md-12 -->
		    <div class="col-md-7 col-md-offset-2">
		    	<div id="calendar"></div>
	        </div>
		    <!-- /.col-md-7 -->
		    <div class="col-md-7 col-md-offset-2 margin-top-20">
		    	<?php if(isset($_GET['complete']) && $_GET['complete']) { ?>
	        		<div class="text-align-center"><a href="/">Esconder Tarefas Concluídas</a></div>
	        	<?php } else { ?>
	        		<div class="text-align-center"><a href="/?complete=true">Exibir Tarefas Concluídas</a></div>
	        	<? } ?>
	        </div>
		    <!-- /.col-md-7 -->
		</div>
		<!-- /#calendarDiv -->

		<div id="clientsDiv" class="col-lg-12 display-table margin-auto margin-bottom-50 padding-0">
		    <div class="col-md-12">
		        <h1 class="page-header"><i class="fa fa-folder-open"></i> Projetos</h1>
		    </div>
		    <!-- /.col-md-12 -->
		    <?php foreach($clients as $client) { ?>
			    <div class="col-md-12">
			        <h4>
			        	<i class="fa fa-user" style="color:#<?=$client['client']->color?>"></i>&nbsp;
			        	<a href="client?id=<?=$client['client']->id?>"><?=$client['client']->code?> - <?=$client['client']->name?></a>&nbsp;
			        	<a data-toggle="collapse" href="#collapse<?=$client['client']->id?>" role="button" aria-expanded="false" aria-controls="collapse<?=$client['client']->id?>" onclick="changeIcon(<?=$client['client']->id?>);">
			        		<i id="icon<?=$client['client']->id?>" class="fa fa-caret-right"></i>
			        	</a>
			        </h4>
					<div class="collapse " id="collapse<?=$client['client']->id?>">
					  	<div class="card card-body">
					  		<div class="table-responsive">
						        <table class="table table-striped table-small-font">
								  <thead>
								    <tr>
								      <th scope="col">Código</th>
								      <th scope="col">Nome</th>
								      <th scope="col">Criado por</th>
								      <th scope="col">Criação</th>
								      <th scope="col">Entrega</th>
								      <th scope="col">Status</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php if(count($client['projects']) > 0) {
								  		foreach($client['projects'] as $project) { ?>
								  			<tr>
										      <th scope="row"><?=$project->code?></th>
										      <td>
		                                      	<a href="project?id=<?=$project->id?>">
											  		<?=substr($project->title,0,20)?><?=strlen($project->title) > 20 ? '...' : ''?>
		                                        </a>
		                                      </td>
										      <td><?=explode(' ',trim($project->adminUserName))[0]?></td>
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
					</div>
			    </div>
			    <!-- /.col-md-12 -->
			<? } ?>
		</div>
		<!-- /#clientsDiv -->
	</div>
	<!-- /#long-data-container -->

</div>
<!-- /.row -->

<div id="event-modals">
</div>
<!-- /#event-modals -->