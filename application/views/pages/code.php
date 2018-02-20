<!-- HEADER -->

<!-- NAVIGATION -->

<!-- PAGE CONTENT -->
<div id="page-content">
    <div class="container">
      <div class="col-md-12 padding-top-100">
        <h2 class="col-md-12 margin-bottom-30 text-align-center">Gerar Código</h2>
        
        <?php if(!$error) { ?>
            <a class="btn btn-success margin-bottom-30" href="#" onclick="generateCode();">Gerar Código</a>
            <?php if(isset($_GET['override']) && $_GET['override']) { ?>
                <p class="text-green">Código gerado com sucesso.</p>
            <? } ?>
            <?php if($hasCode) { ?>
                <p class="text-red">ATENÇÃO: Você já tem um código gerado. Ao gerar novamente, o anterior será invalidado e um novo código será gerado.</p>
                <textarea id="code" name="code" rows="3" class="form-control margin-bottom-10"><?=$code?></textarea>
            <?php } else { ?>
                <p class="text-green">Você não gerou nenhum código.</p>
                <textarea id="code" name="code" rows="3" class="form-control margin-bottom-10"></textarea>
            <? } ?>
            <input type="hidden" id="id" name="id" value="<?=$user->id?>">
            <a class="btn btn-primary margin-bottom-20" href="#" onclick="copyToClipboard();">Copiar</a>
            <div id="copyMesssage"></div>
        <?php } else { ?>
            <p>Ocorreu um erro ao gerar seu código.<br>Por favor, tente novamente.</p>
            <a class="btn btn-primary margin-bottom-20" href="/code"">Tentar Novamente</a>
        <? } ?>
      </div>
    </div>
</div>

<!-- FOOTER -->