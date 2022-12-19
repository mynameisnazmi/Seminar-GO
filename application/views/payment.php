<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/payment.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/payment_resolusi.css">
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
                ';
                }
                if( (!empty($user_id)) && ($user_id == 7320006)  ){
                    echo'
                 </div>
                <div id="jcdrop" class="dropdown-content">
                    <div id="jdrop" class="p2"> Welcome '.$username.' ! </div>
                    <a href="'.base_url().'profile_admin/"> Profile </a> 
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
            <a id="a" href="'.base_url().'ads">Advertising </a> 
            <a id="a" href="'.base_url().'login/">Sign in</a>
            </div>
        </div> ';
    }
    
    ?>   

    <!-- bagian isi  -->
  
    <div id="body">
        <div id="bodyartikel2">
            <div id="rightbody">
                <div id="content">
                    <div id="judul3">
                    Bill Summary
                    </div>
                    <div id="judul3">
                    <?php 
                     foreach ($seminar as $value) {
                         
                        if( empty($value['payment_id']) ){
                            echo 'Rp&nbsp;100.000,-';
                        }
                        else{
                                echo 'Rp&nbsp;'.$value['seminar_price'];
                            }
                        }

                       
                        ?>
                    </div>
                    <div id="isi">
                    Please do the transfer to the following account.
                        <div id="box">
                            <div id="flex">
                                <img src="<?= base_url(); ?>asset/pict/bank/BCA.png">
                                <div id="slot2">
                                    BCA Account
                                </div>
                            </div>
                            <div id="flex2">
                                <div id="namaacc">
                                    Alfa Farhan
                                </div>
                                <div id="noacc">
                                    41517320004 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="leftbody">
                <div id="judul">
                Payment
                </div>
                <?php 
                    foreach ($seminar as $value) {
                        //$dayname = date('l', strtotime($value['seminar_date']));
                        $daynum = date('d', strtotime($value['seminar_date']));
                        $mounth = date('F', strtotime($value['seminar_date']));
                        $year = date('Y', strtotime($value['seminar_date']));
                        $hours =  date('H', strtotime($value['seminar_date']));
                        $minute =  date('i', strtotime($value['seminar_date']));

                     echo '<div id="namaseminar">
                            '.$value['seminar_name'].' 
                        </div>
                        <div id="dateseminar">
                        '.$daynum.'&nbsp;'.$mounth.'&nbsp;'.$year.', &nbsp;'.$hours.'.'.$minute.'
                        </div>
                        <div id="locseminar">
                        '.$value['seminar_held'].'
                        </div>';
                    }
                ?>
                 <?php 
                    foreach ($seminar as $value) {
                        if( empty($value['payment_id']) ){
                            $pay_id = $value['ads_payment_id'];
                        }
                        else{
                            $pay_id = $value['payment_id'];
                        }
                        echo '<form method="post" action="'.base_url().'payment/updata/'.$pay_id.'/'.$s_id.'" enctype="multipart/form-data">';
                     }
            ?>

            <div id="rightbody2">
                <div id="content">
                    <div id="judul3">
                    Bill Summary
                    </div>
                    <div id="judul3">
                    <?php 
                     foreach ($seminar as $value) {
                         
                        if( empty($value['payment_id']) ){
                            echo 'Rp&nbsp;100.000,-';
                        }
                        else{
                                echo 'Rp&nbsp;'.$value['seminar_price'];
                            }
                        }

                       
                        ?>
                    </div>
                    <div id="isi">
                    Please do the transfer to the following account.
                        <div id="box">
                            <div id="flex">
                                <img src="<?= base_url(); ?>asset/pict/bank/BCA.png">
                                <div id="slot2">
                                    BCA Account
                                </div>
                            </div>
                            <div id="flex2">
                                <div id="namaacc">
                                    Alfa Farhan
                                </div>
                                <div id="noacc">
                                    41517320004 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div id="judul2">
                Please complete your payment data
                </div>
                <div id="postpembayaran">
                Ensure that the sender's account data matches the account you are sending. Data that you input can still be changed in the event you are following. If there are data discrepancies, we will inform you immediately.
                </div>
               
                <div id="row">
                    <div id="col-25">
                    The name of the sending bank
                    </div>
                    <div id="col-75">
                    <!--errr-->
                        <input type="text" id="bank2" name="billbank">
                    </div>
                </div>
                <div id="row">
                    <div id="col-25">
                    The sender's account name
                    </div>
                    <div id="col-75">
                        <input type="text" id="namakirim" name="billname">
                    </div>
                </div>
                <div id="row">
                    <div id="col-25">
                    Sender's account number
                    </div>
                    <div id="col-75">
                        <input type="number" id="norek" name="norek">
                    </div>
                </div>
                <div id="row">
                    <div id="col-25">
                    Proof of payment
                    </div>
                    <div id="col-75">
                        <input type="file" id="buktipem" name="buktiimg">
                    </div>
                </div>
                <div id="row">
                    <input type="submit" id="Submit" value="Submit">
                </div>
                </form>
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