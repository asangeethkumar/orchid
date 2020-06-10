@extends('layout.menu')
@section('content')

    <!--hide editsignificant profile-->
    <script>
        function closeEvent() {
            $("#edit_significant_details").css('display','none');
            $(".addsignificant_event").css('display','block');
            <?php
               unset($_SESSION['show_signif_event']);
               unset($_SESSION['show_signf_eventid']);
            ?>
        }
    </script>

@if ( ($agent->isDesktop()) || ($agent->isiPad()) || ($agent->match('Nexus 10')) )
    <div id="homeevents">

        @include('includes.profilemenu')

        <div id="content-col" class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 content-col">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="tab-content">
                        <!--significant events-->
                        <div id="signif_event">
                            <div id="social-content">
                                <div class="social_connect">
                                    @if($listsignifevents['status_code'] == 200)
                                        @foreach($listsignifevents['output'] as $listsigfevent)
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 signf_close">
                                                <button data-id="{{$listsigfevent['s_events_id'] }}" type="button" class="close del_event" data-toggle="modal" data-target="#delete_event">&times;</button>
                                                <a href="{{'/show-significant?sei='.$listsigfevent['s_events_id']}}">
                                                    <div id="main" class="row sign_event">
                                                        <p class="event-id">{{$listsigfevent['s_events_id'] }}</p>
                                                        <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                            <img src="img/png/defaultprofile.png">  
                                                        </div>
                                                        <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9 sign_detail events">
                                                            <h6 class="sign_name">{{$listsigfevent['s_event_name'] }}({{ucfirst(strtolower($listsigfevent['relationship'])) }})</h6>
                                                            <p class="event_name">{{ucfirst(strtolower($listsigfevent['se_type_name'])) }}</p>
                                                        </div>
                                                        <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 event-date sign_date">
                                                            <h6 class="disp_date events">
                                                                <span class="post-date-day">{{ strtoupper(date('M', strtotime( Carbon\Carbon::parse($listsigfevent['se_date'])->format('M d Y')) ))}}</span>
                                                                <span class="post-date-month">{{ strtoupper(date('d', strtotime( Carbon\Carbon::parse($listsigfevent['se_date'])->format('M d Y')) ))}}</span>
                                                                <span class="post-date-year">{{ strtoupper(date('Y', strtotime( Carbon\Carbon::parse($listsigfevent['se_date'])->format('M d Y')) ))}}</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                        <!-- delete Event Popup-->
                                        <div class="modal fade" id="delete_event" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered addfriends_dialog">
                                                <div id="delete_content" class="modal-content">
                                                    <div id="modal_header" class="modal-header">
                                                        <h5 id="modal_title" class="modal-title">Delete Event</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" role="form" action="add-significant-event" method="post">
                                                            <div class="row_gap add_event">
                                                                <h5>Are you sure,  you want to delete event</h5>
                                                            </div>
                                                            <div class="row_gap delete_event">
                                                                <a id="del_val" href="{{'/delete_signf_event?dsei='}}"><button type="button" class="btn btn-warning btn_warning">Yes</button></a>
                                                            </div>
                                                            <div class="row_gap delete_event">
                                                                <button type="button" class="btn btn-warning btn_warning" data-dismiss="modal">No</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                        </div>
                                    @endif
                                </div>
                                <div id="main" class="row">
                                    <div class="col-12 offset-sm-7 col-sm-5 offset-md-7 col-md-5 offset-lg-7 col-lg-5 col-xl-5 save_profile">
                                        @if($showsignifevents != "")
                                        <input type="submit" class="saveprofile addsignificant_event" name="saveprofile" value="Add an event" style="display:none;"/>
                                        @else
                                        <input type="submit" class="significantevent-modal saveprofile addsignificant_event" data-toggle="modal" data-target="#addsignificant_event" name="saveprofile" value="Add an event"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Add Significant Event Popup-->
                            <div class="modal fade in" id="addsignificant_event" role="dialog">
                                <div class="modal-dialog modal-dialog-centered addfriends_dialog">
                                    <div id="modal_content" class="modal-content">
                                        <div id="modal_header" class="modal-header">
                                            <h5 id="modal_title" class="modal-title">Add Significant Event</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" role="form" action="add-significant-event" method="post">
                                                <div id="main" class="row">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <input type="text" name="signf_name" class="eventcreate" placeholder="Person name..." size="45" autofocus="true" autocomplete="off" required="true"/>
    <!--                                                    <input type="search" name="signf_name" class="card_search search_btn" placeholder="Search person name..." size="45"/>
                                                        <span class="search-btn"> 
                                                            <button   type="button" class="btn btn_value"><i class="fa fa-search"></i></button>
                                                        </span>-->
                                                    </div>
                                                </div>
                                                <div id="main" class="row row_gap profile_down">
                                                    <div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-5 event_calender">
                                                        <input id="dob_date" class="eventcreate" name="datesignfevent" type="datetime"  placeholder="Event date" autocomplete="off" required="true"/>
                                                        <span id="cal_icon" class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                    <div id="relation" class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                                        <select class="eventcreate" name="relation">
                                                            <option value="1">Relation</option>
                                                            @foreach($userrelation['output'] as $relation)
                                                                <option value="{{ $relation['relationship_id'] }}">{{ $relation['relationship'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="main" class="row row_gap profile_down">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <select id="eventnames" class="eventcreate" name="eventtype">
                                                            <option value="1">Event Occasion</option>
                                                            @foreach($significantevents['output'] as $event)
                                                                <option value="{{ $event['se_type_id'] }}">{{ $event['se_type_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row_gap add_event">
                                                    <input type="submit" class="saveprofile" value="Add Event">
                                                </div>
                                            </form>
                                        </div>
    <!--                                    <div id="modal_footer" class="modal-footer row_gap">
                                            <button type="button" class="btn btn-warning btn_warning" data-dismiss="modal">Add Event</button>
                                        </div>-->
                                    </div>
                                </div>
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
                                unset($_SESSION['signf_message']);
                                unset($_SESSION['signf_status_code']);
                                unset($_SESSION['update_signf_message']);
                                unset($_SESSION['update_signf_status_code']);
                                unset($_SESSION['del_signf_message']);
                                unset($_SESSION['del_signf_status_code']);
                             ?>
                        </div>
                    @endif
                    @if($status_code == 400)
                        <div id="changepsd_status" class="changepsd_status">
                            <h6>Failed to add Event</h6>
                            <?php
                                unset($_SESSION['signf_message']);
                                unset($_SESSION['signf_status_code']);
                                unset($_SESSION['update_signf_message']);
                                unset($_SESSION['update_signf_status_code']);
                                unset($_SESSION['del_signf_message']);
                                unset($_SESSION['del_signf_status_code']);
                             ?>
                        </div>
                    @endif
                </div>
                @if($showsignifevents != "")
                    <div id="edit_significant_details" class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="tab-content">
                            <!--edit significant events-->
                            <div id="social-content">
                                <div id="modal_header" class="modal-header">
                                    <h5 id="modal_title" class="modal-title">Edit Significant Event</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeEvent()">&times;</button>
                                </div>
                                <form action="{{'/update_signf_event?usei='.$showsignifevents['output']['s_events_id']}}" method="post">
                                    <div class="edit_signf">
                                        <div id="main" class="row row_gap">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 signf_name">
                                                <input type="text" name="signf_name" class="eventcreate evtwth" placeholder="Person name..." value="{{ $showsignifevents['output']['s_event_name'] }}" autocomplete="off" required="true"/>
                                            </div>
                                        </div>
                                        <div id="main" class="row row_gap profile_down">
                                            <div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-5 event_calender">
                                                <input id="dob_date" class="eventcreate wthevt" name="datesignfevent" type="datetime"  placeholder="Event date" autocomplete="off" value="{{Carbon\Carbon::parse($showsignifevents['output']['se_date'])->format('d M Y') }}" required="true"/>
                                                <span id="cal_icon" class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                            <div id="relation" class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                                <select class="eventcreate wthevt" name="relation">
                                                    <option value="{{ $showsignifevents['output']['se_relationship_id'] }}">{{ $showsignifevents['output']['relationship'] }}</option>
                                                    @foreach($userrelation['output'] as $relation)
                                                        <option value="{{ $relation['relationship_id'] }}">{{ $relation['relationship'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div id="main" class="row row_gap profile_down">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <select class="eventcreate evtwth" name="eventtype">
                                                    <option value="{{ $showsignifevents['output']['se_type_id'] }}">{{ $showsignifevents['output']['se_type_name'] }}</option>
                                                    @foreach($significantevents['output'] as $event)
                                                        <option value="{{ $event['se_type_id'] }}">{{ $event['se_type_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="main" class="row">
                                        <div class="col-12 offset-sm-7 col-sm-5 offset-md-7 col-md-5 offset-lg-7 col-lg-5 col-xl-5 save_profile">
                                            <input type="submit" class="saveprofile" name="saveprofile" value="Save"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>    
                    </div>
                @endif
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
                    <h5 id="epd_length">Significant Events</h5>
                </div>
            </div>
            <!--significant events-->
            <div id="signif_event">
                <div class="col-sm-9 col-md-9">
                    <div class="social_connect">
                        @if($listsignifevents['status_code'] == 200)
                            @foreach($listsignifevents['output'] as $listsigfevent)
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 signf_close">
                                    <button data-id="{{$listsigfevent['s_events_id'] }}" type="button" class="close del_event" data-toggle="modal" data-target="#delete_event">&times;</button>
                                    <a href="{{'/show-significant?sei='.$listsigfevent['s_events_id']}}">
                                        <div id="main" class="row sign_event">
                                            <p class="event-id">{{$listsigfevent['s_events_id'] }}</p>
                                            <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                                <img src="img/png/defaultprofile.png">  
                                            </div>
                                            <div class="col-9 col-sm-9 col-md-9 col-lg-9 sign_detail events">
                                                <h6 class="sign_name">{{$listsigfevent['s_event_name'] }}({{ucfirst(strtolower($listsigfevent['relationship'])) }})</h6>
                                                <p class="event_name">{{ucfirst(strtolower($listsigfevent['se_type_name'])) }}</p>
                                            </div>
                                            <div class="col-1 col-sm-1 col-md-1 col-lg-1 event-date sign_date">
                                                <h6 class="disp_date events">
                                                    <span class="post-date-day">{{ strtoupper(date('M', strtotime( Carbon\Carbon::parse($listsigfevent['se_date'])->format('M d Y')) ))}}</span>
                                                    <span class="post-date-month">{{ strtoupper(date('d', strtotime( Carbon\Carbon::parse($listsigfevent['se_date'])->format('M d Y')) ))}}</span>
                                                    <span class="post-date-year">{{ strtoupper(date('Y', strtotime( Carbon\Carbon::parse($listsigfevent['se_date'])->format('M d Y')) ))}}</span>
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach


                            <!-- delete Event Popup-->
                            <div class="modal fade" id="delete_event" role="dialog">
                                <div class="modal-dialog modal-dialog-centered addfriends_dialog">
                                    <div id="delete_content" class="modal-content">
                                        <div id="modal_header" class="modal-header">
                                            <h6 id="modal_title" class="modal-title">Delete Event</h6>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" role="form" action="add-significant-event" method="post">
                                                <div class="row_gap add_event">
                                                    <h5>Are you sure,  you want to delete event</h5>
                                                </div>
                                                <div class="row_gap delete_event">
                                                    <a id="del_val" href="{{'/delete_signf_event?dsei='}}"><button type="button" class="btn btn-warning btn_warning btmwth">Yes</button></a>
                                                </div>
                                                <div class="row_gap delete_event">
                                                    <button type="button" class="btn btn-warning btn_warning btmwth" data-dismiss="modal">No</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @else
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">

                            </div>
                        @endif
                    </div>
                </div>
                <div id="main" class="row">
                    <div class="col-12 offset-sm-5 col-sm-7 offset-md-5 col-md-7 offset-lg-7 col-lg-5 evnt_save">
                        @if($showsignifevents != "")
                        <input type="submit" class="saveprofile addsignificant_event" name="saveprofile" value="Add an event" style="display:none;"/>
                        @else
                        <input type="submit" class="significantevent-modal saveprofile addsignificant_event" data-toggle="modal" data-target="#addsignificant_event" name="saveprofile" value="Add an event"/>
                        @endif
                    </div>
                </div>
                <!-- Add Significant Event Popup-->
                <div class="modal fade" id="addsignificant_event" role="dialog">
                    <div class="modal-dialog modal-dialog-centered addfriends_dialog">
                        <div id="modal_content" class="modal-content">
                            <div id="modal_header" class="modal-header">
                                <h5 id="modal_title" class="modal-title">Add Significant Event</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" action="add-significant-event" method="post">
                                    <div id="main" class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <input type="text" name="signf_name" class="eventcreate" placeholder="Person name..." size="45" autofocus="true" autocomplete="off" required="true"/>
                                        </div>
                                    </div>
                                    <div id="main" class="row profile_down">
                                        <div class="col-12 col-sm-5 col-md-5 col-lg-5 event_calender">
                                            <input id="startTime" class="eventcreate" name="datesignfevent" type="datetime" size="43"  placeholder="Event date" autocomplete="off" required="true"/>
                                            <span id="cal_icon" class="glyphicon glyphicon-calendar cal_icon1"></span>
                                        </div>
                                    </div>
                                    <div id="main" class="row profile_down">
                                        <div class="col-12 col-sm-5 col-md-5 col-lg-5">
                                            <select class="eventcreate evnt" name="relation">
                                                <option value="1">Relation</option>
                                                @foreach($userrelation['output'] as $relation)
                                                    <option value="{{ $relation['relationship_id'] }}">{{ $relation['relationship'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="main" class="row profile_down">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <select class="eventcreate evnt" name="eventtype">
                                                <option value="1">Event Occasion</option>
                                                @foreach($significantevents['output'] as $event)
                                                    <option value="{{ $event['se_type_id'] }}">{{ $event['se_type_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="add_event">
                                        <input type="submit" class="saveprofile" value="Add Event">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($showsignifevents != "")
                <div id="edit_significant_details" class="col-12 col-sm-9 col-md-7 col-lg-6">
                    <!--edit significant events-->
                    <div id="changepsd-content">
                        <div id="modal_header" class="modal-header">
                            <h5 id="modal_title" class="modal-title">Edit Significant Event</h5>
                            <button type="button" class="close" data-dismiss="modal" onclick="closeEvent()">&times;</button>
                        </div>
                        <form action="{{'/update_signf_event?usei='.$showsignifevents['output']['s_events_id']}}" method="post">
                            <div class="edit_signf">
                                <div id="main" class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 signf_name">
                                        <input type="text" name="signf_name" class="eventcreate" placeholder="Person name..." size="42" value="{{ $showsignifevents['output']['s_event_name'] }}" autocomplete="off" required="true"/>
                                    </div>
                                </div>
                                <div id="main" class="row profile_down">
                                    <div class="col-12 col-sm-5 col-md-5 col-lg-5 event_calender">
                                        <input id="startTime" class="eventcreate" name="datesignfevent" type="datetime" size="42"  placeholder="Event date" autocomplete="off" value="{{Carbon\Carbon::parse($showsignifevents['output']['se_date'])->format('d M Y') }}" required="true"/>
                                        <span class="glyphicon glyphicon-calendar cal_icon1"></span>
                                    </div>
                                </div>
                                <div id="main" class="row profile_down">
                                    <div class="col-12 col-sm-5 col-md-5 col-lg-5">
                                        <select class="eventcreate evnt" name="relation">
                                            <option value="{{ $showsignifevents['output']['se_relationship_id'] }}">{{ $showsignifevents['output']['relationship'] }}</option>
                                            @foreach($userrelation['output'] as $relation)
                                                <option value="{{ $relation['relationship_id'] }}">{{ $relation['relationship'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="main" class="row profile_down">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <select class="eventcreate evnt" name="eventtype">
                                            <option value="{{ $showsignifevents['output']['se_type_id'] }}">{{ $showsignifevents['output']['se_type_name'] }}</option>
                                            @foreach($significantevents['output'] as $event)
                                                <option value="{{ $event['se_type_id'] }}">{{ $event['se_type_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="main" class="row">
                                <div class="col-12 offset-sm-3 col-sm-9 offset-md-5 col-md-7 offset-lg-7 col-lg-5 signf_save">
                                    <input type="submit" class="saveprofile" name="saveprofile" value="Save"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif 
@stop