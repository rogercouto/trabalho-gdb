<div style="width: 400px">
    <form action="<?=site_url('adm/entrar')?>" method="POST">
        <div class="form-group">
            <label for="titulo">Usu&aacute;rio:</label>
            <input type="text" class="form-control" id="login" name="login" value="<?=(isset($login)? $login :"")?>" />
        </div>
        <div class="form-group">
            <label for="titulo">Senha:</label>
            <input type="password" class="form-control" id="senha" name="senha" />
        </div>
        <?php if (isset($erro)) : ?>
            <div class="form-group">
                <span style="color: red"><?=$erro?></span>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <input type="submit" id="salvar" name="entrar" value="Entrar">
        </div>
    </form>
</div>