<h1>Imagens - Como Funciona</h1>
<div class="row">
	<?php for($i=1; $i <= $images['count']; $i++) { ?>
        <div class="col-md-6 admin-image-container">
        	<div class="col-md-6">
            	<img class="img-responsive" src="<?=$images['url'] . $i . $images['extension']?>" alt="Compre & Ganhe <?=$i?>">
            </div>
            <form enctype="multipart/form-data"  method="post" class="col-md-6 display-grid">
            	<h4 class="margin-10-auto">Imagem <?=$i?> - Como Funciona?</h4>
                <input name="imageSobre<?=$i?>" type="file" class="margin-10-auto">
                <button type="submit" class="btn btn-success margin-10-auto" name="sendImageSobre<?=$i?>">Enviar</button>
            </form>
        </div>
    <? } ?>
</div>