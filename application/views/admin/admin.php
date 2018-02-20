<h1>Imagens - Carrossel</h1>
<div class="row">
	<?php for($i=1; $i <= $carrousel['count']; $i++) { ?>
        <div class="col-md-6 admin-image-container">
        	<div class="col-md-6">
            	<img class="img-responsive" src="<?=$carrousel['url'] . $i . $carrousel['extension']?>" alt="Compre & Ganhe <?=$i?>">
            </div>
            <form enctype="multipart/form-data"  method="post" class="col-md-6 display-grid">
                <h4 class="margin-10-auto">Imagem <?=$i?> - Carrossel</h4>
                <input name="imageCarousel<?=$i?>" type="file" class="margin-10-auto">
                <button type="submit" class="btn btn-success margin-10-auto" name="sendImageCarousel<?=$i?>">Enviar</button>
            </form>
        </div>
    <? } ?>
</div>