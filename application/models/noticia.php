<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Noticia extends CI_Model {

    public $id = NULL;
    public $titulo = NULL;
    public $texto = NULL;
    public $data_hora_pub = NULL;
    public $data_hora_destaque = NULL;
    public $img_mini = NULL;
    public $img_banner = NULL;

    public $tags  = array();
    public $fotos  = array();
    public $anexos  = array();

    //Campos para controlar update (somente mysql)
    public $updateTags = FALSE;
    public $updateFotos = FALSE;
    public $updateAnexos = FALSE;
    
    function updateTags(){
        return $this->updateTags;
    }
    function updateFotos(){
        return $this->updateFotos;
    }
    function updateAnexos(){
        return $this->updateAnexos;
    }

    function addTag($tag){
        array_push($this->tags, $tag);
        $this->updateTags = TRUE;
    }
    function removeTag($index){
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags);
        $this->updateTags = TRUE;
    }

    function addFoto($arquivo){
        array_push($this->fotos, $arquivo);
        $this->updateFotos = TRUE;
    }
    function removeFoto($index){
        unset($this->fotos[$index]);
        $this->fotos = array_values($this->fotos);
        $this->updateFotos= TRUE;
    }


    function addAnexo($arquivo){
        array_push($this->anexos, $arquivo);
        $this->updateAnexos = TRUE;
    }
    function removeAnexo($index){
        unset($this->anexos[$index]);
        $this->anexos = array_values($this->anexos);
        $this->updateAnexos = TRUE;
    }

    /**
     * Verifica se uma tag já está presente no array de tags
     * Retorna um boolean
     */
    private static function isIn($tag, $tags){
        foreach ($tags as $string){
            if ($string === $tag)
                return true;
        }
        return false;
    }
    /**
     * Retorna tags de uma lista de noticias
     */
    static function getTags($noticias){
        $tags = array();
        foreach ($noticias as $noticia){
            foreach ($noticia->tags as $tag){
                if (!Noticia::isIn($tag, $tags))
                    array_push($tags, $tag);
            }
        }
        sort($tags);
        return $tags;
    }

    function getTagsValue(){
        $value = "";
        $count = 0;
        foreach ($this->tags as $tag){
            if ($count > 0)
                $value .= "; ";
            $value .= $tag;
            $count++;
        }
        return $value;
    }

    function inMenu(){
        if (count($this->tags)==1 && ($this->tags[0] === 'Sobre' || $this->tags[0] === 'Menu'))
            return TRUE;
        return FALSE;
    }

    function setTagsValue($value){
        if (strlen(trim($value)) == 0){
            $this->tags = array();
            $this->updateTags = TRUE;
            return;
        }
        $tags = explode(';', $value);
        foreach ($tags as $tag){
            $this->addTag(trim($tag));
        }
        $this->updateTags = TRUE;
    }

    function removeTags(){
        $this->tags = array();
        $this->updateTags();
    }

    const TAM_RESUMO = 300;

    private static function resume($string, $tam){
        $openTag = FALSE;
        $openEsp = FALSE;
        $count = 0;
        $tmpString = "";
        $tmpCount = 0;
        $result = "";
        for ($i = 0; $i < strlen($string); $i++){
            if (!$openTag && $string[$i] == '<')
                $openTag = TRUE;
            if (!$openEsp && $string[$i] == '&')
                $openEsp = TRUE;
            if (!$openTag && !$openEsp){
                $count++;
                $result .= $string[$i];
            }else{
                $tmpString .= $string[$i];
                $tmpCount++;
            }
            if ($count == $tam)
                break;
            if ($openTag && $string[$i] == '>'){
                $result .= $tmpString;
                $openTag = FALSE;
                $tmpString = "";
                $tmpCount = 0;
            }
            if ($string[$i] == ';'){
                $result .= $tmpString;
                $openEsp = FALSE;
                $tmpString = "";
                $tmpCount = 0;
            }
        }
        return $result;
    }

    function getResumo(){
        if (strlen($this->texto) <= $this::TAM_RESUMO)
            return $this->texto;
        $resumo = self::resume(strip_tags($this->texto), self::TAM_RESUMO);
        $resumo .= '<a href="'.site_url('Welcome/mostra_noticia/'.$this->id).'"> Ler tudo...</a>';
        return $resumo;
    }

}