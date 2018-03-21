<script>
    function checkRepeat() {
        if($("#repeat").is(":checked")) {
            $("#repeat-container").removeClass("hidden");
            $("#repeatNumber").prop('required',true);
            $("#repeatType").prop('required',true);
        }
        else {
            $("#repeat-container").addClass("hidden");
            $("#repeatNumber").val(1).prop('required',false);
            $("#repeatType").val(1).prop('required',false);
        }
    }

    function checkRepeat2() {
        if($("#repeat2").is(":checked")) {
            $("#repeat-container2").removeClass("hidden");
            $("#repeatNumber2").prop('required',true);
            $("#repeatType2").prop('required',true);
        }
        else {
            $("#repeat-container2").addClass("hidden");
            $("#repeatNumber2").val(1).prop('required',false);
            $("#repeatType2").val(1).prop('required',false);
        }
    }
</script>

<div class="row">

    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-pencil"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="col-md-6">
        <?php if($userAllowed) { ?>
            <ul class="nav nav-tabs margin-bottom-20">
                <li class="<?=$this->helper->get('formType') == "team" ? "" : "active"?>"><a href="#user" class="task-tab" data-toggle="tab">Atribuir a Usuário</a></li>
                <li class="<?=$this->helper->get('formType') == "team" ? "active" : ""?>"><a href="#team" class="task-tab" data-toggle="tab">Atribuir a Equipe</a></li>
            </ul>
            <div class="tabbable">
                <div class="tab-content">
                    <div class="tab-pane <?=$this->helper->get('formType') == "team" ? "" : "active"?>" id="user">
                        <form id="createTaskForm" class="" method="post">
                            <!-- DADOS DO PROJETO -->
                            <div id="info" class="form-section fadeIn animated">       
                                <? if (isset($messages) && isset($messages['task'])) { ?>
                                    <div class="col-md-12 <?=$messages['task']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['task']['message']?></div>
                                <? } ?>
                                <div class="form-group row">
                                    <label for="title" class="col-md-3 col-form-label">Título da Tarefa <span class="text-red bold">*</span></label>
                                    <div class="col-md-9">
                                        <input id="title" name="title" type="text" class="form-control" value="<?=$this->helper->get('title')?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-md-3 col-form-label">Descrição <span class="text-red bold">*</span></label>
                                    <div class="col-md-9">
                                        <textarea id="description" name="description" cols="50" rows="5" class="form-control" placeholder="Máximo de caractéres: 5000" required><?=$this->helper->get('description')?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="deliverDate" class="col-md-3 col-form-label">Data de Entrega <span class="text-red bold">*</span></label>
                                    <div class="col-md-9">
                                        <input id="deliverDate" name="deliverDate" type="datetime-local" class="form-control" min="<?=$now?>" value="<?=$this->helper->get('deliverDate') != "" ? $this->helper->get('deliverDate') : $tomorrow?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="repeat" class="col-md-3 col-form-label">Repetir</label>
                                    <div class="col-md-9">
                                        <input id="repeat" name="repeat" type="checkbox" onclick="checkRepeat();" <?= $this->helper->get('repeat') == "on" ? "checked" : ""?>>
                                    </div>
                                </div>
                                <div id="repeat-container" class="<?= $this->helper->get('repeat') == "on" ? "" : "hidden"?>">
                                    <div class="form-group row">
                                        <label for="repeatType" class="col-md-3 col-form-label">Intervalo de repetição <span class="text-red bold">*</span></label>
                                        <div class="col-md-2">
                                            <select id="repeatType" name="repeatType" class="form-control">
                                                <option value="days" <?=$this->helper->get('repeatType') == "days" ? 'selected' : ''?>>Dia</option>
                                                <option value="weeks" <?=$this->helper->get('repeatType') == "weeks" ? 'selected' : ''?>>Semana</option>
                                                <option value="months" <?=$this->helper->get('repeatType') == "months" ? 'selected' : ''?>>Mês</option>
                                                <option value="years" <?=$this->helper->get('repeatType') == "years" ? 'selected' : ''?>>Ano</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="repeatNumber" class="col-md-3 col-form-label">Número de repetições <span class="text-red bold">*</span></label>
                                        <div class="col-md-2">
                                            <input id="repeatNumber" name="repeatNumber" type="number" class="form-control" min=0 value="<?= $this->helper->get('repeatNumber') != "" ? $this->helper->get('repeatNumber') : 1 ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="responsibleUserId" class="col-md-3 col-form-label">Responsável <span class="text-red bold">*</span></label>
                                    <div class="col-md-9">
                                        <select id="responsibleUserId" name="responsibleUserId" class="form-control" required>
                                            <option value="">Selecionar Usuário</option>
                                            <?php foreach($users as $user) { ?>
                                                <option value="<?=$user->id?>" <?=$this->helper->get('responsibleUserId') == $user->id ? 'selected' : ''?>><?=$user->name?> (<?=$user->username?>)</option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if(isset($_GET['taskGroupId']) && $_GET['taskGroupId'] != "" && $_GET['taskGroupId'] != 0) { ?>
                                	<div class="form-group">
                                        <a class="display-block float-right" href="createUser?companyId=<?=$user->companyId?>&redirect=createTask&redirectName=projectId&redirectValue=<?=$project->id?>&redirectName2=taskGroupId&redirectValue2=<?=$taskGroup->id?>">Cadastrar Novo Usuário</a>
                                    </div>
								<?php } else { ?>
                                	<div class="form-group">
                                        <a class="display-block float-right" href="createUser?companyId=<?=$user->companyId?>&redirect=createTask&redirectName=projectId&redirectValue=<?=$project->id?>">Cadastrar Novo Usuário</a>
                                    </div>
								<? } ?>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="formType" value="user">
                                        <button id="submit" name="submit" type="submit" value="submitUser" class="btn btn-lg btn-block btn-success">Criar Tarefa</button>
                                    </div>
                                </div>
                            </div><!-- FIM DADOS DO PROJETO -->
                        </form>
                    </div>
                    <div class="tab-pane <?=$this->helper->get('formType') == "team" ? "active" : ""?>" id="team">
                        <form id="createTaskForm" class="" method="post">
                            <!-- DADOS DO PROJETO -->
                            <div id="info" class="form-section fadeIn animated">       
                                <? if (isset($messages) && isset($messages['task'])) { ?>
                                    <div class="col-md-12 <?=$messages['task']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['task']['message']?></div>
                                <? } ?>
                                <div class="form-group row">
                                    <label for="title" class="col-md-3 col-form-label">Título da Tarefa <span class="text-red bold">*</span></label>
                                    <div class="col-md-9">
                                        <input id="title" name="title" type="text" class="form-control" value="<?=$this->helper->get('title')?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-md-3 col-form-label">Descrição <span class="text-red bold">*</span></label>
                                    <div class="col-md-9">
                                        <textarea id="description" name="description" cols="50" rows="5" class="form-control" placeholder="Máximo de caractéres: 5000" required><?=$this->helper->get('description')?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="deliverDate" class="col-md-3 col-form-label">Data de Entrega <span class="text-red bold">*</span></label>
                                    <div class="col-md-9">
                                        <input id="deliverDate" name="deliverDate" type="datetime-local" class="form-control" min="<?=$now?>" value="<?=$this->helper->get('deliverDate') != "" ? $this->helper->get('deliverDate') : $tomorrow?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="repeat2" class="col-md-3 col-form-label">Repetir</label>
                                    <div class="col-md-9">
                                        <input id="repeat2" name="repeat" type="checkbox" onclick="checkRepeat2();" <?= $this->helper->get('repeat') == "on" ? "checked" : ""?>>
                                    </div>
                                </div>
                                <div id="repeat-container2" class="<?= $this->helper->get('repeat') == "on" ? "" : "hidden"?>">
                                    <div class="form-group row">
                                        <label for="repeatType2" class="col-md-3 col-form-label">Intervalo de repetição <span class="text-red bold">*</span></label>
                                        <div class="col-md-2">
                                            <select id="repeatType2" name="repeatType" class="form-control">
                                                <option value="days" <?=$this->helper->get('repeatType') == "days" ? 'selected' : ''?>>Dia</option>
                                                <option value="weeks" <?=$this->helper->get('repeatType') == "weeks" ? 'selected' : ''?>>Semana</option>
                                                <option value="months" <?=$this->helper->get('repeatType') == "months" ? 'selected' : ''?>>Mês</option>
                                                <option value="years" <?=$this->helper->get('repeatType') == "years" ? 'selected' : ''?>>Ano</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="repeatNumber2" class="col-md-3 col-form-label">Número de repetições <span class="text-red bold">*</span></label>
                                        <div class="col-md-2">
                                            <input id="repeatNumber2" name="repeatNumber" type="number" class="form-control" min=0 value="<?= $this->helper->get('repeatNumber') != "" ? $this->helper->get('repeatNumber') : 1 ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="responsibleUserId" class="col-md-3 col-form-label">Equipe <span class="text-red bold">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="teamId" name="teamId" required>
                                            <option value="">Selecionar Equipe</option>
                                            <?php foreach($teams as $team) { ?>
                                              <option value="<?=$team->id?>;<?=$team->lider?>"><?=$team->name?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="formType" value="team">
                                        <button id="submit" name="submit" type="submit" value="submitTeam" class="btn btn-lg btn-block btn-success">Criar Tarefa</button>
                                    </div>
                                </div>
                            </div><!-- FIM DADOS DO PROJETO -->
                        </form>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <p>Você não tem permissão para esta ação.</p>
            <p>Clique <a href="<?=base_url()?>">aqui</a> para voltar.</p>
        <? } ?>
    </div>
    <!-- /.col-md-8 -->

</div>
<!-- /.row -->