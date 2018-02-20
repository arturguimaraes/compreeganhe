<h1>Adicionar Produto</h1>
<div class="row display-grid">
	<form class="col-md-8 margin-auto" enctype="multipart/form-data"  method="post">
        <input name="name" type="text" class="form-control margin-bottom-10" placeholder="Nome do Produto" value="<?=isset($_POST['name']) ? $_POST['name'] : ''?>" required>
        <textarea name="description" class="form-control margin-bottom-10" placeholder="Descrição do Produto" rows="4" cols="50" required><?=isset($_POST['description']) ? $_POST['description'] : ''?></textarea>
        <div class="margin-bottom-10">
            R$ <input name="value" type="number" class="form-control margin-bottom-10 product-value" placeholder="9" value="<?=isset($_POST['value']) ? $_POST['value'] : ''?>" min="0" required> , 
            <input name="cents" type="number" class="form-control margin-bottom-10 product-value product-cents" placeholder="99" value="<?=isset($_POST['cents']) ? $_POST['cents'] : ''?>" min="0" max="99" required>
            <button name="submit" type="submit" class="btn btn-success margin-10-auto">Adicionar</button>
        </div>
    </form>
</div>                