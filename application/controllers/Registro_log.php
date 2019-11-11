<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Registro_log extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Registro_log_model');
    }

    /*
     * Listing of registros_log
     */
    function index()
    {
        $data['registros_log'] = $this->Registro_log_model->get_all_registros_log();
        
        $data['_view'] = 'registro_log/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new registro_log
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'data_cadastro' => $this->input->post('data_cadastro'),
				'usuario' => $this->input->post('usuario'),
				'acao' => $this->input->post('acao'),
				'titulo' => $this->input->post('titulo'),
				'conteudo_anterior' => $this->input->post('conteudo_anterior'),
				'conteudo_posterior' => $this->input->post('conteudo_posterior'),
            );
            
            $registro_log_id = $this->Registro_log_model->add_registro_log($params);
            redirect('registro_log/index');
        }
        else
        {            
            $data['_view'] = 'registro_log/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a registro_log
     */
    function edit($id)
    {   
        // check if the registro_log exists before trying to edit it
        $data['registro_log'] = $this->Registro_log_model->get_registro_log($id);
        
        if(isset($data['registro_log']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'data_cadastro' => $this->input->post('data_cadastro'),
					'usuario' => $this->input->post('usuario'),
					'acao' => $this->input->post('acao'),
					'titulo' => $this->input->post('titulo'),
					'conteudo_anterior' => $this->input->post('conteudo_anterior'),
					'conteudo_posterior' => $this->input->post('conteudo_posterior'),
                );

                $this->Registro_log_model->update_registro_log($id,$params);            
                redirect('registro_log/index');
            }
            else
            {
                $data['_view'] = 'registro_log/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The registro_log you are trying to edit does not exist.');
    }
}
