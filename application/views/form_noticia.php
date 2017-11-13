<form id="formNoticia" data-toggle="validator" role="form" enctype="multipart/form-data" action="<?=site_url('adm').'/'.(isset($op)? $op :"#")?>" method="POST">
    <?php
        if (isset($noticia) && isset($noticia->id)){
            echo '<input name="id" type="hidden" value="'.$noticia->id.'">';
        }
    ?>
    <div class="form-group">
        <label for="titulo" class="control-label"><b>Titulo:</b></label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="<?=(isset($noticia)? $noticia->titulo :"")?>">
        </div>
    <div class="form-group">
        <label for="titulo" class="control-label"><b>Conte&uacute;do:</b></label>
        <!-- https://ckeditor.com/ckeditor-4/download/ -->
        <textarea name="texto" id="textoNoticia" rows="10" cols="80">
            <?=(isset($noticia)? $noticia->texto :"")?>
        </textarea>
        </div>
    <div class="form-group">
        <label for="destaque" class="control-label"><b>Destacar at&eacute;:</b></label>
        <input type="date" class="form-control" id="date" name="destaque"<?=(isset($noticia)? ' value="'.$noticia->data_hora_destaque->format('Y-m-d').'"' :"")?>">
        <!--<input id="destaque" name="destaque" type="date" required>-->
    </div>
    <div class="form-group">
        <label for="titulo"><b>Tags( separado por ; ):</b></label>
        <input type="text" class="form-control" id="tags" name=" tags"<?=(isset($noticia)? 'value="'.$noticia->getTagsValue().'"' :"")?>>
    </div>
    <div class="form-group">
        <label for="mini"><b>Miniatura</b> (150px x 150px):</label>
        <?php
            if (isset($noticia) && isset($noticia->img_mini)){
                echo '<div class="form-control">';
                echo '<input type="checkbox" name="exc_mini" value=1 />Excluir<br />';
                echo '<img width="150px" src="';
                echo base_url();
                echo 'upload/mini/';
                echo $noticia->img_mini;
                echo '" /></div>';
                echo '<b>Substituir:</b>';
            }
        ?>
        <input type="file" class="form-control" id="mini" name="mini" accept="image/*">
    </div>
    <div class="form-group">
        <label for="fotos"><b>Imagem banner</b> (960px x 150px):</label>
        <?php
        if (isset($noticia) && isset($noticia->img_banner)){
            echo '<div class="form-control">';
            echo '<input type="checkbox" name="exc_banner" value=1 />Excluir<br />';
            echo '<img width="960px" height="150px" src="';
            echo base_url();
            echo 'upload/banner/';
            echo $noticia->img_banner;
            echo '" /></div>';
            echo '<b>Substituir:</b>';
        }
        ?>
        <input type="file" class="form-control" id="banner" name="banner" accept="image/*">
    </div>
    <div class="form-group">
        <label for="fotos"><b>Fotos:</b></label>
        <?php
            if (isset($noticia) && isset($noticia->fotos) && count($noticia->fotos) > 0){
                echo '<div class="form-control"><div class="row">';
                $index = 0;
                foreach ($noticia->fotos as $foto){
                    echo '<div class="col-sm-4">';
                    echo '<input type="checkbox" name="excluir_foto_';
                    echo $index;
                    echo '" value="';
                    echo $foto;
                    echo '" />Excluir';
                    echo '<a target="_blank" href="';
                    echo base_url();
                    echo 'upload/fotos/';
                    echo $foto;
                    echo '">';
                    echo '<img width="300px" src="';
                    echo base_url();
                    echo 'upload/fotos/';
                    echo $foto;
                    echo '" />';
                    echo '</a>';
                    echo '</div>';
                    $index++;
                }
                echo '</div></div>';
                echo '<b>Adicionar:</b>';
            }
        ?>
        <input type="file" class="form-control" multiple id="fotos" name="fotos[]" accept="image/*">
    </div>

    <div class="form-group">
        <label for="anexos"><b>Anexos:</b></label>
        <?php
        if (isset($noticia) && isset($noticia->anexos) && count($noticia->anexos) > 0){
            echo '<div class="form-control"><div class="row">';
            $index = 0;
            foreach ($noticia->anexos as $anexo){
                echo '<div class="col-sm-4">';
                echo '<a target="_blank" href="';
                echo base_url();
                echo 'upload/anexos/';
                echo $anexo;
                echo '">';
                echo 'anexo';
                echo ($index+1);
                echo '</a><br />';
                echo '<input type="checkbox" name="excluir_anexo_';
                echo $index;
                echo '" value="1" />Excluir';
                echo '</div>';
                $index++;
            }
            echo '</div></div>';
            echo '<b>Adicionar:</b>';
        }
        ?>
        <input type="file" class="form-control" multiple id="anexos" name="anexos[]">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">Salvar</button>
        <button type="button" class="btn btn-primary btn-md" onclick="location.href='<?=site_url('adm/lst_noticia/')?>';">Cancelar</button>
    </div>
    <!--
    <div class="form-group">
        <input type="submit" id="salvar" name="salvar" value="Salvar">
    </div>
    -->
    <script>
        CKEDITOR.replace( 'textoNoticia' );
    </script>
</form>