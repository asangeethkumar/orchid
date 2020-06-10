<!DOCTYPE html>
<html lang="en">
<head>
  <title> OrchidUs </title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">  
  <link href="css/main.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
        $(document).ready(function(){
         $("#showhide").click(function(){
            if ($(this).data('val') == "1"){
               $("#password").prop('type','text');
               $("#eye").attr("class","glyphicon glyphicon-eye-close");
               $(this).data('val','0');
            }
            else{
               $("#password").prop('type', 'password');
               $("#eye").attr("class","glyphicon glyphicon-eye-open");
               $(this).data('val','1');
            }
         });
      })
      //For fadeout the message in profile page
        $(document).ready(function(){ 
            $('#changepsd_status').delay(5000).fadeOut('slow'); 
        });
  </script>
</head>
<body>
    <div class="container-wrap">
	<div class="container log_content">
            <div class="content_wrap border_call">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="#"><img src="img/png/orchid.png"></a>
                    </div>
                </div>
                <h4 class="login">Login With</h4>
                <div class=" row social_media">
                    <div class="mediadiv">
                        <div class="icons">
                            <a href="{{'/login/facebook'}}"><img src="img/png/facebook.png" width="65" height="65"></a>
                        </div>
                        <div class="icons">
                            <a href="{{'/login/google'}}" ><img src="img/png/google-plus.png" width="65" height="65"></a>
                        </div>
                        <div class="icons">
                            <a href="{{'/login/instagram'}}"><img src="img/png/instagram.png" width="65" height="65"></a>
                        </div>
                        <div class="icons">
                            <a href="{{'/login/linkedin'}}"><img src="img/png/linkedin.png" width="65" height="65"></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mediadiv">
                        <div class="icons">
                            <a href="{{'/slack'}}"><img src="img/png/slack.png" width="65" height="65"></a>
                        </div>
                        <div class="icons">
                            <a href="{{'/login/twitter'}}"><img src="img/png/twitter.png" width="65" height="65"></a>
                        </div>
                        <div class="icons">
                            <a href="#"><img src="img/png/snapchat.png" width="65" height="65"></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="activity_private">All your activity will remain private.</p>
                    </div>
                </div>
                <h4 class="continue_log login">or Continue With</h4>
                <form action="{{'/login-register'}}" method="post"><fieldset>
                   <div class="row row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <input class="email sizval" type="email" name="email" placeholder="Enter Email" autofocus="true"/>
                        </div>
                    </div>
                    <div class="row row_gap">
                        <div class="col-8 col-offset-1 col-sm-10 col-sm-offset-1  col-md-7 col-md-offset-2  col-lg-7 col-lg-offset-2">
<!--                            <input id="password" type="password" name="password" size="35" placeholder="Password">-->
                            <input id="password" class="sizval" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" type="password" name="password" placeholder="Password" required name="password" onchange="
                                this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
                                if(this.checkValidity()) form.confirmpassword.pattern = RegExp.escape(this.value);">
                                 <span class="btn btn-default btn-md" id="showhide" data-val='1'><span id='eye' class="glyphicon glyphicon-eye-open"></span>
                              </span>
                        </div>
                    </div>
                    <div class="row row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <input type="submit" name="submit" id="submit" value="LOGIN/SIGN UP"/>
                        </div>
                    </div>
                    <div class="row row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <a class="forgot_password" href="{{'/forget-password'}}">forgot password?</a>
                        </div>
                    </div></fieldset>
                </form>
            </div>
            
            <!--display status-->
            @if($status == "")
            @endif
            @if($status == 200)
                <div id="changepsd_status" class="changepsd_status">
                    <h5>{{$message}}</h5>
                    <?php unset($_SESSION['message']);?>
                    <?php unset($_SESSION['status_code']);?>
                </div>
            @endif
            @if($status == 400)
                <div id="changepsd_status" class="changepsd_status">
                    <h5>{{$message}}</h5>
                    <?php unset($_SESSION['message']);?>
                    <?php unset($_SESSION['status_code']);?>
                </div>
            @endif
            @if($status == 401)
                <div id="changepsd_status" class="changepsd_status">
                    <h5>{{$message}}</h5>
                    <?php unset($_SESSION['message']);?>
                    <?php unset($_SESSION['status_code']);?>
                </div>
            @endif
            
        </div>
    </div>
</body>
</html>