@extends('layout.default')
@section('content')
<div id="addmsg">
    <div class="row create_event">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12  save_profile">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                <span onclick="window.history.back();" style="cursor: pointer;">
                    <h4 id="createevent"> <span><img class="left_button" src="svg/left.svg"></span> Add Message to card</h4>
                </span>
            </div>
            <form action="{{'/select-card'}}" method="post">
            <div class="col-6 col-sm-6 col-md-offset-4 col-md-2 col-lg-offset-4 col-lg-2">
                    <input type="submit" name="saveprofile" id="save_profile" class="saveprofile" value="Save">
            </div>
        </div>
    </div>
    
    <div id="content-col" class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 create_content">
                <div class="col-5 col-sm-5 col-md-5 col-lg-5 recp-cls">
                    <div class="recipent">
                        <div id="main" class="row fst_div">
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">
                                <h4 class="number">1</h4>
                            </div>
                            <div class="col-11 col-sm-11 col-md-11 col-lg-11">
                                <h4 class="heading1">Recipient</h4>
                            </div>
                        </div>
                        <div id="main" class="row dateselect">
                            <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                <p>Whom to send</p>
                            </div>
                            <div id="send_bfr" class="col-4 col-sm-4 col-md-4 col-lg-4">
                                <p>Send before</p>
                            </div>
                        </div>
                        <div id="main" class="row">
                            <div class="col-8 col-sm-8 col-md-8 col-lg-8 datesel_val">
                                    <input class="eventcreate" type="email" name="recipent_mail" size="35" placeholder="Recipent email" autocomplete="off" autofocus="true" required="true"/>
        <!--                            <input id="searchbtn" type="search" class="card_search" placeholder="Search name..." size="35"/>
                                    <span class="search-btn"> 
                                        <button type="button" class="btn btn_value"><i class="fa fa-search"></i></button>
                                    </span>-->
                            </div>
                            <div id="datesel" class="col-4 col-sm-4 col-md-4 col-lg-4 datesel_val">
                                    <input class="eventcreate" name="sendby" type="datetime" id="send_on" size="12" placeholder="Send by" autocomplete="off" required="true"/>
                            </div>
                        </div>
                    </div>
                    <div id="recipent">
                        <div id="main" class="row fst_div">
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">
                                <h4 class="number">2</h4>
                            </div>
                            <div class="col-9 col-sm-9 col-md-9 col-lg-9">
                                <h4 class="heading1">Write message</h4>
                            </div>
    <!--                        <div class="col-2 col-sm-2 col-md-2 col-lg-2 add_btn">
                                <a  href="#"><span class="gap"><img height="25" width="18" src="svg/add_social_media.svg"></span>Add new</a>
                            </div>-->
                        </div>
                        <div class="addmsg">
                            <div id="main" class="row">
                                <div class="col-9 col-sm-9 col-md-9 col-lg-9 write_msg">
                                        <textarea class="eventcreate" name="addmessage" cols="60" placeholder="Add message" required="true"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-3 col-sm-3 col-md-3 col-lg-3 card_msg">
                    <div class="row card_details">
                        @foreach($addevents['output'] as $event)
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 recvr_detls">
                                <h4 class="lett_bold">{{$event['event_name']}}</h4>
                                <h5 class="birth_day">{{  Carbon\Carbon::parse($event['event_start_time'])->format('d M') }}</h5>
                                <p>{{$event['event_type_name']}}</p>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                @foreach($showprofile['output'] as $profile)
                                    <h4 class="lett_bold">Created by</h4>
                                    @if(($profile['first_name'] == "''") || ($profile['first_name'] == null))
                                        <p>{{$profile['email']}}</p>
                                    @else
                                        <p>{{$profile['first_name']}}</p>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-3 col-sm-3 col-md-3 col-lg-3 card_msg">
                  
                    @if($_SESSION['card_id'] != "")
                        <div class="selected_card">
                            <input class="card_id" name="card_id" value="{{$_SESSION['card_id']}}" style="display: none;">
                            <img class="selec_card" src="{{$_SESSION['card_url']}}" />
                        </div>
                    @else
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 card_disp">
                            <h5 class="nocard">You have not selected the card</h5>
                            <a id="createevent" href="#" class="pickcards-modal nocard" data-toggle="modal" data-target="#selectcards">Select a card</a>
                            <div class="selected_card">
                                <input class="card_id" name="card_id" style="display: none;">
                                <img class="selec_card">
                            </div>
                        </div>

                        <!-- view all cards popup -->  
                        <div class="modal fade" id="selectcards" role="dialog">
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
                                                <button type="button" id="selectedcard" class="btn btn-warning btn_warning" data-dismiss="modal">Select</button>
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
                                                                    <input id="card-btn" type="radio" name="card" value="{{ $cards['cards_id'] }}&&{{ $cards['cards_location_url'] }}" required="true"> Select
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

                    @endif
                </div>
            </form>
            
        </div>
    </div>
</div>
@stop