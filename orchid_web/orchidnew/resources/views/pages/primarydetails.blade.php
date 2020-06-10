@extends('layout.menu')
@section('content')
@if ( ($agent->isDesktop()) || ($agent->isiPad()) || ($agent->match('Nexus 10')) )
    <div id="homeevents">

         @include('includes.profilemenu')

        <div id="content-col" class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 content-col">
                <div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-8">
                    <div class="tab-content">
                        <!--user profile-->
                        <div id="edit_primary_details">
                            @foreach($showprofile['output'] as $profile)
                            <div id="primary-content">
                                <form action="{{'/update-profile'}}" method="post" enctype="multipart/form-data">
                                    <div id="event_content" class="row justify-content-between">
                                        <div class="col-1 col-sm-1 col-md-3 col-lg-3 col-xl-3">
                                            <div class="profilecircle">
                                                <img class="profilepic profile" src="{{$profile['profile_picture']}}">
                                            </div>  
                                            <div class="p-image">
                                              <img class="upload-button" src="svg/edit-profile.svg" width="35" height="35"> 
                                              <input id="file-upload" type="file" name="profile-upload" class="file-upload" size="5" accept="image"/>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-8 col-lg-8 col-xl-8 profile_details">
                                            <div id="main" class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 write_msg">
                                                   <h6>Name</h6>
                                                </div>
                                            </div>
                                            <div id="main" class="row row_gap">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    @if($profile['first_name'] == "''")
                                                        <input class="eventcreate" type="text" name="eventnames" size="40" autocomplete="off"/>
                                                    @else
                                                        <input class="eventcreate" type="text" name="eventnames" size="40" value="{{$profile['first_name']}}" autocomplete="off"/>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="main" class="row row_gap profile_down">
                                                <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 event_calender">
                                                    <div>
                                                        @if($profile['date_of_birth'] == "''")
                                                        <input id="dob_date" class="eventcreate" name="dob" size="15" type="datetime"  placeholder="DOB" autocomplete="off"/>
                                                        @else
                                                        <input id="dob_date" class="eventcreate" name="dob" size="15" type="datetime" placeholder="DOB" value="{{  Carbon\Carbon::parse($profile['date_of_birth'])->format('d M Y')}}" autocomplete="off"/>
                                                        @endif
                                                        <span id="cal_icon" class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                                    @if($profile['phone_number'] == "''")
                                                        <input class="eventcreate" name="phonenumber" type="text" size="15" placeholder="Phone number" autocomplete="off" />
                                                    @else
                                                        <input class="eventcreate" name="phonenumber" type="text" size="15" placeholder="Phone number" value="{{$profile['phone_number']}}" autocomplete="off"/>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="main" class="row row_gap profile_down">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <input class="eventcreate" type="email" name="email" size="40" value="{{$profile['email']}}" disabled="true"/>
                                                </div>
                                            </div>
                                            <div id="main" class="row profile_psdval">
                                                <div class="col-12 offset-sm-7 col-sm-5 offset-md-7 col-md-5 offset-lg-7 col-lg-5 offset-xl-7 col-xl-5 save_profile">
                                                    <input type="submit" id="editprofile" name="saveprofile" class="saveprofile" value="Save"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endforeach
                        </div>
                        <div id="show_primary_details">
                            @foreach($showprofile['output'] as $profile)
                                <div id="primary-content">
                                    <div id="main" class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 profpdng">
                                            <h4>My Profile</h4>
                                        </div>
                                    </div>
                                    <div id="event_content" class="row justify-content-between">
                                        <div class="col-1 col-sm-1 col-md-3 col-lg-3 col-xl-3">
                                            <div class="profilecircle">
                                                <img class="profilepic profile" src="{{$profile['profile_picture']}}">
                                            </div>
                                        </div>
                                        <div class="col-1 col-sm-1 col-md-9 col-lg-9 col-xl-9 prof_details">
                                            <div id="main" class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    @if($profile['first_name'] == "''")
                                                        <h5></h5>
                                                    @else
                                                        <h5>{{$profile['first_name']}}</h5>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="main" class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    @if($profile['email'] == "''")
                                                        <h6></h6>
                                                    @else
                                                        <h6>{{$profile['email']}}</h6>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="main" class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    @if($profile['phone_number'] == "''")
                                                        <h6></h6>
                                                    @else
                                                        <h6>{{$profile['phone_number']}}</h6>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="main" class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    @if($profile['date_of_birth'] == "''")
                                                        <h6></h6>
                                                    @else
                                                        <h6>{{  Carbon\Carbon::parse($profile['date_of_birth'])->format('d M Y')}}</h6>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="main" class="row">
                                        <div class="col-12 offset-sm-7 col-sm-5 offset-md-7 col-md-5 offset-lg-7 col-lg-5 offset-xl-7 col-xl-5 edit_profile">
                                            <input type="button" class="saveprofile" value="Edit Profile" onclick="editProfile()"/>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!--display status-->
                    @if($status_code == "")
                    @endif
                    @if($status_code == 200)
                        <div id="changepsd_status" class="changepsd_status">
                            <h6>{{$message}}</h6>
                            <?php
                                unset($_SESSION['userupdate_message']);
                                unset($_SESSION['userupdate_status_code']);
                             ?>
                        </div>
                    @endif
                    @if($status_code == 400)
                        <div id="changepsd_status" class="changepsd_status">
                            <h6>{{$message}}</h6>
                            <?php
                                unset($_SESSION['userupdate_message']);
                                unset($_SESSION['userupdate_status_code']);
                             ?>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else 
    <div id="show_primary_details">
        <div class="row profile_bgrnd">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content">
                    @foreach($showprofile['output'] as $profile)
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 popcards_header">
                                <h5>My Profile</h5>
                            </div>
                        </div>
                        <div id="event_content" class="row justify-content-between">
                            <div class="col-2 col-sm-2 col-md-3 col-lg-3">
                                <div class="profilecircle">
                                    <img class="profilepic profile" src="{{$profile['profile_picture']}}">
                                </div>
                            </div>
                            <div class="col-8 col-sm-8 col-md-9 col-lg-9 prof_details">
                                <div id="main" class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        @if($profile['first_name'] == "''")
                                            <h5></h5>
                                        @else
                                            <h5>{{$profile['first_name']}}</h5>
                                        @endif
                                    </div>
                                </div>
                                <div id="main" class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        @if($profile['email'] == "''")
                                            <h6></h6>
                                        @else
                                            <h6>{{$profile['email']}}</h6>
                                        @endif
                                    </div>
                                </div>
                                <div id="main" class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        @if($profile['phone_number'] == "''")
                                            <h6></h6>
                                        @else
                                            <h6>{{$profile['phone_number']}}</h6>
                                        @endif
                                    </div>
                                </div>
                                <div id="main" class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        @if($profile['date_of_birth'] == "''")
                                            <h6></h6>
                                        @else
                                            <h6>{{  Carbon\Carbon::parse($profile['date_of_birth'])->format('d M Y')}}</h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 d-md-none d-lg-none">
                                <div class="edit-image">
                                    <img src="svg/pen.svg" width="20" height="50" onclick="editProfile()"> 
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <a class="eventschange" href="{{'/connect-social'}}">
            <div class="row dtls">
                <div class="col-2 col-sm-2 dts">
                    <img src="svg/link.svg" width="20" height="50"> 
                </div>
                <div class="col-8 col-sm-8">
                    <h5>Connect social</h5>
                </div>
                <div class="col-2 col-sm-2 dts">
                    <img src="svg/right-thin-chevron.svg" width="20" height="50"> 
                </div>
            </div>
        </a>
        <a class="eventschange" href="{{'/significant-event'}}">
            <div class="row dtls">
                <div class="col-2 col-sm-2 dts">
                    <img src="svg/management.svg" width="20" height="50"> 
                </div>
                <div class="col-8 col-sm-8">
                    <h5>Significant Events</h5>
                </div>
                <div class="col-2 col-sm-2 dts">
                    <img src="svg/right-thin-chevron.svg" width="20" height="50"> 
                </div>
            </div>
        </a>
        <a class="eventschange" href="{{'/change_password'}}">
            <div class="row popcards_header">
                <div class="col-2 col-sm-2 dts">
                    <img src="svg/unlock.svg" width="20" height="50"> 
                </div>
                <div class="col-8 col-sm-8">
                    <h5>Change Password</h5>
                </div>
                <div class="col-2 col-sm-2 dts">
                    <img src="svg/right-thin-chevron.svg" width="20" height="50"> 
                </div>
            </div>
        </a>
    </div> 
    <div id="edit_primary_details">
        <div class="row epd_length">
            <div class="col-2 col-sm-2 col-md-2 col-lg-12 profile_bgrnd">
                <button class="closebtn"  onclick="document.location.href='{{'/profile'}}';"><img src="svg/close.svg" width="20" height="50"></button>
            </div>
            <div class="col-10 col-sm-10 col-md-10 col-lg-12 profile_bgrnd">
                <h5 id="epd_length">Edit primary details</h5>
            </div>
        </div>
        @foreach($showprofile['output'] as $profile)
            <form action="{{'/update-profile'}}" method="post" enctype="multipart/form-data">
                <div id="event_content" class="row">
                    <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="prfcircle">
                            <img class="profilepic profile" src="{{$profile['profile_picture']}}">
                        </div>  
                        <div class="p-img">
                          <img class="upload-button" src="svg/edit-profile.svg" width="25" height="35"> 
                          <input id="file-upload" type="file" name="profile-upload" class="file-upload" size="5" accept="image"/>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 profile_details">
                        <div id="main" class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 prof_dtl">
                               <h6>Name</h6>
                            </div>
                        </div>
                        <div id="main" class="row row_gap">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 prof_dtl">
                                @if($profile['first_name'] == "''")
                                    <input class="eventcreate" type="text" name="eventnames" size="45" autocomplete="off"/>
                                @else
                                    <input class="eventcreate" type="text" name="eventnames" size="45" value="{{$profile['first_name']}}" autocomplete="off"/>
                                @endif
                            </div>
                        </div>
                        <div id="main" class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 prof_dtl">
                               <h6>DOB</h6>
                            </div>
                        </div>
                        <div id="main" class="row row_gap">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-5 event_calender prof_dtl">
                                <div>
                                    @if($profile['date_of_birth'] == "''")
                                    <input id="dob_date" class="eventcreate" name="dob" type="datetime" size="45"  placeholder="DOB" autocomplete="off"/>
                                    @else
                                    <input id="dob_date" class="eventcreate" name="dob" type="datetime" size="45" placeholder="DOB" value="{{  Carbon\Carbon::parse($profile['date_of_birth'])->format('d M Y')}}" autocomplete="off"/>
                                    @endif
                                    <span id="cal_icon" class="glyphicon glyphicon-calendar cal_icon3"></span>
                                </div>
                            </div>
                        </div>
                        <div id="main" class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 prof_dtl">
                               <h6>Phone Number</h6>
                            </div>
                        </div>
                        <div id="main" class="row row_gap">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-5 prof_dtl">
                                @if($profile['phone_number'] == "''")
                                    <input class="eventcreate" name="phonenumber" type="text" size="45" placeholder="Phone number" autocomplete="off" />
                                @else
                                    <input class="eventcreate" name="phonenumber" type="text" size="45" placeholder="Phone number" value="{{$profile['phone_number']}}" autocomplete="off"/>
                                @endif
                            </div>
                        </div>
                        <div id="main" class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 prof_dtl">
                               <h6>Email</h6>
                            </div>
                        </div>
                        <div id="main" class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 prof_dtl">
                                <input class="eventcreate" type="email" name="email" size="45" value="{{$profile['email']}}" disabled="true"/>
                            </div>
                        </div>
                        <div id="main" class="row">
                            <div class="col-12 col-sm-12 col-md-12 offset-lg-7 col-lg-5 profdtl">
                                <input type="submit" id="editprofile" name="saveprofile" class="saveprofile" value="Save"/>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
        @endforeach
    </div>           
@endif
@stop