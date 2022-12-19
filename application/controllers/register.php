<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class register extends CI_Controller {
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
		http://localhost:8080/ci3/index.php/dashbord/register
		$this->load->view('register');
	}
	function register_proceses(){
		$status = false;
		$msg="";
		if(isset($_POST['submit'])){
			$email = $this->input->post('email');
			$first_name = $this->input->post('firstname');
			$last_name = $this->input->post('lastname');
			$password = $this->input->post('password');
			$enpass = md5($password);
 
		$data = array(
			'password' => $enpass,
			'email' => $email,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'org_id' => 1
			);
		$cek = $this->login_reg->cekemail($email);
			if( $cek ){
				$this->login_reg->input_data($data,'user');
				$status = true;
				$msg = "Yeay!";
				//redirect('index.php/login');
			}
			else{
				$status = true;
				$msg = "Try Another Email";
				//$this->load->view('register',$data);
			}
	}
	else{
		redirect('home');
	}
	echo json_encode(
        array(
            'status' => $status,
            'msg' => $msg
           )
        );

}


}//end CTRL
