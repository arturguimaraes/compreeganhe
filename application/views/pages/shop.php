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
      <div class="col-md-12 padding-top-100 margin-bottom-20">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Catálogo</h2>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Imagem</th>
              </tr>
            </thead>
            <tbody>
            	<?php if(count($products) > 0) {
					foreach($products as $product) { ?>
                  		<tr>
                        <td><a class="product-link" href="/product?id=<?=$product->id?>"><?=$product->name?></a></td>
                        <td><?=$product->description?></td>
                        <td>R$ <?=number_format($product->value, 2, ',', '')?></td>
                        <?php if ($product->image != NULL) { ?>
                           <td><img class="product-image" src="data:image/jpeg;base64,<?=base64_encode($product->image)?>" alt="<?=$product->name?>"/></td>
                        <?php } else { ?>
                            <td><img class="product-image" src="assets/img/logo_cg_old.png" alt="<?=$product->name?>"/></td>
                        <? } ?>
                  		</tr>
                	<?php }
				} else { ?>
                	<tr>
                  		<td colspan="4">Não há itens no catálogo.</td>
                	</tr>
              	<? } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

<!-- FOOTER -->