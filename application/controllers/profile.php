<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('profile_data');
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
	public function myprofile($direct = 1)//this should use ID parameter
	{	//http://localhost:8080/ci3/index.php/home
		$userid = $this->session->userdata('user_id');
		$username = $this->session->userdata('user_name');
		if(!empty($userid)){//if signing
			$data['user_id'] = $userid;
			$data['username'] = $username;
			$data['state'] = $direct;
			$this->load->view('profile',$data);
		}
		else{	//setting user if not signing
			redirect('home');
		}
	}
	function renderqr($bk_id){
		$this->load->library('Ciqrcode');
			QRcode::png(
				base_url().'verified/user/'.$bk_id,
				$outfile = false,
				$level = QR_ECLEVEL_H,
				$size = 5,
				$margin = 1
			);
	}
	function verfy_cer(){
		$user_id = $this->input->post('user');
		$seminar_id = $this->input->post('seminar');
		$datanew = $this->profile_data->get_cer($seminar_id,$user_id);
		foreach($datanew as $value)
		   { 
			$coordx = explode(',', $value['cert_coord']);
			$textalgn = $coordx[4];
			$textsize = $coordx[5];
			$source = "".base_url()."asset/pict/sert_template/".$value['seminar_id'].".png";
			$cnx	=	$coordx[0];//forname
			$cny	=	$coordx[2];
			$cqrx	=	$coordx[1];  //forQR
			$cqry	=	$coordx[3]; 
			$bk_id  = 	$value['booking_id'];
			$sem_name = $value['seminar_name'];
			$complatename = $value['first_name'].''.$value['last_name'];
		   }
		echo json_encode(
			array(
				'source' => $source,
				'cnx' => $cnx,
				'cny' => $cny,
				'cqrx' => $cqrx,
				'cqry' => $cqry,
				'bk_id' => $bk_id,
				'sem_name'=> $sem_name,
				'complatename'=> $complatename,
				'textalgn'=> $textalgn,
				'textsize'=> $textsize
			   )
			);
	}
	function up_profile(){
		$userid = $this->session->userdata('user_id');
		if(!empty($userid)){
			$file = $_FILES['profilepic']['name'];
			if(!empty($file)){
			$this->up_pict($userid);}
			$status = $this->input->post('status');
			$tanggallahir = $this->input->post('tanggallahir');
			$nohp = $this->input->post('nohp');
			$sex = $this->input->post('sex');
			$alamat = $this->input->post('alamat');
			$data = array(
				'date_born' => $tanggallahir,
				'user_phone' => $nohp,
				'user_gender' => $sex,
				'user_address' => $alamat,
				'user_jobs' => $status);
				$this->profile_data->update_data($data,'user','user_id' ,$userid);
			redirect('profile/myprofile', 'refresh');
		}
	}
	function chpasswr(){
		$passold = $this->input->post('passwordold1');
		$passnew = $this->input->post('passwordnew1');
		$email = $this->input->post('email1');
		$enpassold = md5($passold);
		$enpassnew = md5($passnew);
		$data = array(
			'password' => $enpassnew,
			);
			$cek = $this->profile_data->update_password($data,'user',$email ,$enpassold);
		if($cek){
			$status = true;
			$msg = "Successfully Update"; 
		}
		else{
			$status = true;
				$msg = "There is something wrong on you";
		}

			echo json_encode(
				array(
					'status' => $status,
					'msg' => $msg
				   )
				);
	}

	private function up_pict($filename) {
			$config['upload_path']          = './asset/pict/temporary/';
			$config['allowed_types']        = 'jpg|png|jpeg';
			$config['file_name']            = $filename.'.png';
			$config['overwrite']			= true;
			$config['max_size']             = 0; // 1MB
			// $config['max_width']            = 1024;
			// $config['max_height']           = 768;
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('profilepic')) {
				$gbr = $this->upload->data();
				$config['image_library']='gd2';
                $config['source_image']='./asset/pict/temporary/'.$gbr['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= FALSE;
                $config['quality']= '60%';
                $config['new_image']= './asset/pict/profile/'.$gbr['file_name'];
                $this->load->library('image_lib', $config);
				$resizex =$this->image_lib->resize();	
				if($resizex){
						unlink('./asset/pict/temporary/'.$gbr['file_name']);
						return true;
				}
				
			}
			else{
				$error = $this->upload->display_errors();

				return false;
			}
	}
	function changepage ($par){
		$outputcnt = "";
		$outputhead = "";
		$userid = $this->session->userdata('user_id');
		
	if($par == "profile"){
			$userdata = $this->profile_data->get_userdata($userid);
			foreach ($userdata->result_array() as $value) {
				$firstnamefill = str_replace(" ","&nbsp;",$value['first_name']);
				$name = ucwords($firstnamefill."&nbsp;".$value['last_name']);
				
	 
	$outputhead .=' 
		<div id="objtop">
			<center>
			<h1> Profile </h1> 
			Please complete your data. Your personal data is needed for the administration process
			</center>
		</div>';
		
	$outputcnt .='
	<form method="post" action="'.base_url().'profile/up_profile" enctype="multipart/form-data" id="myform">
	<div id="rightbody2">
		<div id="objright2">
			<div id="row">
				<div id="col-25v2"> 
					Profile Picture
				</div>
				<div id="col-75v2">'; 

				$path = './asset/pict/profile/'.$userid.'.png';
        if(file_exists($path)){
			$outputcnt .='<img id="icon" src="'.base_url().'asset/pict/profile/'.$userid.'.png"> ';}
				 else{
					$outputcnt .='<img id="icon" src="'.base_url().'asset/pict/profile/default.png"> ';
				 }
				
				
				 $outputcnt .= '</div> </div>
			<div id="row">
				<div id="col-25v2"> </div>
				<div id="col-75v2"> 
					<input type="file" name="profilepic" accept="image/*" id = "file">
				</div>
			</div>

			<div id="row">
				<div id="col-25"> 
					Firstname 
				</div>
				<div id="col-75"> 
					<input type="text" id="firstname" name="firstname" value='.ucwords($firstnamefill).' disabled>
				</div>
			</div>
			<div id="row">
			<div id="col-25"> 
				Lastname 
			</div>
			<div id="col-75"> 
					<input type="text" id="lastname" name="lastname" value='.ucwords($value['last_name']).' disabled>
			</div>
		</div>
			<div id="row">
				<div id="col-25"> 
				Day Of Birth
				</div>
				<div id="col-75"> 
					<input type="date" id="tanggallahir" name="tanggallahir" placeholder="Enter your date of birth" value ='.$value['date_born'].'>
				</div>
			</div>
			
			<div id="row">
				<div id="col-25"> 
					Gender
				</div>
					<div id="col-75"> 
					<select name="sex" >';

					if($value['user_gender'] == "Pria"  || $value['user_gender'] == "Wanita"){
						$outputcnt .= '
						<option value="'.$value['user_gender'].'" selected>'.$value['user_gender'].'</option>
						';
					}else{
						$outputcnt .= '
						<option value="" selected>Not Selected</option>
						<option value="Pria">Pria</option>
						<option value="Wanita">Wanita</option>
				';
					}
				
					$outputcnt .='
					</select>
				</div>
			</div>
			<div id="row">
				<div id="col-25"> 
					Handphone
				</div>
				<div id="col-75"> 
					<input type="number" id="nohp" name="nohp" placeholder="Enter your mobile number" value="'.$value['user_phone'].'">
				</div>
			</div>
				<div id="row">	
					<div id="col-25"> 
						Job Status
					</div>
				<div id="col-75"> 
				<input type="text" name="status" placeholder="Enter your job status" value="'.$value['user_jobs'].'">
				</div>
			</div>
			<div id="row" >
				<div id="col-25"> 
					Address
				</div>
				<div id="col-75"> 
					<textarea name="alamat" id="alamat" placeholder="Your sweet home" style="height: 200px;" >'.$value['user_address'].'</textarea>
				</div>
			</div>
			<div id="row">
				<div id="col-25"> 
				</div>  
				<div id="col-75"> 
					<input type="submit" id="chprofile" name="submit" value="Save">
				</div>  
			</div>
			';
			if(!empty($failupload)){
				echo $failupload;
			}
			$outputcnt .= '
		</div>
	</div>
	</form>
	';
			   }
		}//first if
elseif ($par == "myevent") {
	$out ="";
	$userdata = $this->profile_data->get_seminar_history($userid);

	$outputhead .=' 
		<div id="objtop">
			<center>
			<h1> My Event </h1> 
			Your Footprint are Here
			</center>
		</div>';

	$outputcnt .='
		<div id="rightbody4">
			<div id="objright5">
				<img id="img" src="'.base_url().'asset/pict/icon/search-icon.png">
				<input type="text" id="history" placeholder="Search Your History" onkeyup="search_seminar(this.value)" name="history">
			</div>
		</div>
		<div id = "result_searching" ></div>
		<div id = "result_sem" >';
			foreach ($userdata->result_array() as $value) {
			$dayname = date('D', strtotime($value['seminar_date']));
            $daynum = date('d', strtotime($value['seminar_date']));
            $mounth = date('F', strtotime($value['seminar_date']));
			$year =  date('Y', strtotime($value['seminar_date']));
			$fulldate = date('Y-m-d',strtotime($value['seminar_date']));
			$currdate = date('Y-m-d'); 
			//$minute =  date('i', strtotime($value['seminar_date']));
			//updating status
			if( ($value['atten_status'] == "Booked") && ($currdate > $fulldate) ){
				$userdata = $this->profile_data->u_not_a($userid,$value['seminar_id']);
				
				}
			if($value['atten_status'] == "Booked"){
				$out = '	<div id="botabok">
				<a id="bota1" href="'.base_url().'event_detail/'.$value['seminar_id'].'">Booked</a>
						</div>';
				}
			else if($value['atten_status'] == "Waiting Payment"){
			$out = '	<div id="bota">
					<a id="bota1" href="'.base_url().'payment/confirmation/'.$value['seminar_id'].'/'.$userid.'/0/">' .$value['atten_status'].'</a>
					</div>
					<div id="bota2">
						<a href="'.base_url().'/event_detail/cancle/'.$value['seminar_id'].'/'.$userid.'/1"> Cancel </a>
						</div>';
			}
			else if($value['atten_status'] == "Waiting Confirmation"){
			$out = '<div id="bota">
					<a id="bota1" href="'.base_url().'event_detail/'.$value['seminar_id'].'">'.$value['atten_status'].'</a>
					</div>
					<div id="bota2">
						<a style="width:80px" href="'.base_url().'payment/confirmation/'.$value['seminar_id'].'/'.$userid.'/0/"> ReUpload </a>
						</div>';
			}
			else if($value['atten_status'] == "Missing Attendance" ){
				$out = '
					<div id="botamiss">
						<a href="#">Missing Attendance</a>
						</div>'	;
			}
			else if( ($value['atten_status'] == "Attend On Stage") && ($currdate > $fulldate) ){
				$out = '<div id="botaatt">
						<a href="'.base_url().'event_detail/'.$value['seminar_id'].'">'.$value['atten_status'].'</a>
						
						</div>
						
					<div id="bota2"><a style="width:70px" onClick= "get_cer('.$userid.','.$value['seminar_id'].')" href="#">Certificate</a></div>';		
			}
			else{
				$out = '<div id="bota">
						<a id="bota1" href="'.base_url().'event_detail/'.$value['seminar_id'].'">'.$value['atten_status'].'</a>
						</div>';
				}
	$outputcnt .='
		<div id="rightbody3" class="rightbody3">
			<div id="objright3">
				<img src="'.base_url().'asset/pict/banner/'.$value['seminar_id'].'.png">
			</div>
			<div id="objright4">
				<div id="desc">
					<div id="namaseminar">
					'.$value['seminar_name'].'
					</div>  
					<div id="dateseminar">
					'.$daynum.'&nbsp;'.$mounth.'&nbsp;'.$year.'
					</div> 
					<div id="locseminar">
					'.ucwords($value['seminar_held']).'</div>  
					<div id="locseminar2">
					'.$value['seminar_city'].'</div>  
				</div>
					'.$out.'
			</div>

	</div>';
			}
	$outputcnt .='</div>';
}//second if

elseif ($par == "setting") {
	
	$userdata = $this->profile_data->get_userdata($userid);
	foreach ($userdata->result_array() as $value) {

	$outputhead .=' 
		<div id="objtop">
			<center>
			<h1> Settings </h1> 
			Configure your account, change the password for a certain time period
			</center>
		</div>';

	$outputcnt .='
		<div id="rightbody2">
			<div id="objright2">
				<div id="row">
					<div id="col-25"> 
						Email
					</div>
					<div id="col-75"> 
						<input type="email" id="email" name="email" value="'.$value['email'].'" disabled>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						Old Password
					</div>
					<div id="col-75"> 
						<input type="password" placeholder="Fill old your cute secret code" id="passwordold" name="passwordl" required>
					</div>
				</div>

				<div id="row">
					<div id="col-25"> 
						New Password
					</div>
					<div id="col-75"> 
						<input type="password" placeholder="Change with the cute one" id="passwordnew" name="passwordb" required>
					</div>
				</div>
			
				<div id="row">
					<div id="col-25"> 
					</div>  
					<div id="col-75"> 
						<input type="submit" id="chpass" onClick= "chpass()" name="submit" value="Save">
					</div>  
				</div>
			</div>
		</div>';
	}
}//third if

			echo json_encode(
				array(
					'head' => $outputhead,
					'cnt' => $outputcnt
					)
				);
	}//end functionchange



}//endpoint
