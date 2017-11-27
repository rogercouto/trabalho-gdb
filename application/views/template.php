<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Polo Educacional Superior de Restinga S&ecirc;ca</title>
    <!-- Bootstrap  Jquery -->
    <link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
    <script src="<?=base_url()?>js/jquery-3.1.1.slim.min.js"></script>
    <script src="<?=base_url()?>js/tether.min.js"></script>
    <script src="<?=base_url()?>js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>js/ekko-lightbox.min.js"></script>
    <link href="<?=base_url()?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url()?>css/ekko-lightbox.css" rel="stylesheet">
    <!-- Estilo customizado -->
    <link href="<?=base_url()?>css/estilo.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <img id="header" src="<?=base_url()?>img/header_polo.png" />
    </div>
    <!--Menu principal -->
    <div class="container">
        <!--<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">-->
        <nav class="navbar navbar-toggleable-md navbar-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
              <a class="navbar-brand" href="#">&nbsp;</a>
              <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                  <li class="nav-item <?php if (!isset($content)) echo ' active';?>">
                    <a class="nav-link" href="<?=base_url()?>">Home
                        <?php if (!isset($content)): ?>
                            <span class="sr-only">(current)</span>
                        <?php endif; ?>
                    </a>
                  </li>
                    <li class="nav-item <?php if (isset($content)&&$content=='agenda') echo ' active';?>">
                    <a class="nav-link" href="<?=site_url('Welcome/agenda')?>">Agenda</a>
                  </li>
                    <?php foreach($noticiasMenu as $nm):?>
                        <li class="nav-item <?php if (isset($content)&&$content=='noticia_content'&&(isset($noticia)&&$noticia->id==$nm->id)) echo ' active';?>">
                            <a class="nav-link" href="
                                    <?=site_url('Welcome/mostra_noticia/'.$nm->id)?>
                                "><?=$nm->titulo?></a>
                        </li>
                    <?php endforeach;?>
                    <li class="nav-item dropdown">
                        <a<?php if (isset($menu_active)) echo ' style="color: white"';?> class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sobre o polo</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <?php foreach($noticiasSobre as $ns):?>
                                <a class="dropdown-item" href="
                                        <?=site_url('Welcome/mostra_noticia/'.$ns->id)?>
                                    "><?=$ns->titulo?></a>
                            <?php endforeach;?>
                            <!--<a class="dropdown-item" href="#">Contato</a>-->
                        </div>
                    </li>
                </ul>
                
              </div>    
        </nav>
    </div>
    <!-- /Menu principal -->
    <!-- Conteudo -->
    <div class="container">
        <div id="content" class="container-fluid">
            <?php
                if (isset($content)){
                    $this->load->view($content);
                }else{
                    $this->load->view('main_content');
                }
            ?>
        </div>
    </div>
    <!-- /Conteudo -->
    <!-- Rodape -->
    <div class="container">
        <div class="footer navbar-bottom navbar-inverse">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <p>
                        Polo Educacional Superior de Restinga S&ecirc;ca<br/>
                        Rua: José Celestino Alves - 134, Bairro: Centro <br/>Restinga S&ecirc;ca - RS Cep: 97200-000</p>
                    </div>
                    <div class="col-sm-4">
                        <p>Telefone: (55) 3261-4778<br/>
                        E-mail: uabrestingaseca@gmail.com</p>
                    </div>
                    <div class="col-sm-4">
                        <p>Facebook:</p>
                        <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fuabrestingaseca%2F&width=300&layout=standard&action=like&size=large&show_faces=true&share=true&height=80&appId" width="300" height="80" style="font-color:#FFF; border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                    </div>
                </div>
            </div>
            <div class="container">
                <p style="width: 100%;text-align: center">
                    <a href="<?=base_url()?>index.php/adm">&Aacute;rea restrita</a>
                </p>
            </div>
        </div>
    </div>
    </div>
    <!-- /Rodape -->
    <script type="text/javascript">
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
  </body>
  </html>