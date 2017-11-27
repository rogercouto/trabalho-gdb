<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    const LIMIT = 20; //Limite de notícias para serem exibidas

    /**
	 * Index Page for this controller.
	 */
	function index(){
	    $this->load->model('GDB');
	    $data['noticias'] = $this->GDB->getNoticiasPortal($this::LIMIT);
        $data['noticiasSobre'] = $this->GDB->getNoticiasTag('Sobre');
        $data['noticiasMenu'] = $this->GDB->getNoticiasTag('Menu');
        $data['tags'] = $this->GDB->getTodasTags();
        $data['banners'] = $this->GDB->getBanners($data['noticias']);
	    $this->load->view('template', $data);
    }

    function lista_noticias(){
        $this->load->model('GDB');
        $data['noticias'] = $this->GDB->getNoticias();
        $data['noticiasSobre'] = $this->GDB->getNoticiasTag('Sobre');
        $data['noticiasMenu'] = $this->GDB->getNoticiasTag('Menu');
        $data['content'] = 'noticias_content';
        $data['title'] = 'Notícias - Exibindo todas';
        $this->load->view('template', $data);
    }

    function busca_texto(){
        $this->load->model('GDB');
        $data['noticias'] = $this->GDB->buscaNoticias($_POST['texto']);
        $data['noticiasSobre'] = $this->GDB->getNoticiasTag('Sobre');
        $data['noticiasMenu'] = $this->GDB->getNoticiasTag('Menu');
        $data['content'] = 'noticias_content';
        $data['title'] = 'Resultado da busca por: "'.$_POST['texto'].'"';
        $this->load->view('template', $data);
    }

    function busca_tag(){
        $this->load->model('GDB');
        $data['noticias'] = $this->GDB->getNoticiasTag($_POST['tag']);
        $data['noticiasSobre'] = $this->GDB->getNoticiasTag('Sobre');
        $data['noticiasMenu'] = $this->GDB->getNoticiasTag('Menu');
        $data['content'] = 'noticias_content';
        $data['title'] = 'Notícias contendo a tag: "'.$_POST['tag'].'"';
        $this->load->view('template', $data);
    }

    function mostra_noticia($id){
        $this->load->model('GDB');
        $data['noticia'] = $this->GDB->getNoticia($id);
        $data['noticiasSobre'] = $this->GDB->getNoticiasTag('Sobre');
        $data['noticiasMenu'] = $this->GDB->getNoticiasTag('Menu');
        $data['content'] = 'noticia_content';
        if ($data['noticia']->inMenu())
            $data['menu_sobre'] = TRUE;
        $this->load->view('template', $data);
    }

    function agenda(){
        $data['content'] = 'agenda';
        $this->load->model('GDB');
        $data['noticiasSobre'] = $this->GDB->getNoticiasTag('Sobre');
        $data['noticiasMenu'] = $this->GDB->getNoticiasTag('Menu');
        $this->load->view('template', $data);
    }

}
