<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class NoticiaDAO_Mysql extends CI_Model {
    
    function NoticiaDAO_Mysql(){
        $this->load->database();
    }
    /**
     * Converte um objeto Noticia para um array com os parametros do mongo
     */
    private function setNoticia($noticia){
        $dbObject = array();
        if (isset($noticia->titulo))
            $dbObject['titulo'] = $noticia->titulo;
        if (isset($noticia->texto))    
            $dbObject['texto'] = $noticia->texto;
        if (isset($noticia->data_hora_pub))    
            $dbObject['data_hora_pub'] = date('Y-m-d h:i:s', $noticia->data_hora_pub->getTimestamp());
        if (isset($noticia->data_hora_destaque))
            $dbObject['data_hora_destaque'] = date('Y-m-d h:i:s', $noticia->data_hora_destaque->getTimestamp());
        if (isset($noticia->img_mini))
            $dbObject['img_mini'] = $noticia->img_mini;
        else
            $dbObject['img_mini'] = NULL;
        if (isset($noticia->img_banner))
            $dbObject['img_banner'] = $noticia->img_banner;
        else
            $dbObject['img_banner'] = NULL;
        return $dbObject;
    }
    
    /**
     * Verifica se uma tag já está presente no array de tags
     * Retorna um boolean
     */
    private function isIn($tag, $tags){
        foreach ($tags as $string){
            if ($string === $tag)
                return true;
        }
        return false;
    }

    /*
     * Insere uma notícia no banco
     */
    function insert($noticia){
        $dbObject = $this->setNoticia($noticia);
        $this->db->insert('noticia', $dbObject);
        $noticia->id = $this->db->insert_id();
        foreach ($noticia->tags as $tag){
            $result = $this->db->get_where('tag', array('nome' => $tag))->result();
            $tag_id = 0;
            if (isset($result) && count($result) == 1){
                $tag_id = $result[0]->tag_id;
            }else{
                $dbObjectTag = array();
                $dbObjectTag['nome'] = $tag;
                $this->db->insert('tag', $dbObjectTag);
                $tag_id = $this->db->insert_id();
            }
            $dbObjectTagNoticia = array();
            $dbObjectTagNoticia['noticia_id'] = $noticia->id;
            $dbObjectTagNoticia['tag_id'] = $tag_id;
            $this->db->insert('tag_noticia', $dbObjectTagNoticia);
        }
        if (isset($noticia->fotos) && count($noticia->fotos)>0){
            $this->Foto->insertFotos($noticia);
        }
        if (isset($noticia->anexos) && count($noticia->anexos)>0){
            $this->Anexo->insertAnexos($noticia);
        }
        
    }

    /*
    * Edita uma notícia no banco
    */
    function update($noticia){
        $dbObject = $this->setNoticia($noticia);
        $this->db->where('noticia_id', $noticia->id);
        $this->db->update('noticia', $dbObject);
        $this->db->query('delete from tag_noticia where noticia_id = '.$noticia->id);
        foreach ($noticia->tags as $tag){
            $result = $this->db->get_where('tag', array('nome' => $tag))->result();
            $tag_id = 0;
            if (isset($result) && count($result) == 1){
                $tag_id = $result[0]->tag_id;
            }else{
                $dbObjectTag = array();
                $dbObjectTag['nome'] = $tag;
                $this->db->insert('tag', $dbObjectTag);
                $tag_id = $this->db->insert_id();
            }
            $dbObjectTagNoticia = array();
            $dbObjectTagNoticia['noticia_id'] = $noticia->id;
            $dbObjectTagNoticia['tag_id'] = $tag_id;
            $this->db->insert('tag_noticia', $dbObjectTagNoticia);
        }
        $this->db->query('delete from tag where tag_id not in (select tag_id from tag_noticia)');
        if ($noticia->updateFotos() && isset($noticia->fotos) && count($noticia->fotos)>0){
            $this->Foto->updateFotos($noticia);
        }
        if ($noticia->updateAnexos() && isset($noticia->anexos) && count($noticia->anexos)>0){
            $this->Anexo->updateAnexos($noticia);
        }
    }

    /*
    * Exclui uma notícia
    */
    function delete($noticia){
        $this->db->query('delete from tag_noticia where noticia_id = '.$noticia->id);
        $this->db->query('delete from tag where tag_id not in (select tag_id from tag_noticia)');
        $this->db->query('delete from foto where noticia_id = '.$noticia->id);
        $this->db->query('delete from anexo where noticia_id = '.$noticia->id);
        $this->db->where('noticia_id', $noticia->id);
        $this->db->delete('noticia');
        $noticia = NULL;
    }


    /*
    * Converte uma notícia retornada do mysql para um objeto Noticia
    */
    private function getNoticia($dbObject){
        $noticia = new Noticia();
        $noticia->id = $dbObject->noticia_id;
        if (isset($dbObject->titulo))
            $noticia->titulo = $dbObject->titulo;
        if (isset($dbObject->texto))
            $noticia->texto = $dbObject->texto;
        if (isset($dbObject->data_hora_pub))
            $noticia->data_hora_pub = new DateTime($dbObject->data_hora_pub, new DateTimeZone('America/Sao_Paulo'));
        if (isset($dbObject->data_hora_destaque))
            $noticia->data_hora_destaque = new DateTime($dbObject->data_hora_destaque, new DateTimeZone('America/Sao_Paulo'));
        if (isset($dbObject->img_mini))
            $noticia->img_mini = $dbObject->img_mini;
        if (isset($dbObject->img_banner))
            $noticia->img_banner = $dbObject->img_banner;
        //tags
        $noticia->tags = $this->Tag->getTags($noticia->id);
        //fotos
        $noticia->fotos = $this->Foto->getFotos($noticia->id);
        //anexos
        $noticia->anexos = $this->Anexo->getAnexos($noticia->id);
        /*
        */
        return $noticia;
    }

    /**
     * Retorna uma notícia do banco conforme o id
     */
    function get($id){
        $this->db->where('noticia_id', $id);
        $array = $this->db->get('noticia')->result();
        if (count($array) == 1)
            return $this->getNoticia($array[0]);
        return NULL;
    }
  
    /**
     * Retorna todas as notícias do banco
     */
    function getAll(){
        $this->db->order_by('noticia_id','desc');
        $array = $this->db->get('noticia')->result();
        $result = array();
        foreach ($array as $dbObject) {                                 
            array_push($result, $this->getNoticia($dbObject));
        }
        return $result;
    }

    function busca($busca){
        $this->db->where('titulo like ', '%'.$busca.'%');
        $this->db->or_where('texto like ', '%'.$busca.'%');
        $this->db->order_by('noticia_id','desc');
        $array = $this->db->get('noticia')->result();
        $result = array();
        foreach ($array as $dbObject) {
            array_push($result, $this->getNoticia($dbObject));
        }
        return $result;
    }
    /**
     * Retorna as útlimas $limit notícias do banco
     */
    function getUltimas($limit){
        $this->db->order_by('noticia_id','desc');
        $this->db->limit($limit);
        $array = $this->db->get('noticia')->result();
        $result = array();
        foreach ($array as $dbObject) {                                 
            array_push($result, $this->getNoticia($dbObject));
        }
        return $result;
    }

    /**
     * Pesquisa somente a notícias em destaque
     */
    function getDestaques(){
        $this->db->where('data_hora_destaque >= ', date('Y-m-d h:i:s'));
        $this->db->order_by('noticia_id','desc');
        $array = $this->db->get('noticia')->result();
        $result = array();
        foreach ($array as $dbObject) {                                 
            array_push($result, $this->getNoticia($dbObject));
        }
        return $result;
    }

    /**
     * Pesquisa as ultimas $limit notícias que não estão mais em destaque
     */
    private function getNaoDestaques($limit){
        $this->db->where('data_hora_destaque < ', date('Y-m-d h:i:s'));
        $this->db->order_by('noticia_id','desc');
        $this->db->limit($limit);
        $array = $this->db->get('noticia')->result();
        $result = array();
        foreach ($array as $dbObject) {                                 
            array_push($result, $this->getNoticia($dbObject));
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
        $sql = "select * from noticia n1 where n1.noticia_id
                in(
                    select n2.noticia_id from tag
                    join tag_noticia on tag.tag_id = tag_noticia.tag_id
                    join noticia n2 on tag_noticia.noticia_id = n2.noticia_id
                    where tag.nome = '$tag'
                ) order by n1.noticia_id DESC";
        $array = $this->db->query($sql)->result();
        $result = array();
        foreach ($array as $dbObject) {                                 
            array_push($result, $this->getNoticia($dbObject));
        }
        return $result;            
    }

    function getTodasTags(){
        $result = $this->db->get('tag')->result();
        $tags = array();
        foreach ($result as $tag){
            array_push($tags, $tag->nome);
        }
        return $tags;
    }

}