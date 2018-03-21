<style>
    #notifications-container {
        max-height: 600px;
        overflow-y: auto;
    }
</style>

<div class="row">

	<div class="col-md-12">
        <h1 class="page-header" id="notifications-title"><i class="fa fa-bell"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->
    
    <div class="col-md-12" id="notifications-container">
		<?php if (count($user->notifications) > 0 ) {
            foreach($user->notifications as $notification) { ?>
                <div class="notification-container">
                    <a href="<?=$notification->link?>">
                    	<i class="fa fa-<?=$notification->type?> fa-fw"></i> <?=$notification->description?>
                        <span class="pull-right text-muted small"><?=$this->string->dateTimeToString($notification->createDate)?></span>
                    </a>
                </div>
            <?php }
        } else {
            echo "<div class=\"notification-container\">Não há notificações para você.</div>";
        } ?>
	</div>
    <!-- /.col-md-12 -->
    
    <?php if (count($user->notifications) > 0 ) { ?>
        <div class="col-md-4 col-md-offset-4 margin-top-20">
            <a class="btn btn-warning btn-block btn-lg" href="#" onclick="cleanNotifications();">Limpar Notificações</a>
        </div>
        <!-- /.col-md-12 -->
    <? } ?>
        
</div>