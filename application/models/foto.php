<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classe usada somente com o banco mysql
 */
class Foto extends CI_Model {

    public $noticia_id = NULL;
    public $arquivo = NULL;

    /**
     * Retorna as fotos de uma notícia 
     * return: array de strings
     */
    function getFotos($noticia_id){
        $this->db->where("noticia_id = $noticia_id");
        $array = $this->db->get('foto')->result();
        $fotos = array();
        foreach ($array as $obj){
            array_push($fotos, $obj->arquivo);
        }
        return $fotos;
    }
        
    /**
     * Insere as fotos da noticia
     */
    function insertFotos($noticia){
        foreach ($noticia->fotos as $arquivo){
            $foto = new Foto();
            $foto->noticia_id = $noticia->id;
            $foto->arquivo = $arquivo;
            $this->db->insert('foto', $foto);
        }
    
    }

    /**
     * Atualiza as fotos da noticia
     */
    function updateFotos($noticia){
        $this->db->query('delete from foto where noticia_id = '.$noticia->id);
        $this->insertFotos($noticia);
    }

}