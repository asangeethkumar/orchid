@extends('layout.default')
@section('content')
@foreach($addevents['output'] as $event)
<div id="creatingevent">
    <form action="#" method="post">
        <div  class="row create_event">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12  save_profile">
                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                    <span onclick="window.history.back();" style="cursor: pointer;">
                        <h4 id="createevent"> <span><img class="left_button" src="svg/left.svg"></span> Edit event</h4>
                    </span>
                </div>
                <div class="col-6 col-sm-offset-4 col-sm-2 col-md-offset-4 col-md-2 col-lg-offset-4 col-lg-2">
                    <a href="addmessagetocard">
                        <input type="submit" name="saveprofile" class="saveprofile" value="Next">
                    </a>
                </div>
            </div>
        </div>
        
        <div id="content-col" class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 create_content">
                
                <!--event details-->
                <div class="col-6 col-sm-4 col-md-4 col-lg-4 profile_details">
                    <div class="row  row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <h4 id="createevent">Event details</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                           <h5>Name of event</h5>
                        </div>
                    </div>
                    <div class="row row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <input class="eventcreate" type="text" name="eventnames" size="50" autocomplete="off" value="{{$event['event_name']}}" required="true"/>
                        </div>
                    </div>
                    <div class="row row_gap profile_down">
                        <div class="col-12 col-sm-5 col-md-5 col-lg-5 event_calender">
                            <div id="event_response" class="input-group date" data-provider="datepicker">
                                <input class="eventcreate cal_icon" name="eventdate" type="text"  placeholder="Event date" value="{{  Carbon\Carbon::parse($event['event_start_time'])->format('d-M-Y') }}" autocomplete="off" required="true"/>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5 col-md-5 col-lg-5">
                            <div id="response_event" class="input-group date" data-provider="datepicker">
                                <input class="eventcreate  cal_icon" name="responsedate" type="text" placeholder="Response by" value="{{ Carbon\Carbon::parse($event['event_response_by_time'])->format('d-M-Y') }}" autocomplete="off" required="true"/>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row_gap profile_down">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <input class="eventcreate" type="text" name="eventdescription" size="45" 
                              onKeyDown="limitText(this.form.eventdescription,this.form.countdown,200);" 
                              onKeyUp="limitText(this.form.eventdescription,this.form.countdown,200);" 
                              placeholder="Write something about event" value="{{ $event['event_description'] }}" autocomplete="off" required="true">
                            <span><input readonly class="eventcreate" id="count" type="text" name="countdown" size="1" value="0/200"></span> 
                        </div>
                    </div> 
                    <div class="row row_gap profile_down">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <select id="eventnames" class="eventcreate" name="eventtype" required="true">
                                <option value="" disabled selected>Event Occation</option>
                                @foreach($significantevents['output'] as $eventresult)
                                    <option value="{{$eventresult['event_type_id'] }}" {{ $eventresult['event_type_id']  ==  $event['event_type_id']  ? 'selected="selected"':''}}> {{ $eventresult['event_type_name'] }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <!--add people-->
                <div class="col-6 col-sm-3 col-md-3 col-lg-3 profile_details scroll_bvr">
                    <div class="row  row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <h4 id="createevent">Invite people</h4>
                        </div>
                    </div>
                    <div id="no_people" class="row row_gap">
                        <h3>It seems like you don't have people yet!</h3>
                    </div>
                    <div id="no_people" class="row row_gap">
                            <a href="#" class="addfriend-modal" data-toggle="modal" data-target="#addpeople">+ Add people</a>
                    </div>
                </div>
                
                <!--pick card-->
                <div class="col-6 col-sm-5 col-md-5 col-lg-5 profile_details scroll_bvr">
                    <div class="row  row_gap">
                        <div class="col-12 col-sm-9 col-md-9 col-md-9">
                            <h4 id="createevent">Pick a card</h4>
                        </div>
                        <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                            <a id="createevent" href="#" class="pickcards-modal" data-toggle="modal" data-target="#viewcards">View all</a>
                        </div>
                    </div>
                    @foreach($cardslist['output'] as $cards)
                        <div class="col-6 col-md-4 col-sm-4 col-lg-4">
                            <div class="card">
                                <div id="main" class="row card_img">
                                    <img id="card_img" src="{{ $cards['cards_location_url'] }}" />
                                </div>
                                <div id="main" class="row">
                                    <input id="card-btn" type="radio" name="card" value="card"> Select
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
             <!-- add people popup -->   
                <div class="modal fade" id="addpeople" role="dialog">
                    <div class="modal-dialog addfriends_dialog">
                        <div class="modal-content">
                            <div id="modal_header" class="modal-header">
                                <h4 id="modal_title" class="modal-title">Invite your Friends</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div id="modal_body" class="modal-body addfriends_body">
                                <form class="form-horizontal" role="form">
                                    <div class=" row social_media">
                                        
                                    </div>
                                    <div id="main" class="row">
                                        <div class="col-6 col-md-9 col-sm-9 col-lg-9 search_fnd">
                                            <input id="searchbtn" type="search" class="card_search" placeholder="Search name..." size="48"/>
                                            <span class="search-btn"> 
                                                <button   type="button" class="btn btn_value"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
<!--                                        <div class="col-6 col-sm-3 col-md-3 col-lg-3">
                                            <select id="all_friends" class="all_friends" name="all_friends">
                                                <option>Event Occation</option>
                                                @foreach($significantevents['output'] as $event)
                                                    <option value="{{ $event['event_type_id'] }}">{{ $event['event_type_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>-->
                                    </div>
                                    <div>
                                            List Here
                                    </div>
                                </form>
                            </div>
                            <div id="modal_footer" class="modal-footer">
                                <button type="button" class="btn btn-warning btn_warning" data-dismiss="modal">Send Invitations</button>
                            </div>
                        </div>
                    </div>
                </div>
             
                <!-- view all cards popup -->  
                <div class="modal fade" id="viewcards" role="dialog">
                    <div id="cards_dialog" class="modal-dialog cards_dialog">
                        <div id="cards_content" class="modal-content">
                            <div id="cards_header" class="modal-header">
                                <div class="row popcards_header">
                                    <div class="col-4 col-sm-3 col-md-3 col-lg-3">
                                        <button id="Searchcards_btn" type="button" class="all_cards" data-dismiss="modal"> <span><img class="left_button" src="svg/left.svg"></span>Search Cards</button>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7 col-lg-7 search_fnd">
                                        <input id="searchbtn" type="search" class="card_search" placeholder="Search name..." size="65"/>
                                        <span class="search-btn"> 
                                            <button type="button" class="btn btn_value"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                    <div class="col-4 col-sm-2 col-md-2 col-lg-2">
                                        <button type="button" class="btn btn-warning btn_warning" data-dismiss="modal">Select</button>
                                    </div>
                                </div>
                            </div>
                            <div id="modal_body" class="modal-body cards_body">
                                <form class="form-horizontal" role="form">
                                    <div class="row">
                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 filter_cards">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                    <h3>Filter</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                    <h5>CATEGORIES</h5>
                                                </div>
                                                <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                    <img src="svg/close.svg" width="8"><span> <input class="clearallbtn" type="button" onclick='UnSelectAll()' value="Clear all"/></span>
                                                </div>
                                            </div>
                                            @foreach($cardscategory['output'] as $cardscat)
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                                        <input type="checkbox" name="cardname" value="{{ $cardscat['cards_category_id'] }}">
                                                    </div>
                                                    <div class="col-10 col-sm-10 col-md-10 col-lg-10">
                                                        <h5>{{ $cardscat['cards_category_name'] }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8 show_cards">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                    <h3>Gift cards</h3>
                                                </div>
                                            </div>
                                            @foreach($cardslist['output'] as $cards)
                                                <div class="col-6 col-sm-4 col-md-4 col-lg-4">
                                                    <div class="card">
                                                        <div id="main" class="row card_img">
                                                            <img id="card_img" src="{{ $cards['cards_location_url'] }}" />
                                                        </div>
                                                        <div id="main" class="row">
                                                            <input id="card-btn" type="radio" name="card" value="card"> Select
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
        </div>
    </form>
</div>
@endforeach
@stop