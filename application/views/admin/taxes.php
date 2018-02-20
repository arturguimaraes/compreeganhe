<h1>Taxas</h1>
<div class="row display-table">
    <?php  foreach ($taxes as $tax) { ?>
        <div class="col-md-6 admin-image-container">
            <form enctype="multipart/form-data"  method="post" class="col-md-6 display-grid">
            	<h4 class="margin-10-auto"><?=$tax->name?></h4>
                <div class="margin-bottom-10">
                	<div class="col-xs-4">
                    	Porcentagem
                    </div>
                    <div class="col-xs-8">
                    	<input name="percentage<?=$tax->id?>" type="number" class="form-control product-value product-cents" min="0" max="100" value="<?=$tax->percentage?>" <?=!$tax->relative ? "readonly" : ""?>> % 
                        <input name="relative<?=$tax->id?>" type="checkbox" <?=$tax->relative ? "checked" : ""?> onclick="checkRelative(<?=$tax->id?>);">
                    </div>
                </div>
                <div class="margin-bottom-10">
                	<div class="col-xs-4">
                    	Valor Fixo
                    </div>
                    <div class="col-xs-8">
                    	R$ <input name="value<?=$tax->id?>" type="number" class="form-control product-value" value="<?=$tax->value?>" min="0" <?=$tax->relative ? "readonly" : ""?>> , 
                    	<input name="cents<?=$tax->id?>" type="number" class="form-control product-value product-cents" value="<?=$tax->cents?>" min="0" max="99" <?=$tax->relative ? "readonly" : ""?>>
                    </div>
                </div>
                <button type="submit" class="btn btn-success margin-10-auto" name="submit<?=$tax->id?>">Alterar</button>
            </form>
        </div>
    <? } ?>
</div>                