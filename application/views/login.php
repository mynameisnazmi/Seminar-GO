<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../asset/css/login.css">
    <link rel="stylesheet" type="text/css" href="../asset/css/login_resolusi.css">
	
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
        <div id="bodyartikel">
            <h1> Sign in </h1>
            <div id="register">
                <form method="post" action="<?php echo base_url(); ?>signing">
                    <div id="row">
                        <input type="email" name="email" placeholder="Email" requred>
                    </div>

                    <div id="space"></div>

                    <div id="row">
                        <input type="password" name="password" placeholder="Password" requred>
                    </div>
                    
                    <div id="row">
                        <div id="left">
                            <input type="submit" name="submit" value="Sign In">
                        </div>
                        
                        <div id="col-75">
                            <p> Belum punya akun? <a href="<?php echo base_url(); ?>register"> Daftar sekarang </a>
                        </div>
                    </div>
                    <div id="confail">
                        <div id="alerts"> <?php echo $this->session->flashdata('gagal'); ?> 
                        </div>
                    </div>
                </form>
            </div>

            <br>
            <br>

            <div id="font1"> By continuing, I accept the Seminar-Go terms of service, community guidelines and have read the privacy policy. </div>

            <br>
            <br>

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
