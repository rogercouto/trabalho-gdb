<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class NoticiaDAO_Mongo extends CI_Model {
    
    function NoticiaDAO_Mongo(){
        $this->load->library('mongo_db');
    }
    /*
     * Converte um objeto Noticia para um array com os parametros do mongo
     */
    private function setNoticia($noticia){
        $mObject = array();
        if (isset($noticia->titulo))
            $mObject['titulo'] = $noticia->titulo;
        if (isset($noticia->texto))    
            $mObject['texto'] = $noticia->texto;
        if (isset($noticia->data_hora_pub))    
            $mObject['data_hora_pub'] = new MongoDate($noticia->data_hora_pub->getTimestamp());
        if (isset($noticia->data_hora_destaque))
            $mObject['data_hora_destaque'] = new MongoDate($noticia->data_hora_destaque->getTimestamp());
        if (isset($noticia->img_mini))
            $mObject['img_mini'] = $noticia->img_mini;
        else
            $mObject['img_mini'] = NULL;
        if (isset($noticia->img_banner))
            $mObject['img_banner'] = $noticia->img_banner;
        else
            $mObject['img_banner'] = NULL;
        if (isset($noticia->tags) && sizeof($noticia->tags)>0)    
            $mObject['tags'] = $noticia->tags;
        if (isset($noticia->fotos) && sizeof($noticia->fotos)>0)    
            $mObject['fotos'] = $noticia->fotos;
        if (isset($noticia->anexos) && sizeof($noticia->anexos)>0)    
            $mObject['anexos'] = $noticia->anexos;
        return $mObject;
    }
    
    /*
     * Insere uma notícia no banco
     */
    function insert($noticia){
        $mObject = $this->setNoticia($noticia);
        $this->mongo_db->insert('noticia', $mObject);
        $noticia->id = $mObject['_id']->{'$id'};
    }

    /*
    * Edita uma notícia no banco
    * Obs: Plugin do mongo do codeigniter não tá aceitando update, então foi necessário excluir e inserir novamente
    */
    function update($noticia){
        $mObject = $this->setNoticia($noticia);
        $this->mongo_db->insert('noticia', $mObject); //insere a noticia editada
        $this->delete($noticia);//apaga a noticia original
        /*
        $mObject['_id'] = new MongoID($noticia->id);
        $this->mongo_db->update('noticia', $mObject);
        */
    }

    /*
    * Exclui uma notícia
    */
    function delete($noticia){
        $this->mongo_db->where('_id', new MongoID($noticia->id));
        $this->mongo_db->delete('noticia');
        $noticia = NULL;
    }

    /*
    * Converte uma notícia como array do mongodb para um objeto Noticia
    */
    private function getNoticia($mObject){
        $noticia = new Noticia();
        $noticia->id = $mObject['_id']->{'$id'};
        if (isset($mObject['titulo']))
            $noticia->titulo = $mObject['titulo'];
        if (isset($mObject['texto']))
            $noticia->texto = $mObject['texto'];
        if (isset($mObject['data_hora_pub'])){
            $st = $mObject['data_hora_pub']->sec;
            $noticia->data_hora_pub = new DateTime("@$st", new DateTimeZone('America/Sao_Paulo'));
        }
        if (isset($mObject['data_hora_destaque'])){
            $st = $mObject['data_hora_destaque']->sec;
            $noticia->data_hora_destaque = new DateTime("@$st", new DateTimeZone('America/Sao_Paulo'));
        }
        if (isset($mObject['img_mini']))
            $noticia->img_mini = $mObject['img_mini'];
        if (isset($mObject['img_banner']))
            $noticia->img_banner = $mObject['img_banner'];
        if (isset($mObject['tags']))
            $noticia->tags = $mObject['tags'];   
        if (isset($mObject['fotos']))
            $noticia->fotos = $mObject['fotos'];
        if (isset($mObject['anexos']))
            $noticia->anexos = $mObject['anexos'];
        return $noticia;
    }

    /**
     * Retorna uma notícia do banco conforme o id
     */
    function get($id){
        $mObject = $this->mongo_db->where('_id', new MongoId($id))->get('noticia')[0];
        return $this->getNoticia($mObject);
    }

    /**
     * Retorna todas as notícias do banco
     */
    function getAll(){
        $this->mongo_db->order_by(array('_id'=>'desc'));
        $array = $this->mongo_db->get('noticia');
        $result = array();
        foreach ($array as $mObject) {                                 
            array_push($result, $this->getNoticia($mObject));
        }
        return $result;
    }

    function busca($busca){
        $regex = new MongoRegex('/'.$busca.'/i');
        $this->mongo_db->where(array('titulo'=> $regex));
        $this->mongo_db->order_by(array('_id'=>'desc'));
        $array = $this->mongo_db->get('noticia');
        $result = array();
        foreach ($array as $dbObject) {
            array_push($result, $this->getNoticia($dbObject));
        }
        $this->mongo_db->where(array('texto'=> $regex));
        $this->mongo_db->order_by(array('_id'=>'desc'));
        $array = $this->mongo_db->get('noticia');
        foreach ($array as $dbObject) {
            array_push($result, $this->getNoticia($dbObject));
        }
        return $result;
    }
    /**
     * Retorna as útlimas $limit notícias do banco
     */
    function getUltimas($limit){
        $this->mongo_db->order_by(array('_id'=>'desc'));
        $this->mongo_db->limit($limit);
        $array = $this->mongo_db->get('noticia');
        $result = array();
        foreach ($array as $mObject) {                                 
            array_push($result, $this->getNoticia($mObject));
        }
        return $result;
    }

    /**
     * Pesquisa somente a notícias em destaque
     */
    function getDestaques(){
        $this->mongo_db->order_by(array('_id'=>'desc'));
        $this->mongo_db->where_gte('data_hora_destaque', new MongoDate(strtotime("now")));
        $array = $this->mongo_db->get('noticia');
        $result = array();
        foreach ($array as $mObject) {                                 
            array_push($result, $this->getNoticia($mObject));
        }
        return $result;
    }

    /**
     * Pesquisa as ultimas $limit notícias que não estão mais em destaque
     */
    private function getNaoDestaques($limit){
        $this->mongo_db->order_by(array('_id'=>'desc'));
        $this->mongo_db->where_lt('data_hora_destaque', new MongoDate(strtotime("now")));
        $this->mongo_db->limit($limit);
        $array = $this->mongo_db->get('noticia');
        $result = array();
        foreach ($array as $mObject) {                                 
            array_push($result, $this->getNoticia($mObject));
        }
        return $result;
    }

    /**
     * Pesquisa as ultimas notícias, agrupando em destaques primeiro
     * $limit: Limite de noticias caso não tenha destaques suficiente
     * Obs: Retorna TODOS os destaques mesmo que seja em maior numero que $limit
     */
    function getUltimasGrp($limit){
        $noticias = $this->getDestaques();
        $cnt = count($noticias);
        $rest = $limit - $cnt;
        if ($rest > 0){
            $noticiasND = $this->getNaoDestaques($rest);
            foreach ($noticiasND as $noticia){
                array_push($noticias, $noticia);
            }
        }
        return $noticias;
    }

    /**
     * Retorna todas as notícias de uma tag estpecífica
     */
    function getNoticiasTag($tag){
        $this->mongo_db->order_by(array('_id'=>'desc'));
        $this->mongo_db->where('tags', $tag);
        $array = $this->mongo_db->get('noticia');
        $result = array();
        foreach ($array as $mObject) {                                 
            array_push($result, $this->getNoticia($mObject));
        }
        return $result;           
    }

    function getTodasTags(){
        return $this->mongo_db->distinct('noticia', 'tags');
    }
}