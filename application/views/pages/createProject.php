<div class="row">

    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-folder-open"></i> Criar Projeto</h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="col-md-6">
        <?php if($userAllowed) { ?>
            <form id="createProjectForm" class="" method="post">

                <!-- DADOS DO PROJETO -->
                <div id="info" class="form-section fadeIn animated">       
                    <? if (isset($messages) && isset($messages['project'])) { ?>
                        <div class="col-md-12 <?=$messages['project']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['project']['message']?></div>
                    <? } ?>
                    <div class="form-group row">
                        <label for="title" class="col-md-3 col-form-label">Título do Projeto <span class="text-red bold">*</span></label>
                        <div class="col-md-9">
                            <input id="title" name="title" type="text" class="form-control" value="<?=$this->helper->get('title')?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="briefing" class="col-md-3 col-form-label">Descrição <span class="text-red bold">*</span></label>
                        <div class="col-md-9">
                            <textarea id="briefing" name="briefing" cols="50" rows="5" class="form-control" placeholder="Máximo de caractéres: 5000" required><?=$this->helper->get('briefing')?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="client" class="col-md-3 col-form-label">Cliente Relacionado <span class="text-red bold">*</span></label>
                        <div class="col-md-9">
                            <select id="client" name="client" class="form-control" required>
                                <option value="">Selecionar Cliente</option>
                                <?php foreach($clients as $client) { ?>
                                    <option value="<?=$client->id?>" <?=isset($_GET['clientId']) && $_GET['clientId'] == $client->id ? 'selected' : ''?>><?=$client->code?> - <?=$client->name?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deliverDate" class="col-md-3 col-form-label">Data de Entrega <span class="text-red bold">*</span></label>
                        <div class="col-md-9">
                            <input id="deliverDate" name="deliverDate" type="datetime-local" class="form-control" min="<?=$now?>" value="<?=$this->helper->get('deliverDate') != "" ? $this->helper->get('deliverDate') : $now?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button id="submit" name="submit" type="submit" class="btn btn-lg btn-block btn-success">Criar Projeto</button>
                        </div>
                    </div>
                </div>
                <!-- FIM DADOS DO PROJETO -->

            </form>
        <?php } else { ?>
            <p>Você não tem permissão para esta ação.</p>
            <p>Clique <a href="<?=base_url()?>">aqui</a> para voltar.</p>
        <? } ?>
    </div>
    <!-- /.col-md-6 -->

</div>
<!-- /.row -->