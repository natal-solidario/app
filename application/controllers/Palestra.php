<?php

class Palestra extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Sala_palestra_model');
        $this->load->model('Sala_palestra_turma_model');

        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('message', 'You must be an admin to view this page');
            redirect('login');
        } else {
            $user = $this->ion_auth->user()->row();
            $this->session->set_userdata('usuario_logado', $user->email);
        }
    }
    
    /*
     * Listing of beneficiados
     */
    function index()
    {
        $data['salas'] = $this->Sala_palestra_model->get_por_ano(date("Y"));
        
        $data['_view'] = 'palestra/index';
        $this->load->view('layouts/main',$data);
    }
    
    function inscritos($idSalaPalestra)
    {
        $data['salaSelecionada'] = $this->Sala_palestra_model->get_por_id($idSalaPalestra);
        
        if($data['salaSelecionada'])
        {
            $data['responsaveis'] = $this->Sala_palestra_turma_model->get_por_sala_palestra($idSalaPalestra);
            
            $data['_view'] = 'palestra/inscritos';
            $this->load->view('layouts/main',$data);
        }
        else {
            show_error('A sala de palestra informada não foi encontrada.');
        }
    }
}