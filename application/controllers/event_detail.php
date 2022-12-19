<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class event_detail extends CI_Controller {
	function __construct(){
		parent::__construct();		
		$this->load->model('seminar_data');
	}
	 function getposcert($s_id){
		$namex = round($this->input->post('namex'),0);
		$namey = round($this->input->post('namey'),0);
		$qrx = round($this->input->post('qrx'),0);
		$qry = round($this->input->post('qry'),0);
		$txtalgn = $this->input->post('txtalgn');
		$textsize = $this->input->post('textsize');
		$data = $namex.','.$qrx.','.$namey.','.$qry.','.$txtalgn.','.$textsize;
		$sts = $this->seminar_data->update_pos_db($s_id,$data);
		if($sts){
			echo 'oke';
		}
		
	}
	function pos($s_id){
		$userid = $this->session->userdata('user_id');
		if( !empty($userid) && $userid == 1 ){
			$userid = $this->session->userdata('user_id');
			$username = $this->session->userdata('user_name');
			$data['sem_id'] = $s_id;
			$data['user_id'] = $userid;
			$data['username'] = $username;
			$this->load->view('positioning',$data);
	}
	else{
		redirect('home');
	}
		
	}
	 function countseat($s_id){
		$seatnum = $this->seminar_data->countseat_db($s_id);
		 return $seatnum;
	 }
	 function scan($p_id=null){
		 $userid = $this->session->userdata('user_id');
		if( (!empty($userid)) && ($userid == 1) ){
			$query = $this->seminar_data->scan_update($p_id);
			if($query){
				echo 'SUKSES';
			}
			else {
				echo 'gagal';
			}
		}
		else {
			redirect('login');
		}
	 }

	 
	 function cancle($s_id=null,$userid=null,$page=0){
		$delete = $this->seminar_data->deletetrx($s_id,$userid);
		if(($delete) && ($page == 0)){
			redirect('event_detail/'.$s_id);
		}
		else if(($delete) && ($page == 1)){
			redirect('profile/myprofile/2');
		}
	 }
	 function renderqr($s_id=null,$userid=null){
		$this->load->library('Ciqrcode');
		$rev_qrcode = $this->seminar_data->getqrcode($s_id,$userid);
		//var_dump($rev_qrcode);
		if ( !empty($rev_qrcode->booking_id) ){
			QRcode::png(
				base_url().'event_detail/scan/'.$rev_qrcode->booking_id.$userid,
				$outfile = false,
				$level = QR_ECLEVEL_H,
				$size = 3,
				$margin = 1
			);
		}
		else{
			return false;
		}
	}
	
	public function detail($s_id=null)//this should use ID parameter
	{	//http://localhost:8080/ci3/index.php/home
		
		$userid = $this->session->userdata('user_id');//session user
		$result = $this->seminar_data->get_seminar_detail($s_id,$userid);
		if($result){
					if($result->num_rows() > 0){
						$data['seminar']= $result->result_array();
					//	$checkuser = $this->seminar_data->userinftrx($s_id);
						$this->session->set_userdata('seminar_id', $s_id);
						$username = $this->session->userdata('user_name');//lastname
						$userstatus = $this->seminar_data->userinftrx($s_id,$userid);
						$data['user_id'] = $userid;
						$data['username'] = $username;
						$data['seat'] = $this->countseat($s_id);
						if(empty($userstatus->atten_status)){
							$data['registered'] = "";
						}
						else{	
							$data['registered'] = $userstatus->atten_status;
						}
						if( (!empty($userid)) && ($userid == 1) ){
							$data['verifiedpos'] = 1;
						}
						
						$this->load->view('event_detail',$data);
				}
				else{
					redirect('home');
				}
		}
		else{
			redirect('home');
		}
				
	}

	function applyevent($eventid = null,$userid = null , $evval){
		if($evval == 0){
			$evsts = "Booked";
		}
		else{
			$evsts = "Waiting Payment";
		}

			$cekuser = $this->seminar_data->cekseminar_user($eventid,$userid);
			if($cekuser){
				//$data_price = $this->seminar_data->get_seminar_price($eventid);
				$this->load->helper('string');
			do {
				$bookid =  random_string('nozero', 6);
				$resbook = $this->seminar_data->cekspecode($bookid,'booking_id','user_trx');
				if ($resbook){
					$reservedid = $bookid;
				}
			} while ($resbook == false);


				if($resbook){
					$curdate = date('Y-m-d'); 
					
					$data1 = array(
							'payment_id' => $reservedid.$userid,
							'payment_created' =>  $curdate);
					$data2 = array(
								'booking_id' => $reservedid,
								'user_id' => $userid,
								'seminar_id' => $eventid,
								'payment_id' => $reservedid.$userid,
								'atten_status' => $evsts );

						$this->seminar_data->input_data($data1,'payment');
						$this->seminar_data->input_data($data2,'user_trx');
						$msg = "THANK YOU !!!";
						//redirect('home');
				}	
				else{
					echo "EROR INSERT";
				}
			}
			else{
				$msg = "You already registered";
			}	
				echo json_encode(
					array(
						'msg' => $msg
					)
					);

			}

}
