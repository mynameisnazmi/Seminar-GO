<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test_c extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('seminar_data');

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
		$rowcek = $this->seminar_data->getcityfilter();
		if($rowcek->num_rows() > 0){	
		$result['seminar'] = $this->seminar_data->getcityfilter();
		}
		else{
			$result['seminar'] = 'NO EVENT';
		}
		$this->load->view('test_v',$result);
	}
    function trial(){
			$varcat = $this->input->post('varcat');
			$varcity = $this->input->post('varcity');
			$strfil1 =  str_replace("-"," ",$varcity);
			$strfil2 = ucwords($strfil1);
			//echo $varcat;
            $result = $this->seminar_data->testfil($varcat,$strfil2);
            if($result->num_rows() > 0){
				$i=1;
                foreach ($result->result_array() as $value) {
						echo $i.$value['seminar_name'].'='.$value['seminar_tag'].'<br/>';
						$i++;
                }
            }
            else {
                echo "EROR CODE : 666";
            }
	}

}//end CTRL
