<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<style>
  @media (min-width: 1200px) {
    #page-content .container {
      max-width: 90%;
    }
  }  
</style>

<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Extrato da Minha Rede</h2>
        <?php //var_dump($network); ?>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Data</th>
                <th>Usuário</th>
                <th>Nível de Indicação</th>
                <th>Descrição</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody>
              <?php $existeTransacao = false;
              if(count($network) > 0) {  
                foreach($network as $user) {
                  if(isset($user['transactions']) && count($user['transactions']) > 0) {
                    $existeTransacao = true;
                    foreach($user['transactions'] as $transaction) { ?>
                      <tr>
                        <td><?=$this->util->dateTimeToString($transaction->createDate)?></td>
                        <td><?=$user['user']['user']->name?></td>
                        <td><?=$user['user']['level']?></td>
                        <td><?=$transaction->action?></td>
                        <td>R$ <?=number_format($transaction->value, 2, ',', '')?></td>
                      </tr>
                    <?php }
                  }
                }
                if(!$existeTransacao) { ?>
                  <tr>
                    <td colspan="5" class="text-align-center">Não há movimentações na sua rede.</td>
                  </tr>
                <?php } 
              } ?>
            </tbody>
          </table>
        </div>
        <?php if($existeTransacao) { ?>
          <div class="col-md-12 display-grid">
            <div class="margin-auto">
              <a class="btn btn-success" href="/export?content=mynetworksbudget">Exportar</a>
            </div>
          </div>
        <? } ?>
      </div>
    </div>
</div>

<!-- FOOTER -->