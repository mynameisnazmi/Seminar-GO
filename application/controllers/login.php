<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	function __construct(){
		parent::__construct();		
		$this->load->model('login_reg');
	}
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
		$userid = $this->session->userdata('user_id');
		if(isset($userid)){
			redirect('home');
		}
		else {
		$this->load->view('login');
		}
	}
	 function login_val(){
		if(isset($_POST['submit'])){
		   $this->load->library('form_validation');  
           $this->form_validation->set_rules('email', 'Email', 'required');  
           $this->form_validation->set_rules('password', 'Password', 'required');  
           if($this->form_validation->run())  
           {  
				$semid = $this->session->userdata('seminar_id');
				
                //true  
                $email = $this->input->post('email');  
				$password = $this->input->post('password');
				$enpass = md5($password);
                //model function   
				$res = $this->login_reg->get_user_detail($email, $enpass);
				if($res->num_rows()>0)
				{ 	
					//setsession *here
					foreach($res->result_array() as $value){
						$this->session->set_userdata('user_id', $value['user_id']);
						$this->session->set_userdata('user_name', $value['last_name']);
					}
					if(!empty($semid)){
					redirect('event_detail/'.$semid.'');
					}
					else{
					redirect('home'); 
					}
					$this->session->unset_userdata('seminar_id');

				}
                else  
                {  
                   $this->session->set_flashdata('gagal', 'Invalid Username and Password');  
                    redirect('login/');  
                }  
           }  
           else  
           {  
                //false  
				redirect('login/'); 
		   }  
		}
		
	}
	function logout(){
	//	http://localhost:8080/ci3/index.php/login/logout
	$this->session->unset_userdata('user_id');
	$this->session->sess_destroy();
	redirect('home');  
	}

}
