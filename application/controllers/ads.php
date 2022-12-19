<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ads extends CI_Controller {
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
	 
	public function user($direct = 1){
		$userid = $this->session->userdata('user_id');
		$username = $this->session->userdata('user_name');
		if(empty($userid)){//if not signing
			$this->load->view('ads');
		}
		else{	//setting user if already login
			$data['state'] = $direct;
			$data['user_id'] = $userid;
			$data['username'] = $username;
			$this->load->view('ads',$data);
		}


	}
	function insertads($userid=null){
	
		if(!empty($userid)){
		$semname = $this->input->post('semname');
		$semdate = $this->input->post('semdate');
		$semtime = $this->input->post('semtime');
		$semseat = $this->input->post('semseat');
		$semcity = $this->input->post('semcity');
		$semheld = $this->input->post('semheld');
		$semdesc = $this->input->post('semdesc');
		$category = implode(',' , $this->input->post('category'));
		$semprice = $this->input->post('semprice');
		$semdress = $this->input->post('semdress');
		
		$combinedDT = date('Y-m-d H:i:s', strtotime("$semdate $semtime"));//time

		$this->load->helper('string');
		do {
			$bookid =  random_string('nozero', 5);
			$resbook = $this->seminar_data->cekspecode($bookid,'seminar_id','seminar');
			if ($resbook){
				$reservedid = $bookid;
			}
		} while ($resbook == false);

		$data = array(
			'seminar_id' => $reservedid,
			'seminar_name' => $semname,
			'seminar_date' => $combinedDT,
			'seminar_city' => $semcity,
			'seminar_held' => $semheld,
			'seminar_seat' => $semseat,
			'seminar_desc' => $semdesc,
			'seminar_tag' => $category,
			'seminar_price' => $semprice,
			'seminar_drcode' => $semdress
			);
		
		$inssts = $this->seminar_data->input_data($data,'seminar');
			//
		if ($inssts) {

			$zero = 0 ;
			$curdate = date('Y-m-d'); 
			do {
				$bookid =  random_string('nozero', 6);
				$resbook = $this->seminar_data->cekspecode($bookid,'payment_id','payment');
				if ($resbook){
					$reserved_adspayid = $bookid;
				}
			} while ($resbook == false);

			$data_adspayid = array(
				'payment_id' => $reserved_adspayid.$zero,
				'payment_created' =>  $curdate);

			$inssts_pay_id = $this->seminar_data->input_data($data_adspayid,'payment');
			//
		if ($inssts_pay_id) {
			do {
				$bookid =  random_string('nozero', 5);
				$resbook = $this->seminar_data->cekspecode($bookid,'ads_id','user_trx_ads');
				if ($resbook){
					$reserved_adsid = $bookid;
				}
			} while ($resbook == false);

			$dataads = array(
				'ads_id' => $reserved_adsid,
				'user_id' => $userid,
				'seminar_id' => $reservedid,
				'ads_payment_id' => $reserved_adspayid.$zero,
				'ads_trx_status' => 'Review By Admin'
				);
			
			$inssts_usertrxads = $this->seminar_data->input_data($dataads,'user_trx_ads');
		}
		//
		if($inssts_usertrxads){
			$stsup = $this->up_pict($reservedid);
			if($stsup){
				redirect('ads/user');
				}
			}	
		}
	 }	
	}

	private function up_pict($s_id) { //do upload file after insert
		$config0['upload_path']          = './asset/pict/sert_template/';
		$config0['allowed_types']        = 'jpg|png|jpeg';
		$config0['file_name']            = $s_id.'.png'; //this
		$config0['overwrite']			= true;
		$config0['max_size']             = 0; // 1MB
		$this->load->library('upload');
		$this->upload->initialize($config0);
		$this->upload->do_upload('semcert') ;//this
		

		$config1['upload_path']          = './asset/pict/banner/';
		$config1['allowed_types']        = 'jpg|png|jpeg';
		$config1['file_name']            = $s_id.'.png'; //this
		$config1['overwrite']			= true;
		$config1['max_size']             = 0; // 1MB
		$this->upload->initialize($config1);
		$this->upload->do_upload('semban') ;//this
		return true;
		}



function changepage ($par){
	$userid = $this->session->userdata('user_id');
	if($par == "profile"){
		echo '<form method="post" action="./insertads/'.$userid.'" enctype="multipart/form-data" id="myform">    
		<div id="rightbody2">
			<div id="objright2">
				<div id="row">
					<div id="col-25"> 
						Seminar Name
					</div>
					<div id="col-75"> 
						<input type="text" id="semname" name="semname" placeholder="Fill the name of your seminar event" required>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						Seminar Date
					</div>
					<div id="col-75"> 
						<input type="date" id="semdate" name="semdate"  required>
					</div>
				</div>
				
				<div id="row">
					<div id="col-25"> 
						Time Start
					</div>
					<div id="col-75"> 
						<input type="time" id="semtime" name="semtime"  required>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						Seminar Seat
					</div>
					<div id="col-75"> 
						<input type="number" id="semseat" name="semseat" min="50" placeholder="Fill required seat number your event" required>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						Seminar City
					</div>
					<div id="col-75"> 
						<input type="text" id="semcity" name="semcity" placeholder="Enter the city where event held on" required>
					</div>
				</div>

				<div id="row" >
					<div id="col-25"> 
						Seminar Held
					</div>
					<div id="col-75"> 
						<textarea name="semheld" id="semheld" required> Fill seminar held address </textarea>
					</div>
				</div>

				<div id="row" >
					<div id="col-25"> 
						Seminar Description
					</div>
					<div id="col-75"> 
						<textarea name="semdesc" id="semdesc" required> Fill seminar description </textarea>
					</div>
				</div>

				<div id="row" >
					<div id="col-25"> 
						Seminar Tag
					</div>
					<div id="col-75"> 
						<div id="col-30"> 
							<label id="container">Business
								<input type="checkbox" name="category[]" value="business">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Charity & Causes
								<input type="checkbox" name="category[]" value="charity">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Family & Education
								<input type="checkbox" name="category[]" value="family">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Fashion
								<input type="checkbox" name="category[]" value="fashion">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Film & Media
								<input type="checkbox" name="category[]" value="film">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Food & Drink
								<input type="checkbox" name="category[]" value="fooddrink">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Goverment
								<input type="checkbox" name="category[]" value="goverment">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Health
								<input type="checkbox" name="category[]" value="health">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Hobbies
								<input type="checkbox" name="category[]" value="hobbies">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Holiday
								<input type="checkbox" name="category[]" value="holiday">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Home & Lifefstyle
								<input type="checkbox" name="category[]" value="homelifefstyle">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Otomotif
								<input type="checkbox" name="category[]" value="otomotif">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">School Activies
								<input type="checkbox" name="category[]" value="schoolactivies">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Science & Tech
								<input type="checkbox" name="category[]" value="sciencetech">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Spiritually
								<input type="checkbox" name="category[]" value="spiritually">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Sport & Fitness
								<input type="checkbox" name="category[]" value="sportfitness">
								<span id="checkmark"></span>
							</label>
						</div>
						<div id="col-30"> 
							<label id="container">Travel & Outdoor
								<input type="checkbox" name="category[]" value="traveloutdoor">
								<span id="checkmark"></span>
							</label>
						</div>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						Seminar Price
					</div>
					<div id="col-75"> 
						<input type="number" id="semprice" name="semprice" placeholder="How much your seminar event costs" required>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						Seminar Dresscode
					</div>
					<div id="col-75"> 
						<input type="text" id="semdress" name="semdress" placeholder="Specify your seminar event dresscode" required>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						Banner or Poster
					</div>
					<div id="col-75"> 
						<input type="file" name="semban" id="semban"> 
						<div id="font3"> Max size 2 Mb
						</div>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						Certificate Temp
					</div>
					<div id="col-75"> 
						<input type="file" name="semcert" id="semcert">
						<div id="font3"> Max size 2 Mb
						</div>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
					</div>  
					<div id="col-75"> 
						<input type="submit" id="chpass" onClick= "#" name="submit" value="Submit My Seminar Event">
					</div>  
				</div>

			</div>
		</div>
	</form>';
		}//first if
	elseif ($par == "myeventads") {

		echo ' 
		<div id="rightbody3">
			<div id="objright5">
				Your ads status will not appear if your ads got rejected by administrator
			</div>
		</div>
		';
		
	$userid = $this->session->userdata('user_id');

	if(!empty($userid)){
		$qeury = $this->seminar_data->readusersts_db($userid);
		if($qeury->num_rows() > 0){
			foreach($qeury->result_array() as $value)
			{
				$daynum = date('d', strtotime($value['seminar_date']));
				$mounth = date('F', strtotime($value['seminar_date']));
				$year =  date('Y', strtotime($value['seminar_date']));

			echo '

		<div id="rightbody3">
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

				if($value['ads_trx_status'] == "Waiting for Payment"){
					echo '<div id="bota2">
					<a id="a1" href="'.base_url().'payment/confirmation/'.$value['seminar_id'].'/'.$userid.'/1/" >Waiting for payment</a>
					</div>
					';
				}
				elseif($value['ads_trx_status'] == "Payment Reject"){
					echo '<div id="bota2">
					<a id="a1" href="'.base_url().'payment/confirmation/'.$value['seminar_id'].'/'.$userid.'/1/" >Reupload your Payment</a>
					</div>
					';
				}
				else{
					echo'
					<div id="bota2">
						<a id=""  href="#">'.$value['ads_trx_status'].'</a>
					</div>';
				}

				

				echo '
			</div>
		</div>
		' ;
		}
		}
		else{
			echo 'NO REQUESTING ADS'; 
		}
		

	}
		
		
	}//second if

}




}//endtag

?>