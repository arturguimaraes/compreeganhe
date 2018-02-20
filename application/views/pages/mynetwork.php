<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<style>

	#share-buttons-print {
      width: 37px;
      border: 0;
      box-shadow: none;
      display: inline;
  }

 	@media (min-width: 1200px) {
  	#page-content .container {
    		max-width: 90%;
  	}
	}  

</style>

<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Minha Rede</h2>
        <div class="margin-bottom-20">
            <span class="margin-right-20">Organizar por</span>
            <a class="margin-right-10 margin-bottom-10 btn btn-<?=(isset($_GET['order']) && $_GET['order'] == 'name') ? 'primary' : 'success'?>" href="?order=name">Nome</a>
            <a class="margin-right-10 margin-bottom-10 btn btn-<?=(isset($_GET['order']) && $_GET['order'] == 'createDate') || (!isset($_GET['order'])) ? 'primary' : 'success'?>" href="?order=createDate">Data de Cadastro</a>
            <a class="margin-right-10 margin-bottom-10 btn btn-<?=(isset($_GET['order']) && $_GET['order'] == 'paymentDate') ? 'primary' : 'success'?>" href="?order=paymentDate">Data de Ativação</a>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Usuário</th>
                <th>Data de Cadastro</th>
                <th>Nível de Indicação</th>
                <th>Graduação</th>
                <th>Usuário Ativo</th>
                <th>Data de Ativação</th>
              </tr>
            </thead>
            <tbody>
				<?php if(count($network) > 0) {
					foreach($network as $user) { 
						if(isset($_SESSION['username']) && $user['user']->username != $_SESSION['username']) { ?>
                            <tr style="background: light<?=$user['user']->userPaymentDate != NULL ? 'green' : 'coral'?>">
                                <td><?=$user['user']->name?></td>
                                <td><?=$user['user']->username?></td>
                                <td><?=$this->util->dateTimeToString($user['user']->createDate)?></td>
                                <td><?=$user['level']?></td>
                                <td style="background:<?=$user['user']->userPaymentDate != NULL ? $user['user']->color : 'none'?>;"><?=$user['user']->graduation?></td>
                                <td><?=$user['user']->userPaymentDate != NULL ? 'Ativo' : 'Não Ativo'?></td>
                                <td><?=$user['user']->userPaymentDate != NULL ? $this->util->dateTimeToString($user['user']->userPaymentDate) : ''?></td>
                            </tr>
                		<?php }
					}
				} else { 
                	echo "<tr><td colspan='6' class='text-align-center'>Não há usuários em sua rede de negócios.</td></tr>";
            	} ?>
            </tbody>
          </table>
        </div>
        <?php if(count($network) > 0) { ?>
          <div class="col-md-12 display-grid">
            <div class="margin-auto">
              <a class="btn btn-success margin-right-10" href="/export?content=mynetwork">Exportar</a>
              <a href="javascript:;" onclick="printPage();"><img id="share-buttons-print" src="https://simplesharebuttons.com/images/somacro/print.png" alt="Print"/></a>
            </div>
          </div>
        <? } ?>
      </div>
    </div>
</div>

<!-- FOOTER -->