<?php 
class seminar_data extends CI_Model{
 function cek_verified($b_id){
  $this->db->select('s.seminar_name,s.seminar_date,u.first_name,u.last_name');
  $this->db->from('user_trx t'); 
  $this->db->where('t.booking_id', $b_id);
  $this->db->where('t.atten_status', 'Attend On Stage');
  $this->db->join('seminar s', 's.seminar_id= t.seminar_id');
  $this->db->join('user u', 'u.user_id= t.user_id');      
  $query = $this->db->get();
  if($query->num_rows()>0){
    return $query;
  }
  else{
    return false;
  }
 }

  function readusersts_db ($userid=null){
    $this->db->select('s.seminar_name,s.seminar_date,s.seminar_held,t.ads_trx_status,s.seminar_id,t.ads_payment_id');
    $this->db->from('user_trx_ads t');
    $this->db->where('t.user_id', $userid);
    $this->db->join('seminar s','s.seminar_id = t.seminar_id');
    return $this->db->get();
  }

  function cekspecode($number,$entity,$table){
    $this->db->where($entity,$number);
    $query =  $this->db->get($table);
    if($query->num_rows()>0){
      return false;
    }
    else{
      return true;
    }
    
  }

   function input_data($data,$table){
    $query = $this->db->insert($table,$data);
    if($query){
      return true;
    }
   }

    function update_pos_db($s_id,$data){
      $this->db->where('seminar_id',$s_id);
      $this->db->set('cert_coord',$data);
      $query = $this->db->update('seminar');
      if($query){return true;}
      else{return false;}
    }
    function countseat_db($s_id){
      $this->db->select('booking_id');
      $this->db->from('user_trx ');
      $this->db->where('atten_status','Booked');
      $this->db->where('seminar_id',$s_id);
      $query = $this->db->get();
      return $query->num_rows();
    }
    function getcityfilter(){
      $curdate = date('Y-m-d');
      $this->db->select('s.seminar_city');
      $this->db->from('seminar s');
      $this->db->where('s.seminar_date >=', $curdate);
      $this->db->where('t.ads_trx_status', 'Published');
      $this->db->join('user_trx_ads t','s.seminar_id = t.seminar_id');
     $this->db->order_by('seminar_city', 'ASC');
      return $this->db->get();
    }


    function filter($category=null,$city=null, $price=null,$datestart="anydate",$datemax=null, $limit = null, $offset = null ){
      $curdate = date('Y-m-d');
      $this->db->select("s.seminar_id,s.seminar_name,s.seminar_date,s.seminar_city,t.ads_trx_status");
      
      if($city != null){
        $toarr1 = explode(',',$city);
        $arrlength1 = count($toarr1);//arr length start 1
        if($arrlength1 === 1){
          $this->db->where('s.seminar_city',$toarr1[0]);
        }
        else if($arrlength1 > 1){
          $this->db->group_start();
          for ($i=0; $i<$arrlength1; $i++) { 
            $this->db->or_where('s.seminar_city',$toarr1[$i]);
          }
          $this->db->group_end();
        }
    }
    if($category != null){
      $toarr = explode(',',$category);
      $arrlength = count($toarr);//arr length start 1
      if($arrlength === 1){
        $this->db->like('s.seminar_tag',$toarr[0]);
      }
      else if($arrlength > 1){
        $this->db->group_start();
        for ($i=0; $i<$arrlength; $i++) { 
           $this->db->or_like('s.seminar_tag',$toarr[$i]);
        }
        $this->db->group_end();
      }
  }
      if (!empty($datemax)) {
        $this->db->where('s.seminar_date >= ',$datestart);
        $this->db->where('s.seminar_date <=',$datemax);
      }
      elseif($datestart == "anydate"){
        $this->db->where('s.seminar_date >=', $curdate);
      }
      elseif(!empty($datestart)){
        $this->db->where('DATE(s.seminar_date)',$datestart);
      }

      
      if (!empty($price)) {
        if($price == "free"){
          $this->db->where('s.seminar_price', 0);
        }
        else{
          $this->db->where('s.seminar_price >', 0);
        }
      }

     
    $this->db->join('user_trx_ads t','t.seminar_id = s.seminar_id');
    $this->db->where('t.ads_trx_status', 'Published');
    $this->db->order_by('s.seminar_date', 'ASC');
    return $this->db->get('seminar s',$limit,$offset);
    
    }
    function scan_update($payid){
      $this->db->where('payment_id',$payid);
      $this->db->set('atten_status','Attend On Stage');
      $query = $this->db->update('user_trx');
      if($query){return true;}
      else{return false;}
    }

    function deletetrx($eventid,$userid){
      $this->db->select('payment_id');
      $this->db->where('seminar_id', $eventid);
      $this->db->where('user_id', $userid);
      $query = $this->db->get('user_trx');
      $getval = $query->row();
      $val = $getval->payment_id;
      if($query->num_rows() == 1){
        $this->db->where('user_id', $userid);
        $this->db->where('seminar_id', $eventid);
        $query2 = $this->db->delete('user_trx');
        if($query2){
          $this->db->where('payment_id', $val);
          $query2 = $this->db->delete('payment');
          return true;
        }
      }
    }
    function getqrcode($eventid,$userid){
      $this->db->select('booking_id');
      $this->db->where('user_id', $userid);
      $this->db->where('atten_status', 'Booked');
      $this->db->where('seminar_id', $eventid);
      $query =  $this->db->get('user_trx');
      return $query->row();
    }

    function cekseminar_user($eventid,$userid){
      $this->db->where('user_id', $userid);
      $this->db->where('seminar_id', $eventid);
      $query =  $this->db->get('user_trx');
      if($query->num_rows()>0){
        return false;
      }
      else{
        return true;
      }
}

  function get_seminar_detail($id=null,$uid=null){

    $curdate =  date('Y-m-d');
    $this->db->select("s.seminar_price,s.seminar_id,s.seminar_name,s.seminar_seat,s.seminar_date,s.seminar_held,s.seminar_drcode,s.seminar_tag,s.seminar_desc,s.seminar_maps");
    $this->db->from('seminar s');
    $this->db->where('s.seminar_id',$id);
    $this->db->where('s.seminar_date >=', $curdate);
    if($uid != 1){
      $this->db->where('t.ads_trx_status', 'Published');
    }
    $this->db->join('user_trx_ads t','s.seminar_id = t.seminar_id');
    return $this->db->get();
   
  }
 
  function search_user_his($key = null,$u_id){
    $this->db->select("s.seminar_id, s.seminar_name, s.seminar_date, s.seminar_held, t.atten_status" );
    $this->db->from('user_trx t');
    $this->db->where('t.user_id', $u_id);
    $this->db->like('s.seminar_name', $key);
    $this->db->join('seminar s','s.seminar_id = t.seminar_id');
    $this->db->order_by('s.seminar_date', 'ASC');
    return $this->db->get();
  }
  function search_seminar($key = null/*,$type = null*/){
    $curdate = date('Y-m-d');
    $this->db->select("seminar_id,seminar_name");
    $this->db->from("seminar");
    $this->db->where('seminar_date >=', $curdate);
    //if($type === "#result_sem"){
    $this->db->like('seminar_name', $key);
    $this->db->order_by('seminar_name', 'ASC');
    //}
    /*elseif ($type === "#result_loc") {
      $this->db->like('seminar_city', $key);
      $this->db->order_by('seminar_city', 'ASC');
    }*/
    return $this->db->get();
  }
  function userinftrx($seminar_id = null,$user_id = null ){
    $this->db->select("atten_status");
    $this->db->where('seminar_id ',$seminar_id);
    $this->db->where('user_id ',$user_id);
    $query =  $this->db->get('user_trx');
    if($query->num_rows()>0){
      return $query->row();
    }
  }
  function payment_detail ($seminarid=null,$userid=null,$mode=null){
    if($mode == 1){
      $paymentid =  "t.ads_payment_id";
      $table = "user_trx_ads t";
    }
    else{
      $paymentid =  "t.payment_id";
      $table = "user_trx t";
    }
      $this->db->select('s.seminar_name,s.seminar_date,s.seminar_held,s.seminar_price,'.$paymentid);
      $this->db->from($table);
      $this->db->where('t.user_id', $userid);
      $this->db->where('t.seminar_id', $seminarid);
      $this->db->join('seminar s','s.seminar_id = t.seminar_id');
      return $this->db->get()->result_array();
    }


  }//endclass
?>
