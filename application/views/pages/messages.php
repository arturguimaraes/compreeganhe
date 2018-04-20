<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center"><i class="fa fa-envelope"></i> <?=$page['title']?></h2>
        <div class="table-responsive table-messages margin-bottom-30">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Lida</th>
                <th>Data</th>
                <th><?= $sent ? 'Para' : 'De'?></th>
                <th>Mensagem</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($messages) > 0) {  
                foreach($messages as $message) { ?>
                  <tr <?= ($message->read == 0 && !$sent) ? 'style="background:#ffc107;"' : ''?>>
                    <td><?=$message->read == 0 ? '<i class="fa fa-envelope"></i>' : '<i class="fa fa-envelope-open"></i>'?></td>
                    <td><?=$this->util->dateTimeToString($message->createDate)?></td>
                    <td><?="$message->name"?></a></td>
                    <td><?=$this->util->getStringMax($message->message,50)?></td>
                    <td><a href="message?id=<?=$message->messageId?><?=$sent ? '&sent=true' : ''?>">Ler Mensagem</a></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="5" class="text-align-center"><?= $sent ? 'Você não enviou nenhuma mensagem.' : 'Não há nenhuma mensagem para você.'?></td>
                </tr>
              <? } ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-12 display-grid">
          <div class="margin-auto">
            <?php if($sent) { ?>
              <a class="btn btn-primary text-white message-buttom-margin hidden" href="messages">Suas Mensagens</a>
            <?php } else { ?>
              <?php if(count($messages) > 0) { ?>
                <a class="btn btn-danger btn-lg text-white message-buttom-margin" href="deleteAllMessages">Apagar Todas</a>
                <a class="btn btn-info btn-lg text-white message-buttom-margin hidden" href="readAllMessages">Marcar Todas Como Lidas</a>
              <? } ?>
              <a class="btn btn-primary btn-lg text-white message-buttom-margin hidden" href="messages?sent=true">Mensagens Enviadas</a>
            <? } ?>
            <a class="btn btn-success btn-lg text-white message-buttom-margin" href="sendMessage?id=1">Suporte</a>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- FOOTER -->