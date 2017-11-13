<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
	    $data['body'] = 'form_noticia';
	    $data['op'] = 'insert';
	    $data['titulo'] = 'Teste';
	    $this->load->view('template',$data);
        /*
	    echo '<pre>';
        $this->load->model('GDB');
        if($this->GDB->validaUsuario('roger','admin'))
            echo 'true';
        else
            echo 'false';

        $this->load->model('Noticia');
        $this->load->model('NoticiaDAO_Mysql');
        $noticias = $this->NoticiaDAO_Mysql->getDestaques();

        print_r($noticias);

        echo date('Y-m-d h:');
        //$this->load->model('NoticiaDAO_Mongo');
        $noticias = $this->NoticiaDAO_Mongo->getNoticiasTag('teste4');
        print_r($noticias);
        $tags = Noticia::getTags($noticias);
        print_r($tags);


        $result = $this->db->query('select nome from tag_noticia JOIN tag on tag.tag_id = tag_noticia.tag_id where noticia_id = 1')->result();
        $result = $this->NoticiaDAO_Mysql->getAll();
        $noticia = new Noticia();
        $noticia->id = 4;
        $noticia->titulo = 'Titulo teste Final 111';
        $noticia->texto = 'Texto teste final 14';
        $st = strtotime("2017-10-01 08:00:00");
        $noticia->data_hora_pub = new DateTime("@$st");
        $st = strtotime("2017-10-19 08:00:00");
        $noticia->data_hora_destaque = new DateTime("@$st");
        $noticia->tags = array('teste6');
        $this->NoticiaDAO_Mysql->update($noticia);
        print_r($noticia);
        echo '<p>Objeto alterado!</p>';
        echo '<a href="'.base_url().'">Voltar</a>';



        $this->load->model('Noticia');
        $this->load->model('NoticiaDAO');
        $noticias = $this->NoticiaDAO->getUltimasGrp(3);
        echo '<pre>';
        print_r($noticias);
        //$noticia = $this->NoticiaDAO->get('59e126805232ba18af6277f5');
        //$noticia->tags = array('Teste1', 'Teste2');
        //$this->NoticiaDAO->insert($noticia);
        //print_r($noticia->id);
        //print_r($noticia);
        //$this->load->view('welcome_message');
        echo '<br /><a href="'.site_url('welcome/insert').'">Inserir</a><br/>';
        echo '<a href="'.site_url('welcome/update/59e781c13c9c84e81600002c').'">Alterar</a><br/>';
        echo '<a href="'.site_url('welcome/delete/59e781c13c9c84e81600002c').'">Deletar</a><br/>';
        $tags = $this->NoticiaDAO->getTags($noticias);
        echo 'TAGS:{ ';
        $i = 0;
        foreach ($tags as $str){
            if ($i > 0)
                echo ', ';
            echo $str;
            $i++;
        }
        echo '} ';
        */
    }

	public function insert(){
		$this->load->model('Noticia');
		$this->load->model('NoticiaDAO');
		$noticia = new Noticia();
		$noticia->titulo = 'Titulo teste Final Ultima Inserida';
		$noticia->texto = 'Texto teste final 3';
		$st = strtotime("2017-10-01 08:00:00");
		$noticia->data_hora_pub = new DateTime("@$st");
		$st = strtotime("2017-10-13 08:00:00");
		$noticia->data_hora_destaque = new DateTime("@$st");
		$noticia->tags = array('TagNãoUsadaAinda', 'TagEspecialNaoSei');
		$noticia->fotos = array('20171019201000.JPG','20171019201001.JPG');
		$noticia->anexos = array('20171019201000.PDF','20171019201001.PDF');
		$noticia->img_mini = '20171019201003.JPG';
		$noticia->img_banner = '20171019201002.JPG';
		$this->NoticiaDAO->insert($noticia);
		echo '<pre>';
		print_r($noticia);
		echo '<p>Objeto inserido!</p>';
		echo '<a href="'.base_url().'">Voltar</a>';
	}

	public function update($id){
		$this->load->model('Noticia');
		$this->load->model('NoticiaDAO');
		$noticia = $this->NoticiaDAO->get(new MongoID($id));
		$noticia->titulo = 'Titulo teste Final Alterado';
		$this->NoticiaDAO->update($noticia);
		echo '<pre>';
		print_r($noticia);
		echo '<p>Objeto alterado!</p>';
		echo '<a href="'.base_url().'">Voltar</a>';
	}

	public function delete($id){
		$this->load->model('Noticia');
		$this->load->model('NoticiaDAO');
		$noticia = $this->NoticiaDAO->get(new MongoID($id));
		$this->NoticiaDAO->delete($noticia);
		echo '<p>Objeto excluido!</p>';
		echo '<a href="'.base_url().'">Voltar</a>';
	}

}
