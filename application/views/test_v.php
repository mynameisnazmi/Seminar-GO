<!DOCTYPE html>  
 <html>  
 <head>
 <head>  
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/register.css">
        <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){ 
        $('input[name="triger"]').click(function () {
            var categoryfill = [];  
            var cityfill = []; 
           $('.get_val').each(function(){  
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
                url:"<?php echo base_url();?>test_c/trial",  
                method:"POST",  
                data:{varcat:categoryfill,varcity:cityfill},  
                success:function(data){  
                    //console.log(data);
                     $('#result').html(data);  
                }  
           });  
            });
          
        
 });  
        </script>
 </head>
    
      <body>  
           <br />  
           <div class="container" style="width:500px;">  
                <h3 class="text-center">Insert Checkbox values using Ajax Jquery in PHP</h3>  
                <div class="checkbox">    
                    <input type="checkbox" name="triger" class = "get_val" class="test" value="Python" /> Python <br />
                    <input type="checkbox" name="triger" class = "get_val" value="otomotif"> Auto, Boat & air <br />
                    <input type="checkbox" name="triger" class = "get_val" value="business"> Business <br />
                    <input type="checkbox" name="triger" class = "get_val" value="charity"> Charity & Causes <br />
                    <input type="checkbox" name="triger" class = "get_val" value="family"> Family & Education <br />
                    <input type="checkbox" name="triger" class = "get_val" value="fashion"> Fashion <br />
                    <input type="checkbox" name="triger" class = "get_val" value="film"> Film & Media <br />
                    <input type="checkbox" name="triger" class = "get_val" value="fooddrink"> Food & Drink <br />
                    <input type="checkbox" name="triger" class = "get_val" value="goverment"> Goverment  <br />
                    <input type="checkbox" name="triger" class = "get_val" value="health"> Health <br />
                    <input type="checkbox" name="triger" class = "get_val" value="hobbies"> Hobbies <br />
                    <input type="checkbox" name="triger" class = "get_val" value="holiday"> Holiday <br />
                    <input type="checkbox" name="triger" class = "get_val" value="homelifefstyle"> Home & Lifefstyle <br />
                    <input type="checkbox" name="triger" class = "get_val" value="schoolactivies"> School Activies <br />
                    <input type="checkbox" name="triger" class = "get_val" value="sciencetech"> Science & Tech <br />
                    <input type="checkbox" name="triger" class = "get_val" value="spiritually"> Spiritually <br />
                    <input type="checkbox" name="triger" class = "get_val" value="sportfitness"> Sport & Fitness <br />
                    <input type="checkbox" name="triger" class = "get_val" value="traveloutdoor"> Travel & Outdoor <br />                      
                </div>         
                <div id="result"></div>  
           </div>  
           <br />  
           <div class="container" style="width:500px;">  
                <h3 class="text-center">TEST ANOTHER</h3>  
                
                <div class="checkbox">  
                <?php  
                 $param = "";
                foreach($seminar->result_array() as $value){  
                if($param != $value['seminar_city']){
                    $param = $value['seminar_city'];
                    $strfil1 =  str_replace(" ","-",$value['seminar_city']);
                    $strfil2 = strtolower($strfil1);
               echo '<input type="checkbox" name="triger" class = "val_city" value="'.$strfil2.'" />'.$value['seminar_city'].'<br />                    
               ';
               }
             }
             
             
             ?>  
                     </div>
           </div>  
      </body>  
 </html>  
