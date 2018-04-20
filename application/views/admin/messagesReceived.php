<h1>Mensagens de Usuários</h1>
<div class="row admin-table margin-bottom-20">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Lida</th>
        <th>Data</th>
        <th>De</th>
        <th>E-mail</th>
        <th>Mensagem</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if(count($messages) > 0) {  
        foreach($messages as $message) { ?>
          <tr <?= $message->read == 0 ? 'style="background:#ffc107;"' : ''?>>
            <td><?=$message->read == 0 ? '<i class="fa fa-envelope"></i>' : '<i class="fa fa-check"></i>'?></td>
            <td><?=$this->util->dateTimeToString($message->createDate)?></td>
            <td><?=$message->name?></td>
            <td><?=$message->email?></td>
            <td><?=$this->util->getStringMax($message->message,30)?></td>
            <!--<td><a href="adminMessagesReceived?id=<?=$message->messageId?>">Ler Mensagem</a></td>-->
            <td><a class="pointer btn btn-success" onclick="modalMessage(<?=$message->messageId?>);">Ler</a></td>
            <td><a class="pointer btn btn-danger" onclick="eraseMessage(<?=$message->messageId?>);"><i class="fa fa-trash"></i></a></td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="5" class="text-align-center">Não há nenhuma mensagem para você.</td>
        </tr>
      <? } ?>
    </tbody>
  </table>
</div>