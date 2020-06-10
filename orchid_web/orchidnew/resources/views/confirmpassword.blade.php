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
          $(document).ready(function() {
           $("#showhide").click(function() {
              if ($(this).data('val') == "1") {
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
	<div id="forgot_new"  class="container log_content">
            <div class="content_wrap border_call">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <a href="#"><img src="img/png/orchid.png"></a>
                    </div>
                </div>
                <h4 class="continue_log">Confirm Password</h4>
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
                <form action="{{'/register-user'}}" method="post">
                    <fieldset class="login_otp">
                        <div class="row row_gap">
                            <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                                <input class="email" type="email" name="email" size="35" placeholder="Enter Email" value="{{$confirm_values['email']}}"readonly="true"/>
                            </div>
                        </div>
                        <div class="row row_gap">
                            <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                                <input id="password" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" type="password" name="password" size="35" placeholder="Password" value="{{$confirm_values['password']}}" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" onchange="
                                    this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
                                    if(this.checkValidity()) form.confirmpassword.pattern = RegExp.escape(this.value);"/>
                                <span class="btn btn-default btn-md" id="showhide" data-val='1'><span id='eye' class="glyphicon glyphicon-eye-open"></span>
                                </span>
                            </div>
                        </div>
                        <div class="row row_gap">
                            <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                                <input id="password" title="Please enter the same Password as above" type="password" name="confirmpassword" size="35" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" onchange="
                                    this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
                            </div>
                        </div>
                        <div class="row row_gap">
                            <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                                <input type="checkbox" name="checkbox" value="check" id="agree" required> <a href="#">I Agree Terms and Conditions</a>
                            </div>
                        </div>
                        <div class="row row_gap">
                            <div class="col-md-7 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                                <input type="submit" name="submit" id="submit" value="LOGIN/SIGN UP"/>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            
            @if($status == 206)
                <div id="changepsd_status" class="changepsd_status">
                    <h6>{{$message}}</h6>
                    <?php unset($_SESSION['message']);?>
                    <?php unset($_SESSION['status_code']);?>
                </div>
            @endif
            
        </div>
    </div>
</body>
</html>