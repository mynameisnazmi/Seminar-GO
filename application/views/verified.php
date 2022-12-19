<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/asset/css/verified.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/asset/css/verified_resolusi.css">
	
</head>
<body>
    <div id="wrapper">

    <div id="topr">
    </div>

    <!-- bagian navbar  -->
    <div id="top">
        <div id="navbar_kiri">
            <a href="<?php echo base_url();?>home"> Seminar Go </a>
        </div>
    </div>   

    <!-- bagian isi  -->

    <div id="body">
        <div id="bodyartikel2">
            <div id="toppost">
                <div id="objtop">
                    <center>
                    <h1> Attendance Information </h1> 
                    Your presence status is seen in the following information below
                    </center>
                </div>
            </div>

            <div id="mainright">
                <div id="objright2">
                    <center>
                    <?php   foreach($user_data->result_array() as $value){  
                        $dayname = date('l', strtotime($value['seminar_date']));
                        $daynum = date('d', strtotime($value['seminar_date']));
                        $mounth = date('F', strtotime($value['seminar_date']));
                        $year =  date('Y', strtotime($value['seminar_date']));
                    ?>
                    Thank you to <b> <?= $value['first_name'].' '.$value['last_name']; ?> </b> for attending in 
                    <h2><?= $value['seminar_name']; ?></h2>
                    on <b id="red"> <?= $dayname.', '.$daynum.' '.$mounth.' '.$year;  ?></b>
                    <?php } ?>
                    </center>
                    
                </div>
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
</body>
</html>
