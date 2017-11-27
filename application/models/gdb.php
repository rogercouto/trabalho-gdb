<?php
/**
 * Classe que usa os métodos de acesso ao banco conforme o banco selecionado no arquivo config.php
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class GDB extends CI_Model {
    
    private $tipoBanco;

    function GDB(){
        $this->tipoBanco = $this->config->item('banco');
        $this->load->model('Anexo');
        $this->load->model('Foto');
        $this->load->model('Noticia');
        $this->load->model('Tag');
        $this->load->model('Usuario');
        $this->load->model('Banner');
        switch ($this->tipoBanco) {
            case 'mysql':
                $this->load->model('NoticiaDAO_Mysql');
                break;
            case 'mongo':
                $this->load->model('NoticiaDAO_Mongo');
                break;
            default:
                break;
        }
    }

    /*
     * Insere uma notícia no banco
     */
    function insertNoticia($noticia){
        switch ($this->tipoBanco) {
            case 'mysql':
                $this->NoticiaDAO_Mysql->insert($noticia);
                break;
            case 'mongo':
                $this->NoticiaDAO_Mongo->insert($noticia);
                break;
            default:
                break;
        }
    }

    /*
    * Edita uma notícia no banco
    */
    function updateNoticia($noticia){
        /*
        echo '<pre>';
        print_r($noticia);
        exit();
        */
        switch ($this->tipoBanco) {
            case 'mysql':
                $this->NoticiaDAO_Mysql->update($noticia);
                break;
            case 'mongo':
                $this->NoticiaDAO_Mongo->update($noticia);
                break;
            default:
                break;
        }
    }

    /**
     * Remove os arquivos da noticia
     */
    private function deleteFiles($noticia){
        if (isset($noticia->img_banner)){
            unlink('upload/banner/'.$noticia->img_banner);
        }
        if (isset($noticia->img_mini)){
            unlink('upload/mini/'.$noticia->img_mini);
        }
        foreach ($noticia->fotos as $foto){
            unlink('upload/fotos/'.$foto);
        }
        foreach ($noticia->anexos as $anexo){
            unlink('upload/anexos/'.$anexo);
        }
    }
    /*
    * Exclui uma notícia
    */
    function deleteNoticia($id){
        switch ($this->tipoBanco) {
            case 'mysql':
                $noticia = $this->NoticiaDAO_Mysql->get($id);
                $this->deleteFiles($noticia);
                $this->NoticiaDAO_Mysql->delete($noticia);
                break;
            case 'mongo':
                $noticia = $this->NoticiaDAO_Mongo->get($id);
                $this->deleteFiles($noticia);
                $this->NoticiaDAO_Mongo->delete($noticia);
                break;
            default:
                break;
        }
    }

    /**
     * Retorna uma notícia do banco conforme o id
     */
    function getNoticia($id){
        switch ($this->tipoBanco) {
            case 'mysql':
                return $this->NoticiaDAO_Mysql->get($id);
                break;
            case 'mongo':
                return $this->NoticiaDAO_Mongo->get($id);
                break;
            default:
                break;
        }
    }

    /**
     * Retorna todas as notícias do banco
     */
    function getNoticias(){
        switch ($this->tipoBanco) {
            case 'mysql':
                return $this->NoticiaDAO_Mysql->getAll();
                break;
            case 'mongo':
                return $this->NoticiaDAO_Mongo->getAll();
                break;
            default:
                break;
        }
    }

    /**
     * Busca notícias no banco
     */
    function buscaNoticias($busca){
        switch ($this->tipoBanco) {
            case 'mysql':
                return $this->NoticiaDAO_Mysql->busca($busca);
                break;
            case 'mongo':
                return $this->NoticiaDAO_Mongo->busca($busca);
                break;
            default:
                break;
        }
    }

    /**
     * Retorna as útlimas $limit notícias do banco
     */
    function getUltimasNoticias($limit){
        switch ($this->tipoBanco) {
            case 'mysql':
                return $this->NoticiaDAO_Mysql->getUltimas($limit);
                break;
            case 'mongo':
                return $this->NoticiaDAO_Mongo->getUltimas($limit);
                break;
            default:
                break;
        }
    }

    /**
     * Pesquisa somente a notícias em destaque
     */
    function getNoticiasDestaque(){
        switch ($this->tipoBanco) {
            case 'mysql':
                return $this->NoticiaDAO_Mysql->getDestaques();
                break;
            case 'mongo':
                return $this->NoticiaDAO_Mongo->getDestaques();
                break;
            default:
                break;
        }
    }

    /**
     * Pesquisa as ultimas notícias, agrupando em destaques primeiro
     * $limit: Limite de noticias caso não tenha destaques suficiente
     * Obs: Retorna TODOS os destaques mesmo que seja em maior numero que $limit
     */
    function getNoticiasPortal($limit){
        switch ($this->tipoBanco) {
            case 'mysql':
                return $this->NoticiaDAO_Mysql->getUltimasGrp($limit);
                break;
            case 'mongo':
                return $this->NoticiaDAO_Mongo->getUltimasGrp($limit);
                break;
            default:
                break;
        }
    }

    function getBanners($noticias){
        return $this->Banner->getBanners($noticias);
    }
    /**
     * Retorna tags de uma lista de noticias
     */
    function getTags($noticias){
        switch ($this->tipoBanco) {
            case 'mysql':
                return $this->NoticiaDAO_Mysql->getTags($noticias);
                break;
            case 'mongo':
                return $this->NoticiaDAO_Mongo->getTags($noticias);
                break;
            default:
                break;
        }
    }

    /**
     * Retorna todas as tags do banco
     */
    function getTodasTags(){
        switch ($this->tipoBanco) {
            case 'mysql':
                return $this->NoticiaDAO_Mysql->getTodasTags();
                break;
            case 'mongo':
                return $this->NoticiaDAO_Mongo->getTodasTags();
                break;
            default:
                break;
        }
    }
    /**
     * Retorna as notícias que contém determinada tag
     */
    function getNoticiasTag($tag){
        $noticiasMenu = array();
        switch ($this->tipoBanco) {
            case 'mysql':
                $noticiasMenu = $this->NoticiaDAO_Mysql->getNoticiasTag($tag);
                break;
            case 'mongo':
                $noticiasMenu = $this->NoticiaDAO_Mongo->getNoticiasTag($tag);
                break;
            default:
                break;
        }
        if (count($noticiasMenu) > 0){
            usort(
                $noticiasMenu,
                function( $n1, $n2 ) {
                    if( $n1->titulo == $n2->titulo ) return 0;
                    return ( ( $n1->titulo < $n2->titulo ) ? -1 : 1 );
                }
            );
        }
        return $noticiasMenu;
    }

    function validaUsuario($usuario){
        $tipoBanco = $this->config->item('banco');
        switch ($tipoBanco) {
            case 'mysql':
                return $this->valida_mysql($usuario->login, $usuario->senha);
                break;
            case 'mongo':
                return $this->valida_mongo($usuario->login, $usuario->senha);
                break;
            default:
                break;
        }
    }

    private function valida_mysql($login, $senha){
        $result = $this->db->query("select * from usuario where login = '$login' and senha = md5('$senha')")->result();
        if (count($result)==1){
            return TRUE;
        }
        return FALSE;
    }

    private function valida_mongo($login, $senha){
        $this->mongo_db->where(array('login'=> $login));
        $result = $this->mongo_db->get('usuario');
        if (count($result)==1){
            $usuario = $result[0];
            if (isset($usuario['senha']) && $usuario['senha'] === md5($senha))
                return TRUE;
        }
        return FALSE;
    }

}