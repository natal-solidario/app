<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

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
		$remember = 0;
		
		if (array_key_exists('remember', $this->input->post()))
			$remember = 1;

		if ($this->ion_auth->login($usuario, $senha, $remember))
		{
			redirect(base_url());
		}
		else
		{
			// Caso a senha/usuário estejam incorretos, então mando o usuário novamente para a tela de login com uma mensagem de erro.
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->load->view("login");
		}
	}
	
	public function logout()
	{
		$this->ion_auth->logout();
		$this->session->set_flashdata('message_ok', $this->ion_auth->messages());
		redirect("login", 'refresh');
	}

	//Working code for this example is in the example Auth controller in the github repo
	function lembrarsenha()
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run())
		{
			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten) { //if there were no errors
				$this->session->set_flashdata('message_ok', $this->ion_auth->messages());
				redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("login/lembrarsenha", 'refresh');
			}
		}
		else
		{
			//setup the input
			$this->data['email'] = array(
				'name'    => 'email',
				'id'      => 'email',
			);
			$this->data['identity_label'] = "TESTE";
			$this->data['type'] = "email";
			$this->data['identity'] = "email";
			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->view('lembrarsenha', $this->data);
		}
	}
	
	
	
	
	
	  
}