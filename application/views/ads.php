<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/ads.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/ads_resolusi.css">
    <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-3.4.1.min.js"></script>

    
</head>
<body>
    
    <div id="wrapper">

    <div id="topr">
    </div>

    <!-- bagian navbar  -->

    <div id="top">
        <div id="navbar_kiri">
            <a href="<?php echo base_url();?>"> Seminar Go </a>
        </div>

        
        <div id="navbar_kanan">
            <?php if(!empty($user_id)){ 
                echo '
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
                                <a href="'.base_url().'logout"> Sign Out </a>
                            </div>
                        </div>
                    </div> 
                    ';}
                    
                    else{
                        echo'
                            </div>
                                <div id="jcdrop" class="dropdown-content">
                                    <div id="jdrop" class="p2"> Welcome '.$username.' ! </div>
                                    <a href="'.base_url().'profile/myprofile/1"> Profile </a> 
                                    <a href="'.base_url().'profile/myprofile/2"> My Event </a> 
                                    <a href="'.base_url().'profile/myprofile/3"> Settings </a> 
                                    <a href="'.base_url().'logout"> Sign Out </a>
                                </div>
                    ';}
            }?>
        </div>
    </div>

        <!-- bagian isi  -->
        
    <div id="body">
        <div id="bodyartikel2">
            <div id="toppost">
                <div id="objtop">
                    <center>
                    <h1> Advertising </h1> 
                    Advertise your seminar event on the most popular platform seminar event in the world
                    </center>
		        </div>
            </div>

            <div id="topmenu">
                <div class="objleft2">
                    <a href="javascript:void(0);" id ="profile2"> Advertising Form </a>
                </div>
                <div class="objleft2">
                    <a href="javascript:void(0);" id ="myeventads2"> My Status Ads</a>
                </div>
            </div>

            <div id="leftbody">
                <div class="objleft">
                    <a href="javascript:void(0);" id ="profile"> Advertising Form </a>
                </div>
                <div class="objleft">
                    <a href="javascript:void(0);" id ="myeventads"> My Status Ads</a>
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

$(function() {

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

    $('#profile').click(function () {
        $("div#leftbody > div.objleft" ).removeClass("active");
        $(this).parent().addClass("active");
        let urli = "<?php echo base_url(); ?>ads/changepage/profile";
        navToContent(urli);
        });
    $('#myeventads').click(function () {
        $("div#leftbody > div.objleft" ).removeClass("active");
        $(this).parent().addClass("active");
        let urli = "<?php echo base_url(); ?>ads/changepage/myeventads";
        navToContent(urli);
        });

    $('#profile2').click(function () {
        $("div#topmenu > div.objleft2" ).removeClass("active2");
        $(this).parent().addClass("active2");
        let urli = "<?php echo base_url(); ?>ads/changepage/profile";
        navToContent(urli);
        });
    $('#myeventads2').click(function () {
        $("div#topmenu > div.objleft2" ).removeClass("active2");
        $(this).parent().addClass("active2");
        let urli = "<?php echo base_url(); ?>ads/changepage/myeventads";
        navToContent(urli);
        });
        
    $(document).ready(function() {
        let state = <?php echo $state?>;
        if(state == 1){
            $('#profile').click();
            $('#profile2').click();
        }
        else if (state == 2) {
            $('#myeventads').click();
            $('#myeventads2').click();
        }
     });

});
    
    </script>
</body>
</html>

    