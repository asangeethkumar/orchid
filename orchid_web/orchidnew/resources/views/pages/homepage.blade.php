@extends('layout.menu')
@section('content')
<!--for search result-->
<script>
    function showevents(){
        if(document.getElementById("search_result") != null){
            document.getElementById("search_result").innerHTML = "";
            $("#search_result").hide();
            $(".upcom-events").show();
        }
    }
    function autocomplete(inp, arr) {
        var currentFocus;
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
              if (arr[i]["event_name"].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                b = document.createElement("DIV");
                b.innerHTML = "<strong>" + arr[i]["event_name"].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i]["event_name"].substr(val.length);
                b.innerHTML += "<input type='hidden' value='" + arr[i]["event_name"] + "'>";
                b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        $(".upcom-events").hide();
                        for(j=0; j<arra.length; j++){
                            if(inp.value === arra[j]['event_name']){
                                var a = document.getElementById(arra[j]['event_id']).innerHTML;
                                document.getElementById("search_result").style.display = "block";
                                document.getElementById("search_result").innerHTML  += a;
                            }
                        }
                    closeAllLists();
                });
                a.appendChild(b);
              }
            }
        });
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) { 
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) {
                if (currentFocus > -1) {
                  if (x) x[currentFocus].click();
                }else{
                   x[0].click();
                }
            }
        });
        function addActive(x) {
            if (!x)         
                return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            for (var i = 0; i < x.length; i++) {
              x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
              if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
              }
            }
        }
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }
    var upevents = {!! json_encode($upcomingevents) !!};
    var pastevents = {!! json_encode($pastevents) !!};
    if((upevents['status_code'] == 200) || (pastevents['status_code'] == 200)){
        var arra1 = upevents['output'];
        var arra2 = pastevents['output'];
        var arra = arra1 .concat(arra2);console.log(arra);
        autocomplete(document.getElementById("searchbtn"), arra);
    }
</script>

<!--for calender of upcoming events-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.min.css" />
<script> 
    $(document).ready(function(){
        var dates = [];
        var langs = {!! json_encode($upcomingevents) !!};
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var event;
        if(langs['status_code'] == 200){
            var arr = langs['output'];
        }else{
            var arr =[];
        }
        dateValues = [];
        
        
            var date = new Date();
            var k = 0;
            if(langs['status_code'] == 200){
                for(i=0; i<arr.length;i++){
                    var dateTime = arr[i]["event_start_time"];
                    var date2 = dateTime.split(" ");
                    dates[k] = date2[0];
                    k++;
                }
            }
            $( "#datepicker1").datepicker({  
                    /* canlendar day highlight*/
                dateFormat: 'yy-mm-dd',
                todayHighlight: true, 
                beforeShowDay: function(date) {
                    var m  = date.getFullYear()+'-'+ '0' + (date.getMonth()+1)+'-'+(date.getDate());
                        if ($.inArray(m, dates) != -1) {
                            return {classes: 'highlight'};
                        }
                    return;
                }
            });
        
        $('#datepicker1').datepicker().on('changeMonth',function(e){
            //month from calender
            var currMonth = new Date(e.date).getMonth();
            for(i=0; i<arr.length;i++){
                $('#'+arr[i]['event_id']).hide();
                dateValues = arr[i]["event_start_time"];
                event = new Date(dateValues);
                //to get month
                var monthIndex = event.getMonth();
                //comparing months
                if(months[currMonth] == months[monthIndex]){
                    $("#"+arr[i]['event_id']).show();
                }
            }
        });
        $("#datepicker1").datepicker().on("changeDate", function(e) {
            $(".upcom-events").hide();
            //date from calender
            var pickdate = e.date;
            for(i=0; i<arr.length;i++){
                dateValues = arr[i]["event_start_time"];
                var eventid = arr[i]["event_id"];
                event = new Date(dateValues);
                //to convert to "Wed Feb 20 2019 00:00:00 GMT+0530 (India Standard Time)" form
                var reqdate = event.toString();
                //comparing dates
                if(reqdate == pickdate){
                    document.getElementById(eventid).style.display = "block";
                }
            }
        });
    });
</script>
<!--for calender of past events-->
<script> 
     $(document).ready(function(){
        var dates = [];
        var langs = {!! json_encode($pastevents) !!};
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var event;
        if(langs['status_code'] == 200){
            var arr = langs['output'];
        }else{
            var arr =[];
        }
        dateValues = [];
        
            var date = new Date();
            var k = 0;
            if(langs['status_code'] == 200){
                for(i=0; i<arr.length;i++){
                    var dateTime = arr[i]["event_start_time"];
                    var date2 = dateTime.split(" ");
                    dates[k] = date2[0];
                    k++;
                }
            }
            $( "#datepicker2").datepicker({  
                    /* canlendar day highlight*/
                dateFormat: 'yy-mm-dd',
                todayHighlight: true, 
                beforeShowDay: function(date) {
                    var m  = date.getFullYear()+'-'+ '0' + (date.getMonth()+1)+'-'+(date.getDate());
                        if ($.inArray(m, dates) != -1) {
                            return {classes: 'highlight'};
                        }
                    return;
                }
            });
            
            
        $('#datepicker2').datepicker().on('changeMonth',function(e){
            //month from calender
            var currMonth = new Date(e.date).getMonth();
            for(i=0; i<arr.length;i++){
                $('#'+arr[i]['event_id']).hide();
                dateValues = arr[i]["event_start_time"]; 
                event = new Date(dateValues);
                //to get month
                var monthIndex = event.getMonth();
                //comparing months
                if(months[currMonth] == months[monthIndex]){
                    $('#'+arr[i]['event_id']).show();
                }
            }
        });
        $("#datepicker2").datepicker().on("changeDate", function(e) {
            $(".upcom-events").hide();
            //date from calender
            var pickdate = e.date;
            for(i=0; i<arr.length;i++){
                dateValues = arr[i]["event_start_time"]; 
                var eventid = arr[i]["event_id"];
                event = new Date(dateValues);
                //to convert to "Wed Feb 20 2019 00:00:00 GMT+0530 (India Standard Time)" form
                var reqdate = event.toString();
                //comparing dates
                if(reqdate == pickdate){
                    document.getElementById(eventid).style.display = "block";
                }
            }
        });
    });
</script>

<div id="homeevents">
    <div  class="row home_menu">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 eventlist">
            <ul class="nav nav-tabs" id="eventtabs" onclick="showevents();">
                <li class="active activeevents"><a class="eventschange" data-toggle="tab" href="#upevents">Upcoming Events</a></li>
                <li class="activeevents"><a class="eventschange" data-toggle="tab" href="#pastevents">Past Events</a></li>
            </ul>
        </div>
    </div>
    <div id="content-col" class="row">
        <div class="tab-content">
            
            <!--upcomming events-->
            <div id="upevents" class="tab-pane fade show active">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 content-col">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-8 col-xl-6">
                        @if($upcomingevents['status_code'] == 200)
                            <div class="event_count">
                                <h6 class="upcomes">You have {{count($upcomingevents['output'])}} Upcoming events</h6>
                            </div>
                            <div class="row justify-content-between event_content">
                                <div id="search_result" style="display: none;"></div>
                                @foreach($upcomingevents['output'] as $event)
                                    <div id="{{$event['event_id'] }}" class="col-12 col-sm-6 col-md-12 col-lg-6 upcom-events">
                                        <div class="events_border">
                                            <p class="event-id">{{$event['event_id'] }}</p>
                                            <button data-uid="{{$event['event_id'] }}" type="button" class="close delevent" data-toggle="modal" data-target="#delete_event">&times;</button>
                                            <a href="{{'/view-msg?aev='.$event['event_id'].'&eur='.base64_encode($event['role_name'])}}">
                                                <div class="row upcomevents">
                                                    <div class="col-3 col-sm-3 col-md-2 col-lg-2 event-date">
                                                        <h6 class="events evntscls">
                                                            <span class="post-day">{{ strtoupper(date('M', strtotime( Carbon\Carbon::parse($event['event_start_time'])->format('M d Y')) ))}}</span>
                                                            <span class="post-month">{{ strtoupper(date('d', strtotime( Carbon\Carbon::parse($event['event_start_time'])->format('M d Y')) ))}}</span>
                                                            <span class="post-year">{{ strtoupper(date('Y', strtotime( Carbon\Carbon::parse($event['event_start_time'])->format('M d Y')) ))}}</span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-6 col-sm-6 col-md-7 col-lg-7 eventname">
                                                        <h6 id="events" class="events evntscls">{{$event['event_name'] }}</h6>
                                                    </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                                        <img class="event_pic" src="img/png/defaultprofile.png">
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="row fnds_row upcomevents">
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 event_type">
                                                    <a href="{{'/show-card?cei='.base64_encode($event['event_id']).'&cur='.base64_encode($event['role_name'])}}"><p class="events">{{$event['event_type_name'] }} CARD</p></a>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 invite_ppl">
                                                    <a class="inviteppl" href="{{'/invite-friends?ifte='.$event['event_id']}}">Invite People <span><img class="invitearrow" src="svg/arrow-pointing-to-right.svg"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        
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
                                                <h5>Are you sure you want to delete event ?</h5>
                                            </div>
                                            <div class="row_gap delete_event">
                                                <a id="delval" href="{{'/delete_event?dei='}}"><button type="button" class="btn btn-warning btn_warning">Yes</button></a>
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
                            <div class="row justify-content-between no_content">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="row row_gap no_text">
                                        <h4>It seems like you don't have Upcoming event yet!</h4>
                                    </div>
                                    <div class="row no_text">
                                        <p>Create your event(e.g. birthday, anniversary, convocation day, prize ceremony and so on..) for friends, family and invite them to attend/celebrate.</p>
                                    </div>
                                    <div class="row new_event no_text">
                                        <a href="{{'/create-events'}}"> Create an event <span><img class="createevent_arrow" src="svg/createevent_arrow.svg"></span></a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 nocontent">
                                    <img class="noevents_img" src="svg/noevent.svg">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-none d-sm-none d-md-none d-lg-none d-xl-block col-xl-3">
                    <!--display status-->
                        @if($status == "")
                        @endif
                        @if($status == 200)
                            <div id="changepsd_status" class="msg_status">
                                <h6>{{$message}}</h6>
                                <?php unset($_SESSION['message']);?>
                                <?php unset($_SESSION['status_code']);?>
                            </div>
                        @endif
                        @if($status == 400)
                            <div id="changepsd_status" class="msg_status">
                                <h6>{{$message}}</h6>
                                <?php unset($_SESSION['message']);?>
                                <?php unset($_SESSION['status_code']);?>
                            </div>
                        @endif
                    </div>
                    @if ( ($agent->isDesktop()) || ($agent->isiPad()) || ($agent->match('Nexus 10')) )
                        <div class="d-none d-sm-none d-md-block col-md-4 col-lg-4 col-xl-3 create-event">
                            <div class="home_calender clnder" id="datepicker1"></div>
                            <a href="{{'/create-events'}}">
                                <button class="event-create"><span><img class="plus_button" src="svg/add.svg"></span> Create</button>   
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!--past events-->
            <div id="pastevents" class="tab-pane fade">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 content-col">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-8 col-xl-6">
                        @if($pastevents['status_code'] == 200)
                            <div class="event_count">
                                <h6 class="upcomes">You have {{count($pastevents['output'])}} Past events</h6>
                            </div>
                            <div class="row justify-content-between event_content">
                                @foreach($pastevents['output'] as $event)
                                    <div id="{{$event['event_id'] }}" class="col-12 col-sm-6 col-md-12 col-lg-6 upcom-events">
                                        <div class="events_border">
                                            <p class="event-id">{{$event['event_id'] }}</p>
<!--                                            <button data-pid="{{$event['event_id'] }}" type="button" class="close del_past delevent" data-toggle="modal" data-target="#past_delete_event">&times;</button>-->
                                            <a href="{{'/show-card?cei='.base64_encode($event['event_id']).'&cur='.base64_encode($event['role_name'])}}">
                                                <div class="row upcomevents">
                                                    <div class="col-3 col-sm-3 col-md-2 col-lg-2 event-date">
                                                        <h6 class="events evntscls">
                                                            <span class="post-day">{{ strtoupper(date('M', strtotime( Carbon\Carbon::parse($event['event_start_time'])->format('M d Y')) ))}}</span>
                                                            <span class="post-month">{{ strtoupper(date('d', strtotime( Carbon\Carbon::parse($event['event_start_time'])->format('M d Y')) ))}}</span>
                                                            <span class="post-year">{{ strtoupper(date('Y', strtotime( Carbon\Carbon::parse($event['event_start_time'])->format('M d Y')) ))}}</span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-6 col-sm-6 col-md-7 col-lg-7 eventname">
                                                        <h6 class="events evntscls">{{$event['event_name'] }}</h6>
                                                    </div>
                                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                                        <img class="event_pic" src="img/png/defaultprofile.png">  
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="row fnds_row upcomevents">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 event_type">
                                                    <p>{{$event['event_type_name'] }}</p>
                                                </div>
        <!--                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 invite_ppl">
                                                    <a class="inviteppl" href="#">Invite People -></a>
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        
                            <!-- delete Event Popup-->
<!--                            <div class="modal fade" id="past_delete_event" role="dialog">
                                <div class="modal-dialog modal-dialog-centered addfriends_dialog">
                                    <div id="delete_content" class="modal-content">
                                        <div id="modal_header" class="modal-header">
                                            <h5 id="modal_title" class="modal-title">Delete Event</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" role="form" action="add-significant-event" method="post">
                                                <div class="row_gap add_event">
                                                    <h5>Are you sure you want to delete event ?</h5>
                                                </div>
                                                <div class="row_gap delete_event">
                                                    <a id="del_past_val" href="{{'/delete_event?dei='}}"><button type="button" class="btn btn-warning btn_warning">Yes</button></a>
                                                </div>
                                                <div class="row_gap delete_event">
                                                    <button type="button" class="btn btn-warning btn_warning" data-dismiss="modal">No</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        
                        @else
                            <div class="row justify-content-between no_content">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="row row_gap no_text">
                                        <h4>It seems like you don't have past event yet!</h4>
                                    </div>
                                    <div class="row no_text">
                                        <p>Create your event(e.g. birthday, anniversary, convocation day, prize ceremony and so on..) for friends, family and invite them to attend/celebrate.</p>
                                    </div>
                                    <div class="row new_event row_gap no_text">
                                        <a href="{{'/create-events'}}"> Create an event <span><img class="createevent_arrow" src="svg/createevent_arrow.svg"></span></a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-4 nocontent">
                                    <img class="noevents_img" src="svg/noevent.svg">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-none d-sm-none d-md-none d-lg-none d-xl-block col-xl-3"></div>
                    @if ( ($agent->isDesktop()) || ($agent->isiPad()) || ($agent->match('Nexus 10')) )
                        <div class="d-none d-sm-none d-md-block col-md-4 col-lg-4 col-xl-3 create-event">
                            <div class="home_calender clnder" id="datepicker2"></div>
                            <a href="{{'/create-events'}}">
                                <button class="event-create"><span><img class="plus_button" src="svg/add.svg"></span> Create</button>   
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
@stop