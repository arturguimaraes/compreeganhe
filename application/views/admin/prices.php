<h1>Preços</h1>
<div class="row">
	<?php foreach ($products as $product) { ?>
        <div class="col-md-12 margin-auto margin-bottom-30 display-grid">
            <h5 class="margin-10-auto">
                <?=$product->name?>
                <a data-toggle="collapse" href="#collapse<?=$product->id?>" role="button" aria-expanded="false" aria-controls="collapse<?=$product->id?>" onclick="changeIcon(<?=$product->id?>);">
                    <i id="icon<?=$product->id?>" class="fa fa-caret-square-o-right"></i>
                </a>
            </h5>
            <div class="collapse" id="collapse<?=$product->id?>">
                <div class="card card-body">
                    <div class="col-md-4">
                        <?php if ($product->image != NULL) { ?>
                    	   <img src="data:image/jpeg;base64,<?=base64_encode($product->image)?>" class="img-responsive" alt="<?=$product->name?>"/>
                        <?php } else { ?>
                            <img src="assets/img/logo_cg_old.png" class="img-responsive" alt="<?=$product->name?>"/>
                        <? } ?>
                    </div>
                    <form class="col-md-8" enctype="multipart/form-data"  method="post">
                        <input name="productName<?=$product->id?>" type="text" class="form-control margin-bottom-10" value="<?=$product->name?>">
                        <textarea name="productDescription<?=$product->id?>" class="form-control margin-bottom-10" rows="4" cols="50"><?=$product->description?></textarea>
                        <div class="margin-bottom-10">
                            R$ <input name="productValue<?=$product->id?>" type="number" class="form-control margin-bottom-10 product-value" value="<?=$product->value?>" min="0"> , 
                            <input name="productCents<?=$product->id?>" type="number" class="form-control margin-bottom-10 product-value product-cents" value="<?=$product->cents?>" min="0" max="99">
                            <button type="submit" class="btn btn-success margin-10-auto" name="sendProductValue<?=$product->id?>">Alterar</button>
                            <?php if ($product->id != 1) { ?>
                                <button type="submit" class="btn btn-danger margin-10-auto" name="removeProduct<?=$product->id?>">Remover</button>
                            <? } ?>
                            <!--<input name="productImage<?=$product->id?>" type="file" class="form-control col-md-6 margin-left-10">-->
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
	<? } ?>
</div>                