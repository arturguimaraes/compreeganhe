<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js" type="text/javascript" ></script>
<div class="row">
    
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user"></i> <?=$page['title']?></h1>
    </div>
    <!-- /.col-md-12 -->
    
    <?php if(isset($_GET['teamId'])) { ?>
        <div class="col-md-4">
            <form id="addUserForm" class="" method="post">
                <!-- USUÁRIO -->
                <div id="user" class="form-section fadeIn animated">
                    <? if (isset($messages) && isset($messages['user'])) { ?>
                        <div class="col-md-12 <?=$messages['user']['messageClass']?> italic margin-bottom-30 text-align-center"><?=$messages['user']['message']?></div>
                    <? } ?>
                    <div class="form-group row">
                        <label for="user" class="col-md-2 col-form-label">Usuário <span class="text-red bold">*</span></label>
                        <div class="col-md-10">
                            <select id="user" name="user" class="form-control" required>
                                <option value="">Selecionar Usuário</option>
                                <?php foreach($users as $user) { ?>
                                    <option value="<?=$user->id?>" <?=$this->helper->get('user') == $user->id ? 'selected' : ''?>><?=$user->name?> (<?=$user->username?>)</option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <a href="team?id=<?=$_GET['teamId']?>" class="btn btn-lg btn-block btn-danger margin-right-10">Voltar</a> 
                        </div>
                        <div class="col-md-6"> 
                            <button id="submit" name="submit" type="submit" class="btn btn-lg btn-block btn-success">Adicionar</button>  
                        </div>
                    </div>
                    <div class="form-group row">
                    	<div class="col-md-12">
                        	<a class="display-block text-align-center" href="createUser?companyId=<?=$user->companyId?>&redirect=addUser&redirectName=teamId&redirectValue=<?=$_GET['teamId']?>">Cadastrar Novo Usuário</a>
                        </div>
                    </div>
                </div>
                <!-- FIM USUÁRIO -->
            </form>
        </div>
        <!-- /.col-md-6 -->
    
    <?php } else { ?>
        <div class="col-md-12 margin-bottom-20">
            <p>Você não escolheu uma equipe ou não tem equipes disponíveis para este usuário.</p>
        </div>
        <div class="col-md-12 display-flex margin-bottom-50">
            <a class="col-md-3 margin-auto btn btn-lg btn-primary" href="teams">Equipes</a>
        </div>
        <!-- /.col-md-12 -->
    <? } ?>
</div>
<!-- /.row -->
<!-- Custom Mask -->
<script src="assets/js/mask.js" type="text/javascript" ></script>