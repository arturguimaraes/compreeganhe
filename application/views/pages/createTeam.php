<div class="row">

    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-users"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->

    <div class="col-md-6">
        <?php if($userAllowed) { ?>
            <form id="createProjectForm" class="" method="post">

                <!-- DADOS DO PROJETO -->
                <div id="info" class="form-section fadeIn animated">       
                    <? if (isset($messages) && isset($messages['team'])) { ?>
                        <div class="col-md-12 <?=$messages['team']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['team']['message']?></div>
                    <? } ?>
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Nome da Equipe <span class="text-red bold">*</span></label>
                        <div class="col-md-10">
                            <input id="name" name="name" type="text" class="form-control" value="<?=$this->helper->get('name')?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-2 col-form-label">Descrição <span class="text-red bold">*</span></label>
                        <div class="col-md-10">
                            <textarea id="description" name="description" cols="50" rows="5" class="form-control" placeholder="Máximo de caractéres: 5000" required><?=$this->helper->get('description')?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lider" class="col-md-2 col-form-label">Líder <span class="text-red bold">*</span></label>
                        <div class="col-md-10">
                            <select id="lider" name="lider" class="form-control" required>
                                <option value="">Selecionar Usuário</option>
                                <?php foreach($users as $user) { ?>
                                    <option value="<?=$user->id?>" <?=$this->helper->get('lider') == $user->id ? 'selected' : ''?>><?=$user->name?> (<?=$user->username?>)</option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="users" class="col-md-2 col-form-label">Integrantes <span class="text-red bold">*</span></label>
                        <div class="col-md-10">
                            <select id="users" name="users[]" class="form-control" multiple required>
                                <?php foreach($users as $user) { ?>
                                    <option value="<?=$user->id?>"><?=$user->name?> (<?=$user->username?>)</option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                    	<div class="col-md-12">
                        	<a class="display-block text-align-center float-right" href="createUser?companyId=<?=$user->companyId?>&redirect=createTeam&redirectName=companyId&redirectValue=<?=$_GET['companyId']?>">Cadastrar Novo Usuário</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button id="submit" name="submit" type="submit" class="btn btn-lg btn-block btn-success">Criar Equipe</button>
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