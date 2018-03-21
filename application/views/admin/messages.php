<h1>Enviar Mensagem aos Usuários</h1>
<div class="row admin-table margin-bottom-20">
    <div class="display-grid">
        <? if (isset($messages) && isset($messages['message'])) { ?>
            <div class="col-md-12 <?=$messages['message']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['message']['message']?></div>
        <? } ?>
        <form enctype="multipart/form-data" method="post" class="col-md-6 col-xs-12 margin-auto">
          <div class="form-group">
            <label for="message">Mensagem</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Escreva aqui sua mensagem (até 2000 caracteres)" maxlength="2000" required></textarea>
          </div>
          <div class="col-md-12 display-grid">
            <div class="margin-auto">
                <input id="submit" name="submit" value="Enviar" type="submit" class="btn btn-success btn-block btn-lg text-white message-buttom-margin">
            </div>
          </div>
        </form>
    </div>
</div>