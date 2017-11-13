<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classe usada somente com o banco mysql
 */
class Banner extends CI_Model {

    public $arquivo;
    public $noticia;

    function getBanners($noticias){
        $banners = array();
        foreach ($noticias as $noticia){
            if (isset($noticia->img_banner)){
                $banner = new Banner();
                $banner->arquivo = $noticia->img_banner;
                $banner->noticia = $noticia;
                array_push($banners, $banner);
            }
        }
        return $banners;
    }

}