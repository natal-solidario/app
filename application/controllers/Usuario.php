<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Usuario extends MY_Controller
{

    const ACAO_AUTENTICACAO = 1;
    const ACAO_INCLUSAO = 2;
    const ACAO_ALTERACAO = 3;
    const ACAO_EXCLUSAO = 4;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Usuario_model', 'Usuario_perfil_model', 'Registro_log_model'));

		if (!$this->ion_auth_acl->has_permission('permite_administrar_usuario'))
		{
            $this->session->set_flashdata('message', 'Você não tem permissão para acessar esta funcionalidade!');
            redirect(site_url());
        }
    } 

    /*
     * Listing of usuarios
     */
    function index()
    {
        $data['usuarios'] = $this->Usuario_model->get_all_usuarios();
        $data['all_grupos'] = $this->Usuario_perfil_model->get_all_perfil();
        
        $data['_view'] = 'usuario/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new usuario
     */
    function add()
    {
        $this->form_validation->set_rules('nome','Nome','required');
        $this->form_validation->set_rules('email','E-mail','required|valid_email');
        $this->form_validation->set_rules('senha','Senha','required|min_length[6]|max_length[18]');

        if($this->form_validation->run())     
        {   
            $username = '';
            $password = $this->input->post('senha');
            $email = $this->input->post('email');
            $additional_data = array(
                                    'first_name' => $this->input->post('nome'),
                                    'phone' => $this->input->post('telefone'),
                                    'area_abrangencia' => $this->input->post('area_abrangencia'),
                                    'referencia' => $this->input->post('referencia'),
                                    );

            if($this->input->post('perfil[]')) {
                $group = $this->input->post('perfil[]');
            } else {
                $group = array('2'); // caso não seja informado nenhum perfil seta visitante....
            }
            
            //verifica se o email já existe
            if(!$this->ion_auth->email_check($email)) {
                $usuario_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group);

                //inicio auditoria
                $paramsLog1 = array(
                                'username' => $username,
                                'email' => $email,
                            );
                $paramsLog2 = array_merge($paramsLog1, $additional_data);
                $paramsLog3 = array_merge($paramsLog2, $group);

                $paramsAudit = array(
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'usuario' => $this->ion_auth->user()->row()->id,
                    'acao' => self::ACAO_INCLUSAO,
                    'titulo' => "USUARIO",
                    'conteudo_anterior' => '',
                    'conteudo_posterior' => http_build_query($paramsLog3)

                );
                $this->Registro_log_model->add_registro_log($paramsAudit);
                //fim auditoria

                redirect('usuario/index');
            } else {
                $this->session->set_flashdata('message', 'E-mail já cadastrado!');

                $data['all_grupos'] = $this->ion_auth->groups()->result();

                $data['_view'] = 'usuario/add';
                $this->load->view('layouts/main',$data);
            }
        }
        else
        {            
            $data['all_grupos'] = $this->ion_auth->groups()->result();

            $data['_view'] = 'usuario/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a usuario
     */
    function edit($id)
    {   
        // check if the usuario exists before trying to edit it
        $data['usuario'] = $this->Usuario_model->get_usuario($id);
        
        if(isset($data['usuario']['id']))
        {
            $this->form_validation->set_rules('nome','Nome','required');
            $this->form_validation->set_rules('email','E-mail','required|valid_email');
            
            if($this->form_validation->run())     
            {  
                $params = array(
					'first_name' => $this->input->post('nome'),
					'email' => $this->input->post('email'),
					'area_abrangencia' => $this->input->post('area_abrangencia'),
					'referencia' => $this->input->post('referencia'),
					'phone' => $this->input->post('telefone'),
                );
                
                $isMesmoEmail = ($data['usuario']['email'] == $this->input->post('email'));
                $isEmailCadastrado = $this->ion_auth->email_check($this->input->post('email'));

                if($isMesmoEmail || !$isEmailCadastrado) {
                    //guarda os grupos anteriores
                    $gruposAnteriores = $this->ion_auth->groups()->result();

                    //persiste as alterações...
                    $this->Usuario_model->update_usuario($id,$params);

                    if($this->input->post('perfil[]')) {
                        //primeiro remove todos os grupos...
                        $this->ion_auth->remove_from_group(NULL, $id);

                        //atribui os novos grupos.
                        $this->ion_auth->add_to_group($this->input->post('perfil[]'), $id);
                    }

                    //inicio auditoria
                    $paramsAudit = array(
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'usuario' => $this->ion_auth->user()->row()->id,
                        'acao' => self::ACAO_ALTERACAO,
                        'titulo' => "USUARIO",
                        'conteudo_anterior' => http_build_query(array_merge($data['usuario'], $gruposAnteriores)),
                        'conteudo_posterior' => http_build_query(array_merge($params, $this->ion_auth->groups()->result()))

                    );

                    $this->Registro_log_model->add_registro_log($paramsAudit);
                    //fim auditoria


                    redirect('usuario/index');
                } else {
                    $this->session->set_flashdata('message', 'E-mail já cadastrado!');

                    $data['all_grupos'] = $this->ion_auth->groups()->result();
                    $data['all_grupos_usuario'] = $this->ion_auth->get_users_groups($id)->result();

                    $data['_view'] = 'usuario/edit';
                    $this->load->view('layouts/main',$data);
                }
                
            }
            else
            {
                $data['all_grupos'] = $this->ion_auth->groups()->result();
                $data['all_grupos_usuario'] = $this->ion_auth->get_users_groups($id)->result();

                $data['_view'] = 'usuario/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The usuario you are trying to edit does not exist.');
    }

    /*
     * Editing a usuario
     */
    function changepass($id)
    {   
        // check if the usuario exists before trying to edit it
        $data['usuario'] = $this->Usuario_model->get_usuario($id);
        
        if(isset($data['usuario']['id']))
        {
            $this->form_validation->set_rules('senha','Senha','required|min_length[6]|max_length[18]');
            
            if($this->form_validation->run())     
            {

                $params = array(
                    'password' => $this->input->post('senha'),
                );

                if($this->ion_auth->update($id, $params)) {
                    $this->session->set_flashdata('message_ok', 'Senha alterada com sucesso.');

                    //inicio auditoria
                    $paramsAudit = array(
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'usuario' => $this->ion_auth->user()->row()->id,
                        'acao' => self::ACAO_ALTERACAO,
                        'titulo' => "SENHA",

                    );

                    $this->Registro_log_model->add_registro_log($paramsAudit);
                    //fim auditoria

                    redirect('usuario/index');
                } else {
                    show_error('Erro ao alterar senha do usuário.');
                }       
            }
        
            else
            {
                $data['_view'] = 'usuario/changepass';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The usuario you are trying to edit does not exist.');
    }
    
}
