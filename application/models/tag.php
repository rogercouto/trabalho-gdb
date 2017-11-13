<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classe usada somente com o banco mysql
 */
class Tag extends CI_Model {

    public $tag_id = NULL;
    public $nome = NULL;
        
    function getTags($noticia_id){
        $result = $this->db->query("select nome from tag_noticia JOIN 
            tag on tag.tag_id = tag_noticia.tag_id where noticia_id = $noticia_id")->result();
        $tags = array();
        foreach($result as $obj){
            array_push($tags, $obj->nome);
        }
        return $tags;
    }

}