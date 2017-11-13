<h2><?=$message?></h2>
<p>
<form action="<?=$action?>" method="post">
    <input type="hidden" name="value" value="<?=$value?>">
    <button type="submit" class="btn btn-warning btn-md">Sim</button>
    <button type="button" class="btn btn-primary btn-md" onclick="location.href='<?=site_url('adm/lst_noticia/')?>';">Cancelar</button>
</form>
</p>