<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Local extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Local_entrega_model');
        $this->load->model('Local_entrega_regiao_model');
    }

    /*
     * Listing of responsaveis
     */
    function index()
    {
        $data['locais'] = $this->local_entrega_model->get_locais_armazenamento();
        
        $data['js_scripts'] = array('responsavel/index.js');
        $data['_view'] = 'responsavel/index';
        $this->load->view('layouts/main',$data);
    }
}
?>