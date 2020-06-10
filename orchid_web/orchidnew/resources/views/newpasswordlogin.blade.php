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
      //For fadeout the message in profile page
        $(document).ready(function(){ 
            $('#changepsd_status').delay(5000).fadeOut('slow'); 
        });
  </script>
</head>
<body>
    <div class="container-wrap">
	<div id="forgot_new" class="container log_content">
            <div class="content_wrap border_call">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <a href="#"><img src="img/png/orchid.png"></a>
                    </div>
                </div>
                <h4 class="set_password">Set New Password</h4>
                <div class="status">
                <!--display status-->
                    @if($status == "")
                    @endif
                    @if($status == 400)
                        <div id="changepsd_status" class="wrong-user">
                            <h5>{{$message}}</h5>
                            <?php unset($_SESSION['message']);?>
                            <?php unset($_SESSION['status_code']);?>
                        </div>
                    @endif
                 </div>
                <form action="{{'/verify-otp'}}" method="post">
                   <div class="row row_gap">
                        <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                            <input type="text" name="otp" size="35" placeholder="Enter OTP sent to your Email" autocomplete="off" autofocus="true"/>
                        </div>
                    </div>
                    <div class="row row_gap">
                        <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                            <input id="password" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" type="password" name="password" size="35" placeholder="New Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="password" onchange="
                                this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"/>
                        </div>
                    </div>
                    <div class="row row_gap">
                        <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                            <input type="submit" name="submit" id="submit" value="UPDATE"/>
                        </div>
                    </div>
                </form>
                <div class="row row_gap login_otp">
                    <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                        <a href="{{'/resend-otp'}}">Resend OTP</a>
                    </div>
                </div>
            </div>
            
            @if($status == 200)
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