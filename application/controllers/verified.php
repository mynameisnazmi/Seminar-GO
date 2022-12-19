<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class verified extends CI_Controller {
  function __construct(){
		parent::__construct();		
		$this->load->model('seminar_data');
	}

    public function user($b_id){
      $qeury = $this->seminar_data->cek_verified($b_id);
      if($qeury == false){
        $data['user_data'] = 'ILLEGAL USER';
      }
      else{
       $data['user_data'] = $qeury;
      }
		$this->load->view('verified',$data);
    }
    
}