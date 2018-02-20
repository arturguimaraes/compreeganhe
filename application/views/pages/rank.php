<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container padding-top-100">
        <h2 class="col-md-12 margin-bottom-50 text-align-center">Graduação</h2>
        <div class="display-flex-desktop margin-bottom-30">
            <div class="col-md-4 col-sm-12 col-xs-12 col-12 display-grid margin-bottom-30">
                <p class="text-align-center">Parabéns! Você é do nível <b><?=$user->graduation?></b></p>
                <img class="margin-auto-horizontal" src="assets/img/<?=$user->graduation?>.png">
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12 col-12">
              <div class="table-responsive">
                <table class="table text-align-center">
                  <thead>
                    <tr>
                      <th scope="col">Ativação</th>
                      <th scope="col">DIRETO</th>
                      <th scope="col">INDIRETO 1</th>
                      <th scope="col">INDIRETO 2</th>
                      <th scope="col">INDIRETO 3</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Todos</td>
                      <td><?=$user->countAll['DIRETO']?></td>
                      <td><?=$user->countAll['INDIRETO 1']?></td>
                      <td><?=$user->countAll['INDIRETO 2']?></td>
                      <td><?=$user->countAll['INDIRETO 3']?></td>
                    </tr>
                    <tr class="background-green">
                      <td>Ativos</td>
                      <td><?=$user->countPaid['DIRETO']?></td>
                      <td><?=$user->countPaid['INDIRETO 1']?></td>
                      <td><?=$user->countPaid['INDIRETO 2']?></td>
                      <td><?=$user->countPaid['INDIRETO 3']?></td>
                    </tr>
                    <tr class="background-coral">
                      <td>Não Ativos</td>
                      <td><?=$user->countNotPaid['DIRETO']?></td>
                      <td><?=$user->countNotPaid['INDIRETO 1']?></td>
                      <td><?=$user->countNotPaid['INDIRETO 2']?></td>
                      <td><?=$user->countNotPaid['INDIRETO 3']?></td>
                    </tr>
                    <tr class="background-begginners">
                      <td>INICIANTE</td>
                      <td><?=$user->countBegginners['DIRETO']?></td>
                      <td><?=$user->countBegginners['INDIRETO 1']?></td>
                      <td><?=$user->countBegginners['INDIRETO 2']?></td>
                      <td><?=$user->countBegginners['INDIRETO 3']?></td>
                    </tr>
                    <tr class="background-bronze">
                      <td>BRONZE</td>
                      <td><?=$user->countBronze['DIRETO']?></td>
                      <td><?=$user->countBronze['INDIRETO 1']?></td>
                      <td><?=$user->countBronze['INDIRETO 2']?></td>
                      <td><?=$user->countBronze['INDIRETO 3']?></td>
                    </tr>
                    <tr class="background-silver">
                      <td>PRATA</td>
                      <td><?=$user->countSilver['DIRETO']?></td>
                      <td><?=$user->countSilver['INDIRETO 1']?></td>
                      <td><?=$user->countSilver['INDIRETO 2']?></td>
                      <td><?=$user->countSilver['INDIRETO 3']?></td>
                    </tr>
                    <tr class="background-gold">
                      <td>OURO</td>
                      <td><?=$user->countGold['DIRETO']?></td>
                      <td><?=$user->countGold['INDIRETO 1']?></td>
                      <td><?=$user->countGold['INDIRETO 2']?></td>
                      <td><?=$user->countGold['INDIRETO 3']?></td>
                    </tr>
                    <tr class="background-diamond">
                      <td>DIAMANTE</td>
                      <td><?=$user->countDiamond['DIRETO']?></td>
                      <td><?=$user->countDiamond['INDIRETO 1']?></td>
                      <td><?=$user->countDiamond['INDIRETO 2']?></td>
                      <td><?=$user->countDiamond['INDIRETO 3']?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="col-md-12 display-grid">
          <div class="margin-auto">
            <a href="javascript:;" onclick="printPage();"><img id="share-buttons-print" src="https://simplesharebuttons.com/images/somacro/print.png" alt="Print"/></a>
          </div>
        </div>
    </div>
</div>

<!-- FOOTER -->