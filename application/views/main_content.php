<div id="div_banner" class="row">
    <?php if (count($banners)> 0 ):?>
        <div class="col-md-12">
            <!-- Banner -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    $index = 0;
                    foreach($banners as $banner){
                        echo '<li data-target="#carouselExampleIndicators" data-slide-to="';
                        echo $index;
                        echo '"';
                        if ($index == 0)
                            echo ' class="active"';
                        echo '></li>';
                        $index++;
                    }
                    ?>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <?php

                    $index = 0;
                    foreach($banners as $banner){
                        echo '<div class="carousel-item';
                        if ($index == 0)
                            echo ' active';
                        echo '"><a href="';
                        echo site_url('Welcome/mostra_noticia/');
                        echo $banner->noticia->id;
                        echo '"><img class="d-block img-fluid" src="';
                        echo base_url();
                        echo 'upload/banner/';
                        echo $banner->arquivo;
                        echo '" style="width:1050px;height:200px" alt="';
                        echo $banner->noticia->titulo;
                        echo '"></div>';
                        $index++;
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- /Banner -->
            <br />
        </div>
    <?php endif; ?>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Not&iacute;cias</h4>
                <table class="table" >
                    <tbody>
                    <?php foreach ($noticias as $noticia): if (strlen($noticia->titulo)==0 || $noticia->inMenu()) continue; ?>
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
        <div class="container" style="text-align: right">
            <br/>
            <button class="btn btn-secondary" onclick="location.href='<?=site_url('Welcome/lista_noticias')?>';">Mostrar todas</button>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Busca</h4>
                <form class="form-inline" method="post" action="<?=site_url('Welcome/busca_texto')?>">
                    <div class="form-group row">
                        <input class="form-control" type="text" placeholder="Texto" size="15" name="texto">
                        <button class="btn btn-secondary" type="submit">Pesquisar</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="card_tags" class="card">
            <div class="card-body">
                <h4 class="card-title">Tags</h4>
                <?php foreach ($tags as $tag): if ($tag == 'Sobre'||$tag=='Menu') continue; ?>
                    <form method="post" action="<?=site_url('Welcome/busca_tag/')?>">
                        <input class="form-control" type="hidden" name="tag" value="<?=$tag?>">
                        <button class="btn btn-secondary" type="submit"><?=$tag?></button>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="card_agenda" class="card">
            <div class="card-body">
                <h4 class="card-title">Agenda</h4>
                <div class="responsive-iframe-container small-container">
                    <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=uabrestingaseca%40gmail.com&amp;color=%232952A3&amp;ctz=America%2FSao_Paulo" style="border-width:0" width="275" height="400" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>