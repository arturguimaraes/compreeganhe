<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user"></i> Perfil</h1>
    </div>
    <!-- /.col-md-12 -->
    <div class="col-md-4">
        <p><b>Nome: </b><?=$user->name?></p>
        <p><b>E-mail: </b><?=$user->email?></p>
        <p><b>Data de Nascimento: </b><?=$user->dob == "0000-00-00 00:00:00" ? "" : $this->string->dateTimeToStringNoTime($user->dob)?></p>
        <p><b>Tipo de Documento: </b><?=$user->documentType?></p>
        <p><b>Documento: </b><?=$user->document?></p>
    </div>
    <!-- /.col-md-4 -->
	<div class="col-md-4">
        <p><b>Usuário: </b><?=$user->username?></p>
        <p><b>Perfil no SmallVisor: </b><?=$user->profile->profile?></p>
        <p><b>Perfil na Empresa: </b><?=$user->profileCompany->profile?></p>
        <p><b>Cadastro no SmallVisor: </b><?=$this->string->dateTimeToString($user->createDate)?></p>
        <p><b>Última Atualização: </b><?=$user->updateDate != NULL ? $this->string->dateTimeToString($user->updateDate) : ""?></p>
        <p><b>Notificações por E-mail: </b><?=$user->emailNotification == "sim" ? "Sim" : "Não"?></p>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4">
        <a class="btn btn-success btn-lg btn-block margin-bottom-10" href="updateProfile">Atualizar Sua Conta</a>
        <!--<a class="btn btn-primary btn-lg btn-block margin-bottom-10" href="">Alterar Usuário</a>-->
        <a class="btn btn-danger btn-lg btn-block margin-bottom-10" href="password">Alterar Senha</a>
    </div>
    <!-- /.col-md-4 -->
</div>
<!-- /.row -->