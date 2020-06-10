@extends('layout.menu')
@section('content')
@if ( ($agent->isDesktop()) || ($agent->isiPad()) || ($agent->match('Nexus 10')) )
    <div id="homeevents">
        @include('includes.profilemenu')

        <div id="content-col" class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 content-col">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="tab-content">
                        @if($status_code == 200)
                            <!--social connect-->
                            <div id="connect_social">
                                <div id="social-content">
                                    <div class="social_connect">
                                        @foreach($connectedSocialMedia['output'] as $connected)
                                            @if($connected['provider'] == 'FACEBOOK')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                       <img src="img/png/facebook.png" width="35" height="65">
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>Facebook</h6>
                                                    </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="svg/success.svg" width="20" height="25">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @foreach($connectedSocialMedia['output'] as $connected)
                                            @if($connected['provider'] == 'GOOGLE')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="img/png/google-plus.png" width="35" height="65">
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>Google</h6>
                                                    </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="svg/success.svg" width="20" height="25">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @foreach($connectedSocialMedia['output'] as $connected)
                                            @if($connected['provider'] == 'SLACK')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="img/png/slack.png" width="35" height="65">
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>Slack</h6>
                                                    </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="svg/success.svg" width="20" height="25">
                                                    </div>
                                                </div>
                                                <?php $i=0?>
                                            @endif
                                        @endforeach
                                        @if(isset($i))
                                        @else <?php $i=1?>
                                        @endif
                                        @if($i !=0)
                                            <div id="main" class="row row_gap">
                                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                    <img src="img/png/slack.png" width="35" height="65">
                                                </div>
                                                <a href="{{'/connect/slack/media'}}">
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>Slack</h6>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                        @foreach($connectedSocialMedia['output'] as $connected)
                                            @if($connected['provider'] == 'TWITTER')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="img/png/twitter.png" width="35" height="65">
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>Twitter</h6>
                                                    </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="svg/success.svg" width="20" height="25">
                                                    </div>
                                                </div>
                                                <?php $j=0?>
                                            @endif
                                        @endforeach
                                        @if(isset($j))
                                        @else <?php $j=1?>
                                        @endif
                                        @if($j !=0)
                                            <div id="main" class="row row_gap">
                                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                    <img src="img/png/twitter.png" width="35" height="65">
                                                </div>
                                                <a href="{{'/login/twitter'}}">
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>Twitter</h6>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                        @foreach($connectedSocialMedia['output'] as $connected)
                                            @if($connected['provider'] == 'LINKEDIN')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="img/png/linkedin.png" width="35" height="65">
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>LinkedIn</h6>
                                                    </div>
                                                   <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                       <img src="svg/success.svg" width="20" height="25">
                                                   </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @foreach($connectedSocialMedia['output'] as $connected)
                                            @if($connected['provider'] == 'WHATSAPP')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="img/png/whatsapp.png" width="35" height="65">
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>WhatsApp</h6>
                                                    </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="svg/success.svg" width="20" height="25">
                                                    </div>
                                                </div>
                                           @endif
                                        @endforeach
                                        @foreach($connectedSocialMedia['output'] as $connected)
                                            @if($connected['provider'] == 'SKYPE')
                                                <div id="main" class="row row_gap">
                                                   <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                       <img src="img/png/skype.png" width="35" height="65">
                                                   </div>
                                                   <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                       <h6>Skype</h6>
                                                   </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="svg/success.svg" width="20" height="25">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @foreach($connectedSocialMedia['output'] as $connected)
                                            @if($connected['provider'] == 'VIBER')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="img/png/viber.png" width="35" height="65">
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                        <h6>Viber</h6>
                                                    </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                        <img src="svg/success.svg" width="20" height="25">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
            <!--                        <div id="main" class="row">
                                        <div class="col-12 col-sm-offset-7 col-sm-5 col-md-offset-7 col-md-5 col-lg-offset-7 col-lg-5 save_profile">
                                            <input type="submit" name="saveprofile" class="saveprofile" value="Save"/>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        @else
                            <!--social connect-->
                            <div id="connect_social">
                                <div id="social-content">
                                    <div class="social_connect">
                                        <div id="main" class="row row_gap">
                                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                <img src="img/png/slack.png" width="35" height="65">
                                            </div>
                                            <a href="{{'/connect/slack/media'}}">
                                                <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                    <h6>Slack</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div id="main" class="row row_gap">
                                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                <img src="img/png/twitter.png" width="35" height="65">
                                            </div>
                                            <a href="{{'/login/twitter'}}">
                                                <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                    <h6>Twitter</h6>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif  
                    </div>
                    <!--display status-->
                    @if($status == "")
                    @endif
                    @if($status == 200)
                        <div id="changepsd_status" class="changepsd_status">
                            <h6>{{$socialMsg}}</h6>
                            <?php unset($_SESSION['socialmsg']);?>
                        </div>
                    @endif
                    @if($status == 400)
                        <div id="changepsd_status" class="changepsd_status">
                            <h6>{{$socialMsg}}</h6>
                            <?php unset($_SESSION['socialmsg']);?>
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
                    <h5 id="epd_length">Connected Social Media</h5>
                </div>
            </div>
            @if($status_code == 200)
                <!--social connect-->
                <div id="connect_social">
                    <div class="social_connect">
                        @foreach($connectedSocialMedia['output'] as $connected)
                            @if($connected['provider'] == 'FACEBOOK')
                                <div id="main" class="row row_gap">
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                       <img src="img/png/facebook.png" width="35" height="65">
                                    </div>
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>Facebook</h6>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="svg/success.svg" width="20" height="25">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($connectedSocialMedia['output'] as $connected)
                            @if($connected['provider'] == 'GOOGLE')
                                <div id="main" class="row row_gap">
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="img/png/google-plus.png" width="35" height="65">
                                    </div>
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>Google</h6>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="svg/success.svg" width="20" height="25">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($connectedSocialMedia['output'] as $connected)
                           @if($connected['provider'] == 'SLACK')
                                <div id="main" class="row row_gap">
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="img/png/slack.png" width="35" height="65">
                                    </div>
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>Slack</h6>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="svg/success.svg" width="20" height="25">
                                    </div>
                                </div>
                                <?php $i=0?>
                            @endif
                        @endforeach
                        @if(isset($i))
                        @else <?php $i=1?>
                        @endif
                        @if($i != 0)
                            <div id="main" class="row row_gap">
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                    <img src="img/png/slack.png" width="35" height="65">
                                </div>
                                <a href="{{'/connect/slack/media'}}">
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>Slack</h6>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @foreach($connectedSocialMedia['output'] as $connected)
                            @if($connected['provider'] == 'TWITTER')
                                <div id="main" class="row row_gap">
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="img/png/twitter.png" width="35" height="65">
                                    </div>
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>Twitter</h6>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="svg/success.svg" width="20" height="25">
                                    </div>
                                </div>
                                <?php $j=0?>
                            @endif
                        @endforeach
                        @if(isset($j))
                        @else <?php $j=1?>
                        @endif
                        @if($j !=0)
                            <div id="main" class="row row_gap">
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                    <img src="img/png/twitter.png" width="35" height="65">
                                </div>
                                <a href="{{'/login/twitter'}}">
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>Twitter</h6>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @foreach($connectedSocialMedia['output'] as $connected)
                           @if($connected['provider'] == 'LINKEDIN')
                                <div id="main" class="row row_gap">
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="img/png/linkedin.png" width="35" height="65">
                                    </div>
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>LinkedIn</h6>
                                    </div>
                                   <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                       <img src="svg/success.svg" width="20" height="25">
                                   </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($connectedSocialMedia['output'] as $connected)
                            @if($connected['provider'] == 'WHATSAPP')
                                <div id="main" class="row row_gap">
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="img/png/whatsapp.png" width="35" height="65">
                                    </div>
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>WhatsApp</h6>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="svg/success.svg" width="20" height="25">
                                    </div>
                                </div>
                           @endif
                        @endforeach
                        @foreach($connectedSocialMedia['output'] as $connected)
                            @if($connected['provider'] == 'SKYPE')
                                <div id="main" class="row row_gap">
                                   <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                       <img src="img/png/skype.png" width="35" height="65">
                                   </div>
                                   <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                       <h6>Skype</h6>
                                   </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="svg/success.svg" width="20" height="25">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($connectedSocialMedia['output'] as $connected)
                            @if($connected['provider'] == 'VIBER')
                                <div id="main" class="row row_gap">
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="img/png/viber.png" width="35" height="65">
                                    </div>
                                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                        <h6>Viber</h6>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                        <img src="svg/success.svg" width="20" height="25">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <!--social connect-->
                <div id="connect_social">
                    <div class="social_connect">
                        <div id="main" class="row row_gap">
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                <img src="img/png/slack.png" width="35" height="65">
                            </div>
                            <a href="{{'/connect/slack/media'}}">
                                <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                    <h6>Slack</h6>
                                </div>
                            </a>
                        </div>
                        <div id="main" class="row row_gap">
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                <img src="img/png/twitter.png" width="35" height="65">
                            </div>
                            <a href="{{'/login/twitter'}}">
                                <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                    <h6>Twitter</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endif 
        </div>
    </div>
@endif 
@stop