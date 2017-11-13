<div class="col-md-12">
    <div class="card">
        <?php if (isset($noticia->titulo) && strlen($noticia->titulo) > 0 && (!$noticia->inMenuSobre())): ?>
            <div class="card-title"><h1><?=$noticia->titulo?></h1></div>
        <?php endif; ?>
        <div class="card-body">
            <?php if (isset($noticia->texto) && strlen(trim($noticia->texto))>0): ?>
                <?php if (isset($noticia->titulo) && strlen($noticia->titulo) > 0 && (!$noticia->inMenuSobre())) echo '<hr />'?>
                <?=$noticia->texto?>
            <?php endif; ?>
            <!-- Galeria de fotos -->
            <?php if (isset($noticia->fotos) && count($noticia->fotos) > 0): ?>
            <hr />
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <?php
                    $count = 0;
                    foreach ($noticia->fotos as $foto){
                        if ($count % 3 == 0)
                            echo '<div class="row">';
                        echo '<a href="';
                        echo base_url('');
                        echo 'upload/fotos/';
                        echo $foto;
                        echo '" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">';
                        echo '<img style="height: 200px" src="';
                        echo base_url('');
                        echo 'upload/fotos/';
                        echo $foto;
                        echo '" class="img-fluid"></a>';
                        $count++;
                        if ($count % 3 == 0){
                            echo '</div>';
                            echo '<div class="row">&nbsp;</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>
            <!-- Galeria de fotos -->

            <?php if (isset($noticia->anexos) && count($noticia->anexos) > 0): ?>
                <div class="container">
                <hr/>
                <?php $index = 0; foreach ($noticia->anexos as $anexo) : ?>
                    <p><a target="_blank" href="<?=base_url()?>upload/anexos/<?=$anexo?>">Anexo <?=($index+1)?></a></p>
                <?php $index++; endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
        <?php if (!isset($menu_sobre)): ?>
        <hr />
        <div class="card-subtitle">Publicado em: <?=$noticia->data_hora_pub->format('d/m/Y')?></div>
        <?php endif; ?>
    </div>
</div>