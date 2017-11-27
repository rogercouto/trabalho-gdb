<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm extends CI_Controller {

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
     *
	 */
	public function index(){
        if (!isset($this->session->login))
            redirect(site_url('adm/login'), 'refresh');
        $data['title'] = '&Aacute;rea restrita';
        $data['body'] = 'adm_welcome';
        $this->load->view('adm_template', $data);
    }

    public function login(){
	    $data['title'] = '&Aacute;rea restrita - login';
	    $data['body'] = 'form_login';
        $this->load->view('adm_template.php', $data);
    }

    public function entrar(){
        $this->load->model('GDB');
        $usuario = new Usuario();
        $usuario->login = $this->input->post('login');
        $usuario->senha = $this->input->post('senha');
        if ($this->GDB->validaUsuario($usuario)){
            $this->session->set_userdata('login', $usuario->login);
            redirect(site_url('adm'), 'refresh');
        }else{
            $data['title'] = '&Aacute;rea restrita - login';
            $data['body'] = 'form_login';
            $data['erro'] = 'Usu&aacute;rio ou senha incorreto(s)!';
            $this->load->view('adm_template.php', $data);
        }
    }

    public function logout(){
        $this->session->unset_userdata('login');
        redirect(site_url('adm/login'), 'refresh');
    }

    function ins_noticia(){
        if (!isset($this->session->login))
            redirect(site_url('adm/login'), 'refresh');
        $data['title'] = '&Aacute;rea restrita';
        $data['body'] = 'form_noticia';
        $data['op'] = 'salva_noticia';
        $this->load->view('adm_template', $data);
    }

    function edt_noticia($id){
        if (!isset($this->session->login))
            redirect(site_url('adm/login'), 'refresh');
        $this->load->model('GDB');
        $data['title'] = '&Aacute;rea restrita';
        $data['body'] = 'form_noticia';
        $data['op'] = 'salva_noticia';
        $data['noticia'] = $this->GDB->getNoticia($id);
        $this->load->view('adm_template', $data);
    }

    function exc_noticia($id){
        if (!isset($this->session->login))
            redirect(site_url('adm/login'), 'refresh');
        $this->load->model('GDB');
        $data['title'] = '&Aacute;rea restrita';
        $data['body'] = 'form_confirma';
        $data['message'] = 'Confirma exclus&atilde;o da not&iacute;cia?';
        $data['action'] = site_url('/adm/confirma_exclusao');
        $data['value'] = $id;
        $this->load->view('adm_template', $data);
    }

    function confirma_exclusao(){
        if (!isset($this->session->login))
            redirect(site_url('adm/login'), 'refresh');
        if (isset($_POST['value'])){
            $this->load->model('GDB');
            $this->GDB->deleteNoticia($_POST['value']);
            redirect(site_url('adm/lst_noticia').'/2','refresh');
        }else{
            die('<h1>Algo deu errado</h1>');
        }
    }

    function salva_noticia(){
        if (!isset($this->session->login))
            redirect(site_url('adm/login'), 'refresh');
        $update = FALSE;
        $this->load->model('GDB');
        $noticia = new Noticia();
        if (isset($_POST['id'])){
            $update = TRUE;
            $noticia = $this->GDB->getNoticia($_POST['id']);
            if ($noticia == NULL)
                die('Erro ao retornar notícia id: '.$_POST['id']);
        }
        $noticia->titulo = $_POST['titulo'];
        $noticia->texto = $_POST['texto'];
        if (!$update)
            $noticia->data_hora_pub = new DateTime(date('Y-m-d H:i:s'));
        $noticia->data_hora_destaque = new DateTime($_POST['destaque']);
        if (isset($_POST['tags']) && $_POST['tags'] != $noticia->getTagsValue()){
            echo $_POST['tags'].'<br/>';
            $noticia->setTagsValue($_POST['tags']);
        }
        $count = 0;
        //Remoção das imagens e anexos
        if (isset($_POST['exc_mini'])){
            unlink('upload/mini/'.$noticia->img_mini);
            $noticia->img_mini = NULL;
        }
        if (isset($_POST['exc_banner'])){
            unlink('upload/banner/'.$noticia->img_banner);
            $noticia->img_banner = NULL;
        }
        if (isset($noticia->fotos) && count($noticia->fotos)>0){
            for ($i = 0; $i < count($noticia->fotos); $i++){
                $str = "excluir_foto_";
                $str .= $i;
                if (isset($_POST[$str])){
                    unlink('upload/fotos/'.$noticia->fotos[$i]);
                    unset($noticia->fotos[$i]);
                }
            }
            $noticia->fotos = array_values($noticia->fotos);//ajusta os índices
            $noticia->updateFotos = TRUE;
        }
        if (isset($noticia->anexos) && count($noticia->anexos)>0){
            for ($i = 0; $i < count($noticia->anexos); $i++){
                $str = "excluir_anexo_";
                $str .= $i;
                if (isset($_POST[$str])){
                    unlink('upload/anexos/'.$noticia->anexos[$i]);
                    unset($noticia->anexos[$i]);
                }
            }
            $noticia->anexos = array_values($noticia->anexos);//ajusta os índices
            $noticia->updateAnexos = TRUE;
        }
        if ($_FILES['mini']['error'] == 0){
            if (isset($noticia->img_mini))
                unlink('upload/mini/'.$noticia->img_mini);
            $fileName = date('Ymdhis');
            if ($count < 10)
                $fileName .= '0';
            $fileName .= $count;
            $fileName .= '.';
            $fileName .= substr($_FILES['mini']['name'], strlen($_FILES['mini']['name'])-3, 3);
            move_uploaded_file($_FILES['mini']['tmp_name'], './upload/mini/'.$fileName);
            $noticia->img_mini = $fileName;
            $count++;
        }
        if ($_FILES['banner']['error'] == 0){
            if (isset($noticia->img_banner))
                unlink('upload/banner/'.$noticia->img_banner);
            $fileName = date('Ymdhis');
            if ($count < 10)
                $fileName .= '0';
            $fileName .= $count;
            $fileName .= '.';
            $fileName .= substr($_FILES['banner']['name'], strlen($_FILES['banner']['name'])-3, 3);
            move_uploaded_file($_FILES['banner']['tmp_name'], './upload/banner/'.$fileName);
            $noticia->img_banner = $fileName;
            $count++;
        }
        if ($_FILES['fotos']['error'][0] == 0){
            for ($i = 0; $i < count($_FILES['fotos']['name']); $i++){
                $fileName = date('Ymdhis');
                if ($i < 10)
                    $fileName .= '0';
                $fileName .= $count;
                $fileName .= '.';
                $fileName .= substr($_FILES['fotos']['name'][$i], strlen($_FILES['fotos']['name'][$i])-3, 3);
                move_uploaded_file($_FILES['fotos']['tmp_name'][$i], './upload/fotos/'.$fileName);
                $noticia->addFoto($fileName);
                $count++;
            }
        }
        if ($_FILES['anexos']['error'][0] == 0){
           for ($i = 0; $i < count($_FILES['anexos']['name']); $i++){
                $fileName = date('Ymdhis');
                if ($i < 10)
                    $fileName .= '0';
                $fileName .= $count;
                $fileName .= '.';
                $fileName .= substr($_FILES['anexos']['name'][$i], strlen($_FILES['anexos']['name'][$i])-3, 3);
                move_uploaded_file($_FILES['anexos']['tmp_name'][$i], './upload/anexos/'.$fileName);
                $noticia->addAnexo($fileName);
                $count++;
            }
        }
        if ($update)
            $this->GDB->updateNoticia($noticia);
        else
            $this->GDB->insertNoticia($noticia);
        redirect(site_url('adm/lst_noticia').($update ? '/1' : '/0'), 'refresh');

    }

    function lst_noticia($msg_num=NULL){
        if (!isset($this->session->login))
            redirect(site_url('adm/login'), 'refresh');
        if (isset($msg_num)){
            switch ($msg_num){
                case 0: $data['msg'] = '<p style="color:#008855">Not&iacute;cia inserida!</p>';
                    break;
                case 1: $data['msg'] = '<p style="color:#008855">Not&iacute;cia editada!</p>';
                    break;
                case 2: $data['msg'] = '<p style="color:#e3c300">Not&iacute;cia excluida!</p>';
                    break;
            }
        }
        $this->load->model('GDB');
        $data['noticias'] = $this->GDB->getNoticias();
        $data['title'] = '&Aacute;rea restrita';
        $data['body'] = 'adm_lista_noticias';
        $this->load->view('adm_template', $data);
    }

    function busca_noticias(){
        if (!isset($this->session->login))
            redirect(site_url('adm/login'), 'refresh');
        if (!isset($_POST['busca']))
            die('Erro ao buscar os dados!');
        $this->load->model('GDB');
        $data['noticias'] = $this->GDB->buscaNoticias($_POST['busca']);
        $data['title'] = '&Aacute;rea restrita';
        $data['body'] = 'adm_lista_noticias';
        $this->load->view('adm_template', $data);
    }

}
