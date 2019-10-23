<?php
/* 
 * João Paulo
 * jpaulocs@gmail.com
 */
 
class Registro_log_acao extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Registro_log_acao_model');

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
     * Listing of registros_log_acao
     */
    function index()
    {
        $data['registros_log_acao'] = $this->Registro_log_acao_model->get_all_registros_log_acao();
        
        $data['_view'] = 'registro_log_acao/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new registro_log_acao
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'nome' => $this->input->post('nome'),
            );
            
            $registro_log_acao_id = $this->Registro_log_acao_model->add_registro_log_acao($params);
            redirect('registro_log_acao/index');
        }
        else
        {            
            $data['_view'] = 'registro_log_acao/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a registro_log_acao
     */
    function edit($id)
    {   
        // check if the registro_log_acao exists before trying to edit it
        $data['registro_log_acao'] = $this->Registro_log_acao_model->get_registro_log_acao($id);
        
        if(isset($data['registro_log_acao']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'nome' => $this->input->post('nome'),
                );

                $this->Registro_log_acao_model->update_registro_log_acao($id,$params);            
                redirect('registro_log_acao/index');
            }
            else
            {
                $data['_view'] = 'registro_log_acao/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The registro_log_acao you are trying to edit does not exist.');
    }
}
