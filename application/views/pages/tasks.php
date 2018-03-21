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

<script>
    function showList(show) {
        if(show) {
            $("#calendarLink").removeClass("active");
            $("#calendarDiv").removeClass("active");
            $("#listLink").addClass("active");
            $("#list").addClass("active");
        }
        else {
            $("#listLink").removeClass("active");
            $("#list").removeClass("active");
            $("#calendarLink").addClass("active");
            $("#calendarDiv").addClass("active");
            $("#calendar").fullCalendar("render");
        }
    }
</script>

<style>
  .btn-block+.btn-block {
    margin-top:0;
  }

  #list {
    max-height: 600px;
    overflow-y: auto;
  }
</style>

<div class="row">

	<div id="long-data-loader" class="margin-top-200 margin-top-150-desktop">
        <div class="loader"></div>
        <p class="italic text-gray text-align-center">Carregando dados...</p>
    </div>

    <div id="long-data-container" class="hidden">
        <div class="col-md-12">
            <h1 class="page-header"><i class="fa fa-pencil"></i> Tarefas</h1>
        </div>
        <!-- /.col-md-12 -->
        
        <ul class="nav nav-tabs margin-bottom-20">
            <li id="calendarLink" class="<?=(isset($_GET['list']) && $_GET['list']) ? '' : 'active'?>"><a href="#" onclick="showList(false);" class="task-tab" data-toggle="tab">Calendário</a></li>
            <li id="listLink" class="<?=(isset($_GET['list']) && $_GET['list']) ? 'active' : ''?>"><a href="#" onclick="showList(true);" class="task-tab" data-toggle="tab">Lista</a></li>
        </ul>
        
        <div class="tabbable">
            <div class="tab-content">
                <div class="tab-pane col-lg-6 col-lg-offset-3 <?=(isset($_GET['list']) && $_GET['list']) ? '' : 'active'?>" id="calendarDiv">
                    <div id="calendar" class="display-table margin-bottom-50 padding-0">
                    </div>
                    <!-- /#calendarDiv -->
                    <div class="col-md-12 margin-top-20">
                        <?php if(isset($_GET['complete']) && $_GET['complete']) { ?>
                            <div class="text-align-center"><a href="/tasks">Esconder Tarefas Concluídas</a></div>
                        <?php } else { ?>
                            <div class="text-align-center"><a href="/tasks?complete=true">Exibir Tarefas Concluídas</a></div>
                        <? } ?>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <div class="tab-pane <?=(isset($_GET['list']) && $_GET['list']) ? 'active' : ''?>" id="list">
                	<div class="col-md-12">
                    	<?php if(count($user->tasks) > 0) {
                    		foreach($user->tasks as $task) { ?>
                            	<div class="notification-container">
                                	<a href="task?id=<?=$task->id?>" class="<?=$task->done == '1' ? 'text-gray' : ''?>">
                                    	<i class="fa fa-pencil fa-fw"></i> <?="$task->code: $task->title"?>
                                        <?=$task->late ? "<span class=\"badge badge-danger\">Atrasada</span>" : ""?>
                                        <?=$task->done ? "<span class=\"badge badge-success\">Completa</span>" : ""?>
                                        <?=($task->due && !$task->done) ? "<span class=\"badge badge-warning\">Entrega próxima</span>" : ""?>
                                    	<span class="pull-right text-muted small">Entrega: <?=$this->string->dateTimeToString($task->deliverDate)?></span>
                                	</a>
                            	</div>
                        	<?php }
                        } else {
                        	echo "<div class=\"notification-container\"><a>Não há tarefas atribuídas à você.</a></div>";
                        } ?>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
            </div>
        </div>
        <!-- /.tabbable -->
    </div>
    <!-- /#long-data-container -->
    
</div>
<!-- /.row -->

<div id="event-modals">
</div>
<!-- /#event-modals -->