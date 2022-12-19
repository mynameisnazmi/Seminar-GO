<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile_admin extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('profile_data');
	}

    
  	function Admin($direct = 1)
	{	$userid = $this->session->userdata('user_id');
		$username = $this->session->userdata('user_name');
			if( !empty($userid) && $userid == 1 ){
					$data['user_id'] = $userid;
					$data['username'] = $username;
					$data['state'] = $direct;
					$this->load->view('profile_admin',$data);	
			}
			else{
				redirect('home');
			}
	}
	
	function chsts_app_ads(){
		$maps = $this->input->post('maps');	
		$adsid = $this->input->post('adsid');	
		$sid = $this->input->post('sid');
		$qeury = $this->profile_data->approve_ads_db($maps,$adsid,$sid);
		if($qeury){
			$sts = true;
			$msg = "Success";
		}
		else{
			$sts = false;
			$msg = "Eror";
		}
		echo json_encode(
			array(
				'sts' => $sts,
				'msg' => $msg
				)
			);
	}

	function chsts ($para,$adsid,$u_id=null){
		if ($para == 1){
			$resultpay = $this->profile_data->cek_orguser_db($u_id);//if true user shouldpay
			if($resultpay){
				$setsts = "Waiting for Payment";
			}
			else{	
				$setsts = "Published";
			}
			$qeury = $this->profile_data->chsts_db($adsid,$setsts);
		}
		elseif ($para == 2){
			$qeury = $this->profile_data->chsts_db($adsid,'Payment Reject');
		}
		
		if($qeury){
			redirect('profile_admin/Admin/2');
		}
	}

	function changepage ($par){
		$userid = $this->session->userdata('user_id');
		
		if($par == "app-pay"){
			$userdata = $this->profile_data->get_alltrx();
			if($userdata){
			foreach ($userdata->result_array() as $value) {
				$daynum = date('d', strtotime($value['payment_created']));
				$mounth = date('m', strtotime($value['payment_created']));
				$year = date('Y', strtotime($value['payment_created']));

				$firstfill = str_replace('','&nbsp;',$value['first_name']);

				echo '  <div id="rightbody3">
				<div id="objright4">
					<div id="desc">
						<div id="namatx">
						'.$value['seminar_name'].' ('.$value['seminar_price'].')
						</div>  
						<div id="kettx">
							'.$daynum.'/'.$mounth.'/'.$year.' | '.$value['bill_bank_name'].' | '.$value['bill_name']/*$firstfill.'&nbsp;'.$value['last_name']*/.' | '.$value['bill_number'].' | <a href="'.base_url().'asset/pict/payment/'.$value['payment_id'].'.png" target="_blank">Open Image</a>
						</div> 
					</div>
				</div>
				<div id="bota">
					<div id="items1">
						<a href="'.base_url().'profile_admin/appv/'.$value['payment_id'].'">Approve</a>
					</div>
					<div id="items2">
						<a href="'.base_url().'profile_admin/dnnd/'.$value['payment_id'].'">Denied</a>
					</div>
				</div>
			</div>';

			   }
			}
			else{
				echo 'NO ONE REGISTER';
			}
			}//first if

		elseif ($par == "app-sem") {
			
			$userdata = $this->profile_data->get_alltrx_ads($userid);
			if($userdata){
			foreach ($userdata->result_array() as $value) {

			if($value['ads_trx_status'] != "Published"){
				
				$daynum = date('d', strtotime($value['seminar_date']));
				$mounth = date('F', strtotime($value['seminar_date']));
				$year = date('Y', strtotime($value['seminar_date']));

				echo '<div id="rightbody3">
				<div id="objright3">
					<img src="'.base_url().'asset/pict/banner/'.$value['seminar_id'].'.png">
				</div>
				<div id="objright4">
					<div id="desc">
						<div id="namatx">
						'.$value['seminar_name'].'
						</div>  
						<div id="datetx">
						'.$daynum.'&nbsp;'.$mounth.'&nbsp;'.$year.'
						</div> 
						<div id="kettx">
						'.$value['seminar_held'].' 
						</div> 
					</div>';
					
				if($value['ads_trx_status'] == "Review By Admin"){
								echo '
								<a id="" href="'.base_url().'event_detail/'.$value['seminar_id'].'">Check</a>
								
								<div id="botaapp">
									<a id="app-sem"  href="'.base_url().'profile_admin/chsts/1/'.$value['ads_id'].'/'.$value['user_id'].'">Approve</a>
								</div>
								<div id="botarej">
									<a id="dec-sem"  href="'.base_url().'profile_admin/deletetrxads/'.$value['ads_id'].'">Reject Event</a>
									</div>
							';
							}
				elseif (($value['ads_trx_status'] == "Waiting for Payment") || ($value['ads_trx_status'] == "Payment Reject")) {
							echo'<div id="botawait">
									<a id="cekdetail-sem"  href="#">Waiting User For Upload</a>
								</div>';
						}
				elseif ($value['ads_trx_status'] == "Waiting Confirmation") {
								echo '	<div id="botacek">	
								<a href="'.base_url().'asset/pict/payment/'.$value['payment_id'].'.png" target="_blank">Check TF</a>
								</div>		
								<input type="text" id="'.$value['ads_id'].'" name="maps">
								<div id="botaapppay">
									<a id="app-sem" href"javascript:void(0);" onClick="approve('.$value['ads_id'].','.$value['seminar_id'].')" >Approve</a>
								</div>
								<div id="botarejpay">
									<a id="dec-sem"  href="'.base_url().'profile_admin/chsts/2/'.$value['ads_id'].'">Reject Payment</a>
									
							</div>';
						}
						echo '</div></div>';
					}

				}
			}

		}/*second if*/

	}
	
	function deletetrxads($ads_id=null){
		$deleteads = $this->profile_data->deletetrxads_db($ads_id);
		if($deleteads){
			redirect('profile_admin/Admin/2');
		}
	}
	

		function appv($p_id=null){
			$userupdate = $this->profile_data->approved($p_id);
			if($userupdate){
				redirect('/profile_admin/Admin');
			}
		}
		function dnnd($p_id=null){
			$userupdate = $this->profile_data->denied($p_id);
			if($userupdate){
				redirect('/profile_admin/Admin');
			}
		}
}//end class