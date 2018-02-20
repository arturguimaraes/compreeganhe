<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <?php if(isset($product) && $product != NULL) { ?>
          <h2 class="col-md-12 margin-bottom-30 text-align-center"><?=$product->name?></h2>
          <div class="row margin-bottom-30">
            <div class="col-md-6">              
				<?php if ($product->image != NULL) { ?>
                	<img class="product-image-detail" src="data:image/jpeg;base64,<?=base64_encode($product->image)?>" alt="<?=$product->name?>"/>
                <?php } else { ?>
                	<img class="product-image-detail" src="assets/img/logo_cg_old.png" alt="<?=$product->name?>"/>
                <? } ?>
            </div>
            <div class="col-md-6">
              <p>Nome: <?=$product->name?></p>
              <p>Descrição: <?=$product->description?></p>
              <p>Preço: R$ <?=number_format($product->value, 2, ',', '')?></p>
              <a href="/product?id=<?=$_GET['id']?>&buy=true" class="btn btn-success">Adicionar ao Carrinho</a>
            </div>
          </div>
        <?php } else { ?>
          <p>Não foi possível encontrar este produto.</p>
        <? } ?>
      </div>
    </div>
</div>

<!-- FOOTER -->