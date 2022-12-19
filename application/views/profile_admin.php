<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/profile_admin.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/profile_admin_resolusi.css">
    <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-3.4.1.min.js"></script>
</head>
<body>
    <div id="wrapper">

    <div id="topr">
    </div>

    <!-- bagian navbar  -->
    
    <?php  if(!empty($user_id))
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
                ';
                }

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
                <input type="text" id="seminar" name="seminar" class = "result_sem" placeholder="Cari seminar">
            </div>
            
            <div id = "result_sem" ></div>
            
            <div id="navbar_kanan">
            <a id="a" href="'.base_url().'ads">Advertising </a> 
            <a id="a" href="'.base_url().'login/">Sign in</a>
            </div>
        </div> ';
    }
    
//$("a:visited").parent("li").addClass("is_visited");        
    ?>

    <!-- bagian isi  -->
    <div id="body">
        <div id="bodyartikel2">
            <div id="leftbody">
                <div class="objleft">
                    <a href="javascript:void(0);" id ="app-pay"> Approval Payment </a>
                </div>
                <div class="objleft">
                    <a href="javascript:void(0);" id ="app-sem"> Approval Seminar </a>
                </div>
            </div>

            <div id="mainright">
	          
               
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
    window.onclick = function(event) {
        if ( (!event.target.matches('.dropdown')) &&(!event.target.matches('.imgdrop')) && (!event.target.matches('.result_sem')) && (!event.target.matches('.result_loc')) && (!event.target.matches('.p')) ){
            $('#jcdrop').slideUp("fast");
            $("#result_sem").html("");
            $("#result_loc").html("");
            $('#seminar').val("");
            $('#location').val("");
        }
    }

    $(function() {

       window.approve = function(ads_id,s_id){
                        let ads_val_maps = $("#"+ads_id).val();
                       // alert(ads_val);
                       if(ads_val_maps.length > 0 ){
                        $.ajax({
                        url:"<?php echo base_url(); ?>profile_admin/chsts_app_ads/",
                        method:"POST",
                        data:{maps:ads_val_maps,adsid:ads_id,sid:s_id},
                        
                        success:function(data){
                            var responParse = JSON.parse(data);
                                    if( responParse.sts == true  ){
                                        alert(responParse.msg);
                                        window.location.replace("<?php echo base_url();?>profile_admin/Admin/2");
                                    }
                                    else{
                                        alert(responParse.msg);
                                        window.location.replace("<?php echo base_url();?>profile_admin/Admin/2");
                                    }
                            
                                }
                        }); 

                       }
                       else{
                           alert('Dont forget the Maps !');
                       }
                        
                    }

        function navToContent(url){
		$.ajax({
			type: "GET",
			url: url,
			cache: false,
			beforeSend: function(data){
				$("#mainright").html("");
			},
			success: function(data){
				$("#mainright").html(data);
			}
		});
		return false;
    }
    //all trigerstate
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

    $('#app-pay').click(function () {
        $("div#leftbody > div.objleft" ).removeClass("active");
        $(this).parent().addClass("active");
        let urli = "<?php echo base_url(); ?>profile_admin/changepage/app-pay";
        navToContent(urli);
        });
    $('#app-sem').click(function () {
        $("div#leftbody > div.objleft" ).removeClass("active");
        $(this).parent().addClass("active");
        let urli = "<?php echo base_url(); ?>profile_admin/changepage/app-sem";
        navToContent(urli);
        });
    $(document).ready(function() {
        let state = <?php echo $state?>;
        if(state == 1){
            $('#app-pay').click();
        }
        else if (state == 2) {
            $('#app-sem').click();
        }
     });
    });
    

    </script>
</body>
</html>