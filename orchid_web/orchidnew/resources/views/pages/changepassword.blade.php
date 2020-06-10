@extends('layout.menu')
@section('content')
@if ( ($agent->isDesktop()) || ($agent->isiPad()) || ($agent->match('Nexus 10')) )
    <div id="homeevents">

        @include('includes.profilemenu')

        <div id="content-col" class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 content-col">
                <div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-8">
                    <div class="tab-content">
                         <!--change password-->
                        <div id="change_password">
                            <div id="changepsd-content">
                                <form action="{{'/change-password'}}" method="post">
                                    <div id="main" class="row row_gap profile_down psdval">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <input class="eventcreate password" type="password" name="old_password" size="50" placeholder="Old Password" required autocomplete="off" autofocus="true" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" onchange="
                                                this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
    <!--                                    <span class="forgotpsd"><a class="forgot_password" href="{{'/forget-password'}}">Forgot Password?</a></span>-->
                                        </div>
                                    </div>
                                    <div id="main" class="row row_gap profile_down psdval">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <input class="eventcreate password" type="password" name="new_password" size="50" placeholder="New Password" autocomplete="off" autofocus="true" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"  onchange="
                                                this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
                                                if(this.checkValidity()) form.confirmpassword.pattern = RegExp.escape(this.value);">
                                        </div>
                                    </div>
                                    <div id="main" class="row row_gap profile_down psdval">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <input class="eventcreate password" title="Please enter the same Password as above" type="password" name="confirm_new_Password" size="50" placeholder="Confirm Password" autocomplete="off" autofocus="true" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" onchange="
                                                this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
                                        </div>
                                    </div>
                                    <div id="main" class="row profile_psdval">
                                        <div class="col-12 offset-sm-7 col-sm-5 offset-md-7 col-md-5 offset-lg-7 col-lg-5 offset-xl-7 ncol-xl-5 save_profile">
                                            <input type="submit" name="saveprofile" class="saveprofile" value="Save Change"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--display status-->
                    @if($status_code == "")
                    @endif
                    @if($status_code == 200)
                        <div id="changepsd_status" class="changepsd_status">
                            <h6>{{$message}}</h6>
                            <?php
                                unset($_SESSION['passowrd_message']);
                                unset($_SESSION['password_status_code']);
                             ?>
                        </div>
                    @endif
                    @if($status_code == 400)
                        <div id="changepsd_status" class="changepsd_status">
                            <h6>{{$message}}</h6>
                            <?php
                                unset($_SESSION['passowrd_message']);
                                unset($_SESSION['password_status_code']);
                             ?>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else 
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 content-col">
            <div class="row epd_length">
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 profile_bgrnd">
                    <button class="closebtn"  onclick="document.location.href='{{'/profile'}}';"><img src="svg/close.svg" width="20" height="50"></button>
                </div>
                <div class="col-10 col-sm-10 col-md-10 col-lg-10 profile_bgrnd">
                    <h5 id="epd_length">Change password</h5>
                </div>
            </div>
            <!--change password-->
            <div id="change_password">
                <form action="{{'/change-password'}}" method="post">
                    <div id="main" class="row row_gap profile_down psdval">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <input class="eventcreate password" type="password" name="old_password" size="40" placeholder="Old Password" required autocomplete="off" autofocus="true" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" onchange="
                                this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
<!--                        <span class="forgotpsd"><a class="forgot_password" href="{{'/forget-password'}}">Forgot Password?</a></span>-->
                        </div>
                    </div>
                    <div id="main" class="row row_gap profile_down psdval">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <input class="eventcreate password" type="password" name="new_password" size="40" placeholder="New Password" autocomplete="off" autofocus="true" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"  onchange="
                                this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
                                if(this.checkValidity()) form.confirmpassword.pattern = RegExp.escape(this.value);">
                        </div>
                    </div>
                    <div id="main" class="row row_gap profile_down psdval">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <input class="eventcreate password" title="Please enter the same Password as above" type="password" name="confirm_new_Password" size="40" placeholder="Confirm Password" autocomplete="off" autofocus="true" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" onchange="
                                this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
                        </div>
                    </div>
                    <div id="main" class="row profile_psdval">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-offset-7 col-lg-5 pswd_save">
                            <input type="submit" name="saveprofile" class="saveprofile" value="Save Change"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif 
@stop