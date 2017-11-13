<h1>Not&iacute;cias</h1>
<?php
    if (isset($msg)){
        echo $msg;
    }
?>
<button type="button" class="btn btn-primary btn-md" onclick="location.href='<?=site_url('adm/ins_noticia')?>';">Inserir</button>
<div align="right">
    <form method="post" action="<?=site_url('adm/busca_noticias')?>">
    <input type="text" name="busca" />
    <button type="submit" class="btn btn-primary btn-md" onclick="location.href='<?=site_url('adm/busca_noticia')?>';">
        <i class="fa fa-search" aria-hidden="true"></i>Buscar
    </button>
    </form>
</div>
<br />
<br />
<table class="table table-striped">
  <thead>
    <tr>
        <th>ID</th>
        <th>Publicado em</th>
        <th>T&iacute;tulo</th>
        <th>Op&ccedil;&otilde;es</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($noticias as $noticia): ?>
    <tr>
        <td><?=$noticia->id?></td>
        <td><?=$noticia->data_hora_pub->format('d/m/Y H:i:s')?></td>
        <td><?=(strlen($noticia->titulo)>0?$noticia->titulo:'( sem t&iacute;tulo )')?></td>
          <td>
              <button type="button" class="btn btn-warning btn-md" onclick="location.href='<?=site_url('adm/edt_noticia/').$noticia->id?>';">Editar</button>
              <button type="button" class="btn btn-danger btn-md" onclick="location.href='<?=site_url('adm/exc_noticia/').$noticia->id?>';">Excluir</button>
          </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>