<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/positioning.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/positioning_resolusi.css">

</head>

<body>

	<!-- bagian navbar  -->

	<div id="wrapper">

    <div id="topr">
    </div>

    <div id="top">
        <div id="navbar_kiri">
            <a id="hideico" href="<?php echo base_url(); ?>home"> Seminar Go </a>
        </div>
    
    <?php if(!empty($user_id)){

        if( (!empty($user_id)) && ($user_id == 1)  ){
            echo'

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
                
                echo' </div>

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
  
            <div id="navbar_kanan">
                <a id="a" href="'.base_url().'ads/user">Advertising </a>

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

                echo'</div>

                <div id="jcdrop" class="dropdown-content">
                    <div id="jdrop" class="p2"> Welcome '.$username.' ! </div>
                    <a href="'.base_url().'profile/myprofile/1"> Profile </a> 
                    <a href="'.base_url().'profile/myprofile/2"> My Event </a> 
                    <a href="'.base_url().'profile/myprofile/3"> Settings </a> 
                    <a href="'.base_url().'logout"> Sign Out </a>
                </div>
            </div>
        </div> 
        ';}
    }

    else{
        echo '
            <div id="navbar_kanan">
                <a id="a" href="'.base_url().'login/">Advertising </a>
                <a id="a" href="'.base_url().'login/">Sign in</a>

                <img class="schico" id="img" src="'.base_url().'asset/pict/icon/search-icon2.png">
            
                    <div class="humbermenico" id="container">
                        <div class="humbermenico" id="bar1"></div>
                        <div class="humbermenico" id="bar2"></div>
                        <div class="humbermenico" id="bar3"></div>
                    </div>
                
                <div id="dropdown-content2">
                    <a href="'.base_url().'login/"> Advertising </a>
                    <a href="'.base_url().'login/"> Sign In </a> 
                </div>
            </div>
        </div>'
        ;
    }
    
    ?>
	
	<!-- bagian isi  -->
	<div id="body">
		<div id="containertop">
			<div id="judul">Set Position</div>
			<div id="contpage">
				<div id="objright2">
					<div id="row">
						<div id="col-25">
							Text Size
						</div>
						<div id="col-75">
							<input type="number" id="textsize" name="textsize" value="16" placeholder="Text Size">
						</div>
					</div>

					<div id="row">
						<div id="col-25">
							Align Position
						</div>
						<div id="col-75">
							<select id = "textalgn" name="textalgn">
								<option value="left"selected>Left</option>
								<option value="center">Center</option>
								<option value="right">Right</option>
							</select>
						</div>
					</div>

					<div id="row">
						<div id="col-25">
						</div>
						<div id="col-75">
							<button id="get">Get Position</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<center>
			<div id="containment" style="background-image: url(<?php echo base_url().'asset/pict/sert_template/'.$sem_id.'.png'; ?>);">
				<div id="name">The Longest Name Ever Ever</div>
				<div id="box">QR CODE</div>
			</div>
		</center>
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

});


var top1,left1,left2,top2,textalgn,txtsize,resnameleft1,resnametop1;//name,qr
var coordinates = function(element) {
    element = $(element);
	top1 = element.position().top;
	left1 = element.position().left;
	// console.log(left1); //x
	 //console.log(top1);// y
}
var coordinates1 = function(element) {
    element1 = $(element);
	top2 = element1.position().top;
	left2 = element1.position().left;
	// console.log(left2); //x
	// console.log(top2);// y
}


$(function() {
	function getallposition(){

	}
	$('#name').draggable({
	containment: "#containment", scroll: false,
    start: function() {
        coordinates('#name');
    },
    stop: function() {
        coordinates('#name');
    }
	});

	$('#box').draggable({
	containment: "#containment", scroll: false,
    start: function() {
        coordinates1('#box');
    },
    stop: function() {
        coordinates1('#box');
    }
	});

	
		
		
		$('#textalgn').change(function() {
				$('#name').css("text-align", $(this).val());
		});

		$('input[name=textsize]').keyup(function(){
			if($(this).val()<=50){
			$('#name').css('font-size', $(this).val() + 'px');
			txtsize = $(this).val();
			}
			else{
				alert('Maximum Textsize is 50')
			}
        });


	$('#get').click(function() {

		if($("#textalgn").val() == "left"){
				resnametop1 = top1;
				resnameleft1 = left1;
			}
		else if($("#textalgn").val() == "right"){
				let namewidth = $( "#name" ).width();
				resnametop1 = top1;
				resnameleft1 = left1 + namewidth;
			}
		else{
				let namewidth = $( "#name" ).width();
				resnameleft1 = (namewidth / 2) + left1;
				resnametop1 = top1;
			}
			textalgn = $("#textalgn").val();

			let s_id = <?php echo $sem_id?> ;
            $.ajax({
                    url:"<?php echo base_url(); ?>event_detail/getposcert/"+s_id,
                    method:"POST",
                    data:{namex:resnameleft1,namey:resnametop1,qrx:left2,qry:top2,txtalgn:textalgn,textsize:txtsize},
                    success:function(data){
                   alert('Succesfully update position');
                            }
                        });  
	});

});
</script>

<div id="infofooter600">
    </div>

    <div id="footer">
        <p>Copyright © 2019 </p>
    </div>
    </div>
</body>
</html>
