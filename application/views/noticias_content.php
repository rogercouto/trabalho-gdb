<h4 class="card-title" style="margin: 20px"><?=$title?></h4>
<div class="col-md-12" style="height: 600px;overflow: scroll">
    <div class="card">
        <div class="card-body">
            <table class="table" >
                <tbody>
                <?php foreach ($noticias as $noticia): if (strlen($noticia->titulo) == 0 || $noticia->inMenu()) continue; ?>
                    <tr class="tr_noticia">
                        <?php if (isset($noticia->img_mini)): ?>
                            <td style="width: 150px">
                                <img src="<?=base_url()?>upload/mini/<?=$noticia->img_mini?>" width="150px" height="150px" />
                            </td>
                        <?php endif; ?>
                        <td<?php if (!isset($noticia->img_mini))echo ' colspan="2"';?>>
                            <a href="<?=site_url('Welcome/mostra_noticia/'.$noticia->id)?>"><?=$noticia->titulo?></a><hr />
                            <?=$noticia->getResumo()?>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>