<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/home.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/home_resolusi.css">
    <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-3.4.1.min.js"></script>
</head>
<body>

<!-- bagian navbar  -->

    <div id="wrapper">

    <div id="topr">
    </div>

    <div id="top">
        <div id="navbar_kiri">
            <a id="hideico" href="home"> Seminar Go </a>
            <img id="img" class="result_semcio" src="asset/pict/icon/search-icon.png">
            <input type="text" id="seminar" name="seminar" class = "result_sem" placeholder="Cari seminar">
        </div>
    
        <div id = "result_sem" ></div>
    
    <?php if(!empty($user_id)){

        if( (!empty($user_id)) && ($user_id == 1)  ){ //if user admin
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

        else{ //if user standard
            echo'
  
            <div id="navbar_kanan">
                <a id="a" href="'.base_url().'ads/user">Advertising </a>

                <img class="schico" id="img" src="'.base_url().'asset/pict/icon/search-icon2.png">

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
                    <a id="a3" href="'.base_url().'ads/user">Advertising </a>
                    <a href="'.base_url().'profile/myprofile/1"> Profile </a> 
                    <a href="'.base_url().'profile/myprofile/2"> My Event </a> 
                    <a href="'.base_url().'profile/myprofile/3"> Settings </a> 
                    <a href="'.base_url().'logout"> Sign Out </a>
                </div>
            </div>
        </div> 
        ';}
    }

    else{ // if not login
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

    <!-- bagian header  -->
    <div id="header">
        <div id="headerimg">
            <div id="container">
                <div id="container2">
                    <h1> Solution Your Seminar Gateway </h1>
                    
                    <!-- bagian pencarian  -->

                    <div id="smart">
                        <div id="item">
                            <a id="locact" href="javascript:void(0);"> Location
                                <div id="i" class="icon">
                                </div>
                            </a>
                            
                        </div>

                        <div id="item">
                            <a id="catact" href="javascript:void(0);"> Category 
                                <div id="i" class="iconcat">
                                </div>
                            </a>
                        </div>

                        <div id="item">
                            <div class="custom-select">
                                <select id="date">
                                    <option value="anydate" selected> Any Date </option>
                                    <option value="today"> Today </option>
                                    <option value="tomorrow"> Tomorrow</option>
                                    <option value="thisweekend"> This Weekend</option>
                                    <option value="thisweek"> This Week</option>
                                    <option value="nextweek"> Next Week</option>
                                    <option value="thismonth"> This Month</option>
                                    <option value="nextmonth"> Next Month</option>
                                <select>
                            </div>
                        </div>

                        <div id="item">
                            <div class="custom-select">
                                <select id="price">
                                    <option value="" selected> Any Price </option>
                                    <option value="free"> Free </option>
                                    <option value="paid"> Paid </option>
                                <select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="checkboxbox">
        <div id="checkboxloc">
            <div id="checkjudul">
                    Where You Want ?
                </div>
                <div id="row">

                <?php  
                    $param = "";
                    foreach($seminar->result_array() as $value){  
                    if($param != $value['seminar_city']){
                        $param = $value['seminar_city'];
                        $strfil1 =  str_replace(" ","-",$value['seminar_city']);
                        $strfil2 = strtolower($strfil1);
                    echo '<div id="col-25">
                    <label id="container">'.$value['seminar_city'].'
                        <input type="checkbox" id="location" name="triger" class="val_city" value="'.$strfil2.'">
                        <span id="checkmark"></span>
                    </label>
                </div>';
                }
                }
                ?>  
            </div>
        </div>
   
        <div id="checkboxcat">
            <div id="checkjudul">
                What Category You Like ?
            </div>
            <div id="row" class = "catnoderow">
               
            </div>
        </div>
    </div>

    <!-- bagian isi  -->
    <div id="body">
        <div id="postinduk">
        
        </div>

        <div id="postinduk2">
            <a id="a2"  href="javascript:void(0);" >&laquo; Back </a>
            <a id="a1"  href="javascript:void(0);" > Next &raquo; </a> 
        </div>  
    </div>  
    <!-- bagian footer  -->
    
    <div id="infofooter2">
    </div>

    <div id="footer">
        <p>Copyright © 2019 </p>
    </div>
    
    </div>

    <script type="text/javascript">

    window.onclick = function(event) {
        if ( (!event.target.matches('.schico')) && (!event.target.matches('.humbermenico')) && (!event.target.matches('.dropdown')) &&(!event.target.matches('.imgdrop')) && (!event.target.matches('.result_sem')) && (!event.target.matches('.result_loc')) && (!event.target.matches('.p')) ){
            $('#jcdrop').slideUp("fast");
            $("#result_sem").html("");
            $("#result_loc").html("");
            $('#seminar').val("");
            hidemdscr();
        }
    }

    function hidemdscr() {
        let rwidth = $(window).width();
        if(rwidth < 768){
            
            $('#dropdown-content2').slideUp("fast");//hum content
            $(".schico").css({"opacity": "1"});////icon search
            $(".result_sem").css({width: '0%',transition : '0.3s',opacity: '0'});//search barr
         
                $(".result_semcio" ).css({display : 'none'});  //icon search barr
                $( "#hideico" ).css({"display": "block"});//icon sgo
           
                 
        }
    }

     //for page
    $(function() {
 
        let arrcattext = [
                    "Otomotif",
                    "Business",
                    "Charity&nbsp;&&nbsp;Causes",
                    "Family&nbsp;&&nbsp;Education",
                    "Fashion",
                    "Film&nbsp;&&nbsp;Media",
                    "Food&nbsp;&&nbsp;Drink",
                    "Goverment",
                    "Health",
                    "Hobbies",
                    "Holiday",
                    "Home&nbsp;&&nbsp;Lifefstyle",
                    "School&nbsp;Activies",
                    "Science&nbsp;&&nbsp;Tech",
                    "Spiritually",
                    "Sport&nbsp;&&nbsp;Fitness",
                    "Travel&nbsp;&&nbsp;Outdoor"
                    ];
        let arrcatval = [
                        "otomotif",
                        "business",
                        "charity",
                        "family",
                        "fashion",
                        "film",
                        "fooddrink",
                        "goverment",
                        "health",
                        "hobbies",
                        "holiday",
                        "homelifefstyle",
                        "schoolactivies",
                        "sciencetech",
                        "spiritually",
                        "sportfitness",
                        "traveloutdoor"
              ];
              arrcattext.sort();
              arrcatval.sort();
              //console.log(arrcattext);
              arrlength = arrcattext.length - 1;
    for(let i = 0; i<= arrlength; i++){
    let fragment = document.createDocumentFragment();

    let elementdiv = document.createElement("DIV");  
    elementdiv.setAttribute("id", "col-25");
    elementdiv.classList.add('catnodecol');
    document.getElementsByClassName("catnoderow")[0].appendChild(elementdiv);
    
    let elementlabel = document.createElement("LABEL");   
    elementlabel.setAttribute("id", "container"); 
    elementlabel.classList.add('catnodecon'); 
    elementlabel.innerHTML = arrcattext[i];
    document.getElementsByClassName("catnodecol")[i].appendChild(elementlabel);

    let elementinput = document.createElement("INPUT");   
    elementinput.setAttribute("type", "checkbox");     
    elementinput.setAttribute("name", "triger");  
    elementinput.setAttribute("value", arrcatval[i]);  
    elementinput.setAttribute("id", "category");  
    elementinput.classList.add("get_cat");
    
    let elementspan = document.createElement("SPAN");
    elementspan.setAttribute("id", "checkmark"); 
    
    fragment.appendChild(elementinput);
    fragment.appendChild(elementspan); 

    document.getElementsByClassName("catnodecon")[i].appendChild(fragment);
    }
        let pager = 0;
        let status = true;
        //select tag
                var x, i, j, selElmnt, a, b, c;
        /*look for any elements with the class "custom-select":*/
        x = document.getElementsByClassName("custom-select");
        for (i = 0; i < x.length; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        a.setAttribute("id", "sell");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 0; j < selElmnt.length; j++) {
            /*for each option in the original select element,
            create a new DIV that will act as an option item:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /*when an item is clicked, update the original select box,
                and the selected item:*/
                var y, i, k, s, h;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                h = this.parentNode.previousSibling;
                for (i = 0; i < s.length; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    pager = 0;
                    status = true;
                    eval_allval(); // call funtion
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    for (k = 0; k < y.length; k++) {
                    y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /*when the select box is clicked, close any other select boxes,
            and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
            });
        }
        function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
        except the current select box:*/
        var x, y, i, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
            arrNo.push(i)
            } else {
            y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
            }
        }
        }
        /*if the user clicks anywhere outside the select box,
        then close all select boxes:*/
        document.addEventListener("click", closeAllSelect);



            //search typing
        function search_seminar(search) {
           // console.log(search);
        if(search.length<=0){
            $('#result_sem').html("");
        }
        else{
            $.ajax({
        url:"<?php echo base_url(); ?>home/search/0",
        method:"POST",
        data:{datasearch:search/*,type:result*/},
        success:function(data){
        $('#result_sem').html(data);
        //console.log(data);
                 }
              });
           
        }
            }



        //filterquery
        function fillter_query(price,date,nextpage) {
            
            var categoryfill = [];  
            var cityfill = []; 
           $('.get_cat').each(function(){  
                if($(this).is(":checked"))  
                {  
                     categoryfill.push($(this).val());  
                }  
           });  
           $('.val_city').each(function(){  
                if($(this).is(":checked"))  
                {  
                     cityfill.push($(this).val());  
                }  
           });
           categoryfill = categoryfill.toString();  
           cityfill = cityfill.toString();
            $.ajax({
            url:"<?php echo base_url(); ?>home/fillter_query/"+ nextpage,
            method:"POST",
            data:{price1:price,date1:date,varcat:categoryfill,varcity:cityfill},
            success:function(data){
            var responParse = JSON.parse(data);
            //console.log(responParse.status);
            if(responParse.status){
            $('#postinduk').html(responParse.output);
            }
            else{
            status =  responParse.status; 
            alert("Event Not Available For Now !");

            }
            
            
            }
            });
        }

        window.eval_allval = function() { 
            var price =  $("#price").val();
            var date =  $("#date").val();
            fillter_query(price,date,pager);

        }

        //ALL TRIGEER

        //checkboxcat
        let auxloc = true;
        let auxcat = true;
        let auxstsbar = false;
//icon act
        $('.humbermenico').click(function () {
            $("#dropdown-content2").slideDown(250);
        });
        $('.schico').click(function () {
            $( "#hideico" ).css({"display": "none"}); //logo
            $(this).css({"opacity": "0"}); //button small screen
            $(".result_sem" ).css({"display": "block"});//search sem bar
            $(".result_sem").css({width: '75%',transition : '0.5s',opacity:'1'});//search sem bar
            $(".result_semcio" ).css({"display": "block"});  //buttonsearch sembar

        });
        
        //act show cat loc
        $('#locact').click(function () {
            
            if(auxloc){
                    auxloc = false;
                    $(".icon").css({"border-color": "transparent transparent #135799  transparent", "top": "10px"});
                
                }   
                else{
                    if(!auxloc && !auxcat) {
                auxstsbar = cbsmarts(false);
            }
                    auxloc = true;
                    $(".icon").css({"border-color": "#135799  transparent transparent transparent", "top": "17px"});
                }
            $("#checkboxloc").slideToggle(250);

            if( !auxloc && !auxcat ){
                auxstsbar = true;
                if(auxstsbar){
                auxstsbar = cbsmarts(true);
                    }
                }
            else if(auxloc && auxcat) {
                auxstsbar = cbsmarts(false);
            }
        });
        //act show cat
        $('#catact').click(function () {
            if(auxcat){
                    auxcat = false;
                    $(".iconcat").css({"border-color": "transparent transparent #135799  transparent", "top": "10px"});
                   
                }
                else {
                    if(!auxloc && !auxcat) {
                auxstsbar = cbsmarts(false);
            }
                    auxcat = true;
                    $(".iconcat").css({"border-color": "#135799 transparent transparent transparent", "top": "17px"});
                }
            $("#checkboxcat").slideToggle(250);
            
            if( !auxloc && !auxcat ){
                auxstsbar = true;
                if(auxstsbar){
                auxstsbar = cbsmarts(true);
                    }
                }
            else if(auxloc && auxcat) {
                auxstsbar = cbsmarts(false);
            }
        });
        
        function cbsmarts(para){
        if(para === true){
            let elementdiv = document.createElement("div"); 
            elementdiv.setAttribute("id", "checkboxcon");
            document.getElementById("checkboxloc").appendChild(elementdiv);
            return false;
            }
        if(para === false){
            let cek =  document.getElementById("checkboxloc").contains(document.getElementById("checkboxcon"));
            if(cek){
            document.getElementById("checkboxcon").remove(); 
            }  
            return true;
         }
        }
        
////
        $('input[name="triger"]').click(function () {
            pager = 0;
            status = true;
            eval_allval();
        });
        //next
        $('#a1').click (function () {   
            if(status){
            pager += 6;
            eval_allval();
            }
            else{
                return false;
            }


                });
        //prev
        $('#a2').click (function () {   
            if(!status){
                status = true;
            }
            if(pager !== 0){
                pager -= 6;
                eval_allval();
            }
            else{
                alert("Wrong way, turn your steer back");
                return false;
            }
                });

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
        //seminar seacrh
        $('#seminar').on('keyup', function() {
            search_seminar($(this).val());
        });
      
        
    $(document).ready(function() {eval_allval();});}); //autoload
    
    /*function changevalloc(ele) {
        let link = ele.innerHTML;
        //setinputval
        let ta = document.getElementById("location").value = link;
        eval_allval();
    }
      $('#location').on('keyup', function() {
            var res = '#result_loc';
            pager = 0;
            status = true;
            //console.log($(this).val());
            search_seminar($(this).val(),res);
        });
           /*$('#location').keyup(function(e){
            if(e.keyCode == 8 && $(this).val().length < 1) {
                eval_allval();
            }
        });*/
  
    </script>

</body>
</html>
