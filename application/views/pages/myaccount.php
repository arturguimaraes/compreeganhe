<!-- HEADER -->

<!-- NAVIGATION -->
<style>
    @media (min-width: 768px) {
        .button-my-account {
            height: 80px;
            border-radius: 10px;
            font-size: 20px;
            padding: 27px 0;
        }
    }
</style>

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container padding-top-100">
        <div class="col-md-12 margin-bottom-30">
            <h2 class="col-md-12 margin-bottom-50 text-align-center">Acessar</h2>
            <a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn btn-success button-my-account" href="mybudget">
                <i class="fa fa-dollar"></i> Extrato
            </a>
            <a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn btn-info button-my-account" href="mynetwork">
            	<i class="fa fa-group"></i> Rede
            </a>
            <a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn btn-success button-my-account" href="withdraw">
                <i class="fa fa-dollar"></i> Saque
            </a>
            <a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn btn-warning button-my-account" href="pay">
                <i class="fa fa-barcode"></i> Pagar Fatura
            </a>
            <a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn btn-primary button-my-account" href="myinfo">
            	<i class="fa fa-drivers-license"></i> Dados Cadastrais
            </a>
            <a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn btn-danger button-my-account" href="myorders">
                <i class="fa fa-credit-card"></i> Pedidos
            </a>
            <a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn btn-warning button-my-account" href="messages">
            	<i class="fa fa-envelope"></i> Mensagens <?=$user->unreadMessages?>
            </a>
            <!--<a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn button-my-account" href="rank" style="background:<?=$user->color?>;">
                <i class="fa fa-envelope"></i> <?=$user->graduation?>
            </a>-->
            <!--<a class="col-md-3 margin-horizontal-4 margin-bottom-50 btn btn-success button-my-account" href="mynetworksbudget">
                <i class="fa fa-dollar"></i> Extrato da Rede
            </a>-->
            <!--<p>- <a href="code">Gerar Código</a></p>
            <p>- <a href="shop">Catálogo de Itens</a></p>
            <p>- <a href="cart">Carrinho de Compras</a></p>-->
        </div>
        <div class="col-md-12 margin-bottom-80">
            <h2 class="col-md-12 margin-bottom-50 text-align-center">Link de Indicação</h2>
            <div class="display-grid">
                <div class="margin-auto margin-bottom-30">
                    <input type="text" id="code" name="code" class="form-control" value="www.compreeganhe.net/signup/<?=$user->code?>" readonly>
                </div>
                <a class="col-md-2 btn btn-warning margin-auto margin-bottom-10" onclick="copyToClipboard();">
                    <i class="fa fa-copy"></i> Copiar
                </a>
                <div id="copyMesssage" class="margin-auto" style="min-height:40px;"></div>
            </div>
            <!--<div class="display-flex">
                <div class="col-md-6 border-right-gray">
                    <h2 class="col-md-12 margin-bottom-50 text-align-center">Saldo</h2>
                    <div class="display-grid">
                        <p class="col-md-3 margin-auto user-balance <?=$user->balance == NULL || $user->balance == 0 ? "text-red" : "text-green"?>">
                            R$ <?=$user->balance == NULL || $user->balance == 0 ? "0.00" : $user->balance?>
                        </p>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</div>

<!-- FOOTER -->