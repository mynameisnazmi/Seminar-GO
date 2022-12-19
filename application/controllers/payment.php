<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class payment extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('profile_data');	
		$this->load->model('seminar_data');	
	}
	/**
	 * Index Page for this controller.
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
	public function confirmation($seminar_id=null,$user_id=null,$mode=null){ //confirmpage
		$userid = $this->session->userdata('user_id');
		if( (!empty($userid))  &&  ($user_id == $userid)  ){
		$username = $this->session->userdata('user_name');
		$data['user_id'] = $userid;
		$data['username'] = $username;
		$data['s_id'] = $seminar_id;
		$data['seminar']= $this->seminar_data->payment_detail($seminar_id,$user_id,$mode);
		$this->load->view('payment',$data);
		}
		else{
			redirect('home');
		}

	}

	
	function updata($payment_id,$s_id){
		$userid = $this->session->userdata('user_id');
		if(!empty($userid)){

			if (strpos($payment_id, '0') !== false) {
				$redir = "ads/user/2";
				$table = "user_trx_ads";
				$where = "ads_payment_id";
				$status = "ads_trx_status";
				
			}
			else{
				$redir = "event_detail/".$s_id;
				$table = "user_trx";
				$where = "payment_id";
				$status = "atten_status";
			}
		$billname = $this->input->post('billname');  
		$billbank = $this->input->post('billbank');	
		$norek = $this->input->post('norek');	
		$data = array(
			'bill_name' => $billname,
			'bill_bank_name' => $billbank,
			'bill_number' => $norek,
			'paid_date' => date('Y-m-d'));
			$updating = $this->profile_data->update_data($data,'payment','payment_id' ,$payment_id);
			$this -> up_pict($payment_id);
			if($updating){
				$data1 = array($status => "Waiting Confirmation");
				$updater = $this->profile_data->update_data($data1,$table,$where ,$payment_id);
				if($updater){
				redirect(base_url().$redir,'refresh');
				}

			}			
		}
		
	}

	private function up_pict($pay_id) {
				$config['upload_path']          = './asset/pict/temporary/';
				$config['allowed_types']        = 'jpg|png|jpeg';
				$config['file_name']            = $pay_id.'.png';
				$config['overwrite']			= true;
				$config['max_size']             = 0; // 1MB
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('buktiimg')) {
				$gbr = $this->upload->data();
				$config['image_library']='gd2';
                $config['source_image']='./asset/pict/temporary/'.$gbr['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= FALSE;
                $config['quality']= '70%';
				$config['new_image']= './asset/pict/payment/'.$gbr['file_name'];
				$this->load->library('image_lib', $config);
                $resizex =$this->image_lib->resize();	
				if($resizex){
						unlink('./asset/pict/temporary/'.$gbr['file_name']);
						return true;
						}
				}
				else{
					$error = $this->upload->display_errors();

					echo $error;
				}
		}
	
}//endclass
?>