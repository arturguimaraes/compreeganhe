<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
      	<h2 class="col-md-12 margin-bottom-30 text-align-center"><i class="fa fa-envelope"></i> <?=$page['title']?></h2>
        <div class="display-grid">
            <div class="col-md-6 margin-auto">
                <p class="margin-bottom-20"><b>Data:</b> <?=$this->util->datetimeToString($message->createDate)?></p>
                <p class="margin-bottom-20"><b>De:</b> <?="$message->name ($message->username)"?></p> 
                <?php if(!$permission) { ?>
                	<p class="margin-bottom-20"><b>Para:</b> <?="$userTo->name ($userTo->username)"?></p>
				<? } ?>
                <p class="margin-bottom-20"><b>Mensagem:</b><br><br><?=$message->message?></p>            
            </div>
            <div class="margin-auto">
                <?php if(!$permission) { ?>
                	<a class="btn btn-warning text-white message-buttom-margin" href="messages?sent=true">Voltar</a>
                <?php } else { ?>
                	<a class="btn btn-warning text-white message-buttom-margin" href="messages">Voltar</a>
                	<a class="btn btn-danger text-white message-buttom-margin" href="deleteMessage?id=<?=$message->messageId?>">Apagar</a>
                	<a class="btn btn-success text-white message-buttom-margin" href="sendMessage?id=<?=$message->from?>">Responder</a>
                 <? } ?>
            </div>
      	</div>
      </div>
    </div>
</div>

<!-- FOOTER -->