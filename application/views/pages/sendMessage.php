<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center"><i class="fa fa-envelope"></i> <?=$page['title']?></h2>
        <div class="display-grid">
      <? if (isset($messages) && isset($messages['message'])) { ?>
              <div class="col-md-12 <?=$messages['message']['messageClass']?> italic margin-bottom-20 text-align-center"><?=$messages['message']['message']?></div>
      <? } ?>
            <form enctype="multipart/form-data" method="post" class="col-md-6 margin-auto">
              <div class="form-group hidden">
                <label for="to">Enviar Para</label>
                <select class="form-control" id="to" name="to" required>
                  <?php if($direct) { ?>
                      <option value="<?=$userTo->id?>"><?=$userTo->name?> (<?=$userTo->username?>)</option>
                    <?php } else { ?>
                        <option></option>
                        <?php if(count($network) > 0) {
                            foreach($network as $user) { 
                                if($user['user']->id != $onwner) { ?>
                                    <option value="<?=$user['user']->id?>"><?=$user['user']->name?> (<?=$user['user']->username?>)</option>
                                <?php }
                            }
                        } else {
                            echo '<option value="">Não há usuários em sua rede de negócios.</option>';
                        } 
          } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="message">Mensagem</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Escreva aqui sua mensagem (até 2000 caracteres)" maxlength="2000" required></textarea>
              </div>
              <div class="col-md-12 display-grid margin-top-20">
                <div class="margin-auto">
                  <a class="btn btn-warning btn-lg text-white message-buttom-margin" href="messages">Voltar</a>
                  <input class="btn btn-success btn-lg text-white message-buttom-margin" id="submit" name="submit" type="submit">
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

<!-- FOOTER -->