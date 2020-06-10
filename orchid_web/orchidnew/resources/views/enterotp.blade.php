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
                <h4 class="password_forgot">Enter OTP</h4>
                <form  action="{{'/forget-password'}}" method="post">
                    <div class=" row row_gap">
                        <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                            <input type="text" name="otp" size="35" placeholder="Enter OTP sent to your Email" autocomplete="off" autofocus="true"/>
                        </div>
                    </div>
                   <!-- <div class="row row_gap submit_otp">
                        <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                            <input type="submit" name="submit" id="submit" value="SEND OTP"/>
                        </div>
                    </div>-->
                </form>
            </div>
        </div>
    </div>
</body>
</html>
