<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Area restrita</title>
        <!-- Make sure the path to CKEditor is correct. -->
        <script src="<?=base_url()?>ckeditor/ckeditor.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <!--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        -->
    </head>
    <body>
        <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
            <span style="color: white;width: 140px"><a class="navbar-brand" href="<?=site_url('adm')?>"><?=(isset($title)?$title:"?")?></a></span>

            <?php if (isset($this->session->login)): ?>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">&nbsp;</a>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <!--
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Noticias</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="<?=site_url('adm/lst_noticia')?>">Listar</a>
                            <a class="dropdown-item" href="<?=site_url('adm/ins_noticia')?>">Inserir</a>
                        </div>
                    </li>
                    <!--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usu&aacute;rios</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="#">Listar</a>
                            <a class="dropdown-item" href="#">Inserir</a>
                        </div>
                    </li>
                    <li class="nav-item" style="width: 800px">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=site_url('adm/logout')?>">Sair</a>
                    </li>
                    -->
                </ul>
            </div>

            <?php endif; ?>
        </nav>
        <br />
        <br />
        <br />
        <div class="container">
            <?php
                $this->load->view($body);
            ?>
        </div>
        <br /><br />
        <footer class="fixed-bottom" style="background-color: black">
            <div class="container" style="text-align: right">
                <span class="text-muted"><a style="color: #AAAAAA" href="<?=site_url('adm/logout')?>">Sair</a></span>
            </div>
        </footer>
    </body>
</html>