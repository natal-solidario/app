<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->load->view('login');
	}
	
	public function logar()
	{
		$usuario = $this->input->post("usuario");
		$senha = $this->input->post("senha");
		$remember = ($this->input->post('remember')=='on');

		if ($this->ion_auth->login($usuario, $senha, $remember))
		{
			redirect(base_url());
		}
		else
		{
			//caso a senha/usuário estejam incorretos, então mando o usuário novamente para a tela de login com uma mensagem de erro.
			$dados['erro'] = "Usuário/Senha incorretos";
			$this->load->view("login", $dados);
		}
	}
	
	public function logout()
	{
		$this->ion_auth->logout();
		redirect(base_url());
	}

	//Working code for this example is in the example Auth controller in the github repo
	function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run()) {
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten) { //if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
		else
		{
			//setup the input
			$this->data['email'] = array(
				'name'    => 'email',
				'id'      => 'email',
			);
			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->view('auth/forgot_password', $this->data);
		}
	}
	  
}