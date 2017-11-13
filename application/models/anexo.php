<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classe usada somente com o banco mysql
 */
class Anexo extends CI_Model {

    public $noticia_id = NULL;
    public $arquivo = NULL;

    /**
     * Retorna as anexos de uma notícia 
     * return: array de strings
     */
    function getAnexos($noticia_id){
        $this->db->where("noticia_id = $noticia_id");
        $array = $this->db->get('anexo')->result();
        $anexos = array();
        foreach ($array as $obj){
            array_push($anexos, $obj->arquivo);
        }
        return $anexos;
    }
        
    /**
     * Insere as anexos da noticia
     */
    function insertAnexos($noticia){
        if (isset($noticia->anexos)){
            foreach ($noticia->anexos as $arquivo){
                $anexo = new Anexo();
                $anexo->noticia_id = $noticia->id;
                $anexo->arquivo = $arquivo;
                $this->db->insert('anexo', $anexo);
            }
        }
    }

    /**
     * Atualiza as anexos da noticia
     */
    function updateAnexos($noticia){
        $this->db->query('delete from anexo where noticia_id = '.$noticia->id);
        $this->insertAnexos($noticia);
    }

}