<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/event_detail.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/event_detail_resolusi.css">
    <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-3.4.1.min.js"></script>
</head>
<body>
    <div id="wrapper">
        
    <div id="topr">
    </div>

    <!-- bagian navbar  -->
    <?php if(!empty($user_id))
    {
        echo '
        <div id="top">
            <div id="navbar_kiri">
                <a href="'.base_url().'home"> Seminar Go </a>
            </div>
            
            <div id="navbar_kanan">

                <div id="jdrop" class="dropdown">
                    <div id="jdrop" class="p"> Welcome '.$username.' ! </div>
                    ';
                    $path = './asset/pict/profile/'.$user_id.'.png';
                    if(file_exists($path)){
                    echo' <img id="jdrop" class="imgdrop" src="'.base_url().'asset/pict/profile/'.$user_id.'.png">
                    ';}
                    else{
                        echo' <img id="jdrop" class="imgdrop" src="'.base_url().'asset/pict/profile/default.png">
                    ';}

                if( (!empty($user_id)) && ($user_id == 1)  ){
                    echo'
                </div>
                <div id="jcdrop" class="dropdown-content">
                    <div id="jdrop" class="p2"> Welcome '.$username.' ! </div>
                    <a href="'.base_url().'profile_admin/Admin"> Profile </a> 
                    <a href="'.base_url().'logout"> Sign Out </a></div>
                </div>
            </div> ';
                    }
             else{
                echo'</div>
                       <div id="jcdrop" class="dropdown-content">
                            <div id="jdrop" class="p2"> Welcome '.$username.' ! </div>
                            <a href="'.base_url().'profile/myprofile/1"> Profile </a> 
                            <a href="'.base_url().'profile/myprofile/2"> My Event </a> 
                            <a href="'.base_url().'profile/myprofile/3"> Settings </a> 
                            <a href="'.base_url().'logout"> Sign Out </a></div>
                       </div>
                   </div> ';
                }
    }
    else{
        echo '
        <div id="top">
            <div id="navbar_kiri">
                <a href="'.base_url().'home"> Seminar Go </a>
            </div>

            <div id="navbar_kanan">
                <a id="a" href="'.base_url().'login/">Sign in</a>
            </div>
        </div> ';
    }
    
    ?>   

    <!-- bagian isi  -->
  
    <div id="body">
        <div id="bodyartikel2">
            <div id="shadow">
                <div id="flexbod">
                <?php
                
                $seatsts = false;

                    foreach ($seminar as $value) {
                        if($value['seminar_price'] == 0){
                            $price = "FREE";
                        }
                        else {
                            $price = $value['seminar_price'];
                        }
                        echo'
                    <div id="leftposttop">
                        <img id="imps" src="'.base_url().'asset/pict/banner/'. $value['seminar_id'].'.png">
                    </div>
            
                    <div id="rightposttop">
                        <div id="padding">
                            <div id="desc">
                                <h2> '.$value['seminar_name'].' </h2> 
                                <p> Rp&nbsp;'.$price.' </p>
                            </div>

                            <img id="qrcode" src="'.base_url('event_detail/renderqr/'.$value['seminar_id'].'/'.$user_id.'').'" alt="">
                        </div>
                    </div>';
                    if($seat<=$value['seminar_seat'] ){
                        $seatsts = true;
                         }
                    
                    
                    echo '
                    </div>
                    <div id="flexbod">
                        <div id="leftposttop2">
                            <div id="padding">
                                <div id="desc2">
                                    <p> '.$value['seminar_name'].' </h2> 
                                    <p> Rp&nbsp;'.$price.' </p>
                                </div>

                                <img id="qrcode2" src="'.base_url('event_detail/renderqr/'.$value['seminar_id'].'/'.$user_id.'').'" alt="">
                            </div>
                        </div>
                    </div>'
                    ;} 
        ?>
        </div>

            <div id="shadow">
                <div id="flexbod">
                    <div id="leftpost">
                        <div id="tag-flex">
                            <div id="padding2">
                <?php

                

                $userid = $this->session->userdata('user_id');

                if($seatsts){
                            if( (!empty($userid)) && (!empty($registered)) ){

                            $register_fill = str_replace(" ","&nbsp;",$registered);
                                foreach ($seminar as $value) {
                                    echo 
                                '<a id="a1" href="'.base_url().'payment/confirmation/'.$value['seminar_id'].'/'.$userid.'/0/" >'.$register_fill.'</a>';
                                    }
                                    
                                $this->session->unset_userdata('seminar_id');
                            }

                            else if(!empty($userid)){
                                foreach ($seminar as $value) {

                                    echo 
                                '<a id="a1" href="#" onClick="send('.$value['seminar_id'].','.$userid.','.$value['seminar_price'].');"> Daftar </a>';
                                    }
                                    
                                $this->session->unset_userdata('seminar_id');
                            }
                            else{
                                echo
                                '<a id="a1" href='. base_url().'login/> Daftar </a>';
                            }
                }
                else{
                    echo "SEAT FULL";
                }
                    ?>
                    </div>
                    <div id="padding2">
                         <?php
                         $userid = $this->session->userdata('user_id');
                         if( (!empty($userid)) && (!empty($registered)) ){
                        foreach ($seminar as $value) {
                          echo  '<a class="cancle" id="a2" href="./cancle/'.$value['seminar_id'].'/'.$userid.'/0"> Cancel </a>';
                        }
                    }
                    if(!empty($verifiedpos)){
                        foreach ($seminar as $value) {
                            echo 
                        '<a id="apos" href='. base_url().'event_detail/pos/'.$value['seminar_id'].'> Positioning </a>';
                            }
                     }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="shadow">
                <div id="flexbod">
                    <div id="leftpost2">
                    <?php
                    
                    foreach ($seminar as $value) {
                //convert time
                $dayname = date('l', strtotime($value['seminar_date']));
                $daynum = date('d', strtotime($value['seminar_date']));
                $mounth = date('m', strtotime($value['seminar_date']));
                $year = date('Y', strtotime($value['seminar_date']));
                $hours =  date('H', strtotime($value['seminar_date']));
                $minute =  date('i', strtotime($value['seminar_date']));
                $month_num =$mounth; 
                $month_name = date("F", mktime(0, 0, 0, $month_num, 10));  
                $sbstr =  substr($dayname,0,3);


                echo ' 
                <div id="obj-post">
                <div id="obj-judul"> Available Seat </div>';
                if($seatsts){
                    echo'<p>'.$seat.'/'.$value['seminar_seat'].'</p>';
                }
                else{
                    echo'<p>Sorry no space here</p>';
                }
                echo ' 
            </div>
                    <div id="obj-post">
                        <div id="obj-judul"> Date and Time </div>
                        <p>'.$sbstr.',&nbsp;'.$daynum.'&nbsp;'.$month_name.'&nbsp;'.$year.'<br>'.$hours.'.'.$minute.'</p>
                    </div>

                    <div id="obj-post">
                        <div id="obj-judul"> Dress Code </div>
                        <p>'.$value['seminar_drcode'].'</p>
                    </div>';

                    $cnvt = explode(',' , $value['seminar_tag']);

                        echo 
                        '<div id="obj-post2">
                            <div id="obj-judul"> Description </div>
                            <p> '.$value['seminar_desc'].'</p>
                        </div>

                        <div id="obj-post2">
                            <div id="obj-judul"> Location </div>
                            <p>'.$value['seminar_held'].'</p>
                        </div>

                        <div id="obj-post2">
                            <div id="obj-judul"> Tag </div>
                            <div id="tag-flex2">';
                        foreach ($cnvt as $newloop) {
                            echo'
                                <a href="#">'.$newloop.'</a>' ;
                            }
                            echo' </div>
                        </div>';
                    }
            
                    ?>
                    </div>
            
                    <div id="rightpost2">
                    <?php
                    foreach ($seminar as $value) {
                        //convert to array
                        $cnvt = explode(',' , $value['seminar_tag']);

                        echo 
                        '<div id="obj-post">
                            <div id="obj-judul"> Description </div>
                            <p> '.$value['seminar_desc'].'</p>
                        </div>

                        <div id="obj-post">
                            <div id="obj-judul"> Location </div>
                            <p>'.$value['seminar_held'].'</p>
                        </div>

                        <div id="obj-post">
                            <div id="obj-judul"> Tag </div>
                            <div id="tag-flex2">';
                        foreach ($cnvt as $newloop) {
                            echo'
                                <a href="#">'.$newloop.'</a>' ;
                            }
                            echo' </div>
                        </div>
                        </div>
                        </div>
                            
                        <div id="flexbod">
                            <iframe width="100%" height="250px" src="'.$value['seminar_maps'].'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                            </iframe>
                        </div>';
                        }
            
            ?>
                 
            </div>
        </div>
    </div>





    <!-- bagian footer  -->

    <div id="infofooter600">
    </div>

    <div id="footer">
        <p>Copyright © 2019 </p>
    </div>
    </div>
    
    <script type="text/javascript">
   function send(eventid,userid,ev_val) {
                $.ajax({
					type: "POST",
					url: "<?php echo base_url();?>event_detail/applyevent/"+eventid+"/"+userid+"/"+ev_val,
					cache: false,
					success: function(data){
                        var responParse = JSON.parse(data);
                        if(responParse.msg.length > 0 ){
                            alert(responParse.msg);
                            if(ev_val == 0){
                                window.location.reload();
                            }
                            else{
                                window.location.replace("<?php echo base_url();?>payment/confirmation/"+eventid+"/"+userid);
                            }
                            
                        }
                        else{
                            alert(responParse.msg);
                        }
					}

				});
        }


    window.onclick = function(event) {
        if ( (!event.target.matches('.dropdown')) &&(!event.target.matches('.imgdrop')) && (!event.target.matches('.result_sem')) && (!event.target.matches('.result_loc')) && (!event.target.matches('.p')) ){
            $('#jcdrop').slideUp("fast");
            $("#result_sem").html("");
            $("#result_loc").html("");
            $('#seminar').val("");
            $('#location').val("");
        }
    }

    function getAverageRGB(imgEl) {
    
    var blockSize = 5, // only visit every 5 pixels
        defaultRGB = {r:0,g:0,b:0}, // for non-supporting envs
        canvas = document.createElement('canvas'),
        context = canvas.getContext && canvas.getContext('2d'),
        data, width, height,
        i = -4,
        length,
        rgb = {r:0,g:0,b:0},
        count = 0;
        
    if (!context) {
        return defaultRGB;
    }
    
    height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
    width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;
    
    context.drawImage(imgEl, 0, 0);
    
    try {
        data = context.getImageData(0, 0, width, height);
    } catch(e) {
        /* security error, img on diff domain */alert('x');
        return defaultRGB;
    }
    
    length = data.data.length;
    
    while ( (i += blockSize * 4) < length ) {
        ++count;
        rgb.r += data.data[i];
        rgb.g += data.data[i+1];
        rgb.b += data.data[i+2];
    }
    
    // ~~ used to floor values
    rgb.r = ~~(rgb.r/count);
    rgb.g = ~~(rgb.g/count);
    rgb.b = ~~(rgb.b/count);
    
    return rgb;
    
}

    $(function() {
        //avg color
var rgb = getAverageRGB(document.getElementById('imps'));
document.getElementById('rightposttop').style.backgroundColor = 'rgb('+rgb.r+','+rgb.g+','+rgb.b+')';
document.getElementById('leftposttop').style.backgroundColor = 'rgb('+rgb.r+','+rgb.g+','+rgb.b+')';
 

        let a1 = $('#a1').html();
        if(a1 == "Booked"){
            $('#a1').attr("href","javascript:void(0);");
            $('#a2' ).remove();
            $('#a1').click (function () {  alert("UNIQUE SQUARE AVAILABLE NOW !");  });  
        }
        else if(a1 == "Waiting&nbsp;Confirmation"){ 
            $('#a1').attr("href","javascript:void(0);");
            $('#a2').html("Reupload"); 
            $('#a2').attr("href","<?php $userid = $this->session->userdata('user_id'); foreach ($seminar as $value) { echo base_url().'payment/confirmation/'.$value['seminar_id'].'/'.$userid ;  }?>"); 
            $('#a1').click (function () {  alert("WE WANT TO SEE YOUR INTEND, SOON AS SPEED OF LIGHT");  });  
        }
        
        else if(a1 == "Attend&nbsp;On&nbsp;Stage"){
            $( ".cancle" ).remove();
            $('#a2').html("Reupload");  
        }
        //ALL TRIGEER
        $('#jdrop').on('click', function() {  //.dropdown-content
            let rwidth = $(window).width();
            if (rwidth > 768){
                let wit = $('#jdrop').width();
                wit += 29.8;
                console.log(wit);
                $("#jcdrop").css("width", wit);
                $('#jcdrop').slideDown( "fast" );
            }

            else{
                $('#jcdrop').slideDown( "fast" );
            }
        });
    });

    </script>
</body>
</html>