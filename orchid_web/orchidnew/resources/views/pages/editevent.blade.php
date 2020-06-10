@extends('layout.default')
@section('content')
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39365077-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
<link rel="stylesheet" href="css/signature-pad.css">

<script> 
    $(document).ready(function () {
        var allcards = {!! json_encode($cardslist['output']) !!};
        $("select.eventcreate").change(function(){
            $('.event_cls').hide();
            var selectedevent = $(this).children("option:selected").val();
            for(i=0; i<allcards.length; i++){
                if(allcards[i]['cards_category_id'] == selectedevent){
                    var idd = allcards[i]['cards_category_id'];
                    $('.'+idd).css('display',"block");
                    $('.13').css('display',"block");
                }else{
                    $('.13').css('display',"block");
                }
            }
        });
    });
</script>

<script>
    var x, i,check;
    x = document.getElementsByClassName("eventcls");
    $(document).ready(function () {
        $(".pickcards-modal").click(function () {
            filterSelection(0);
            var selected_card = document.querySelector('input[name = "cards"]:checked');
            if(selected_card != null){      
                var sel_card = $(selected_card).val();
                $('input[class = "poper"]').each(function(){
                    if($(this).val()== sel_card){
                        $(this).attr("checked",true)
                    }
                }); 
            }
        });
        $(".all_cards").click(function () {
            UnSelectAll();
            var selected_card = document.querySelector('input[class = "poper"]:checked');
            if(selected_card != null){      
                var sel_card = $(selected_card).val();
                $('input[class = "cards"]').each(function(){
                    if($(this).val()== sel_card){
                        $(this).attr("checked",true)
                    }
                }); 
            }
        });
        $("input:checkbox.check_box").change(function() {
            var assignedTo = $('input:checkbox.check_box:checked').map(function(){
                return $(this).attr('value');
            }).get();
            if(assignedTo == ""){
                filterSelection(0);
            }else{
                for (i = 0; i < x.length; i++) {
                    w3RemoveClass(x[i], "show");
                    var d = x[i].className.split(" ")[6];
                    if($.inArray(d,assignedTo)!= -1){
                     w3AddClass(x[i], "show");
                    }else{
                        w3RemoveClass(x[i], "show");
                    }
                }
            }
        });
        $(".clearall").click(function () {
                filterSelection(0);
        });
    });

    function filterSelection(c) {
        if (c == 0) c = "";
        for (i = 0; i < x.length; i++) {
            if(c == " "){
                w3RemoveClass(x[i], "show");
            }
            if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
        }
    }

    function w3AddClass(element, name) {
      var j, arr1, arr2;
      arr1 = element.className.split(" ");
      arr2 = name.split(" ");
        for (j = 0; j < arr2.length; j++) {
            if (arr1.indexOf(arr2[j]) == -1) element.className += " " + arr2[j];
        }
    }

    function w3RemoveClass(element, name) {
      var k, arr1, arr2;
      arr1 = element.className.split(" ");
      arr2 = name.split(" ");
        for (k = 0; k < arr2.length; k++) {
            if(arr1[6] != 13){
                while (arr1.indexOf(arr2[k]) > -1) {
                  arr1.splice(arr1.indexOf(arr2[k]), 1);     
                }
            }
        }
      element.className = arr1.join(" ");
    }

</script>


<div id="creatingevent">
    <form action="{{'/update-event'}}" method="post" enctype="multipart/form-data">
        
        <div  class="row create_event">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12  save_profile">
                <div class="col-9 col-sm-9 col-md-6 col-lg-6 col-xl-6">
                    <span onclick="window.history.back();" style="cursor: pointer;">
                        <h4 id="createevent"> <span><img class="left_button" src="svg/left.svg"></span> Edit an event</h4>
                    </span>
                </div>
                <div class="d-none d-sm-none d-md-block offset-md-3 col-md-3 offset-lg-4 col-lg-2 offset-xl-4  col-xl-2">
                    <input id="saveevent" type="submit" name="saveprofile" class="saveprofile" value="Save">
                </div>
                <div class="col-3 col-sm-3 d-md-none d-lg-none d-xl-none">
                    <button type="button" class="close" onclick="document.location.href='{{'/up-events'}}';">&times;</button>
                </div>
            </div>
        </div>
        
        <div id="content-col" class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 create_content mediadiv">
                
                @foreach($addevents['output'] as $event)
                <!--event details-->
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 profile_details">
                    <div class="row  row_gap">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <h4 id="createevent">Event details</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                           <h6>Name of event</h6>
                        </div>
                    </div>
                    <div class="row row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <input class="eventcreate nameevent" type="text" name="eventnames" value="{{$event['event_name']}}" required="true"/>
                        </div>
                    </div>
                    <div class="row row_gap profile_down">
                        <div class="col-6 col-sm-5 col-md-5 col-lg-5 col-xl-5 event_calender">
                            <input id="startTime" class="eventcreate" name="eventdate" type="datetime"  placeholder="Event date" value="{{  Carbon\Carbon::parse($event['event_start_time'])->format('d M Y') }}" required="true"/>
                                <span id="cal_icon" class="fa fa-calendar"></span>
                        </div>
                        <div class="col-6 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                            <input id="endTime" class="eventcreate" name="responsedate" type="datetime" placeholder="Response by" value="{{  Carbon\Carbon::parse($event['event_response_by_time'])->format('d M Y') }}" required="true"/>
                                <span id="cal_icon" class="fa fa-calendar"></span>
                        </div>
                    </div>
                    <div class="row row_gap profile_down">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <input class="eventcreate nameevent" type="text" name="eventdescription" 
                              placeholder="Write something about event" value="{{$event['event_description']}}" required="true"> 
                        </div>
                    </div> 
                    <div class="row row_gap profile_down">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <select id="eventnames" class="eventcreate" name="eventtype" required="true">
                                <option value="{{$event['event_type_id']}}" selected>{{$event['event_type_name']}}</option>
                                @foreach($significantevents['output'] as $event)
                                    <option value="{{ $event['event_type_id'] }}">{{ $event['event_type_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                
                <!--add recipient-->
                <div class="col-12 col-sm-12 offset-md-1 col-md-5 offset-lg-0 col-lg-3 offset-xl-0 col-xl-3 profile_details ">
                    <div class="row  row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <h4 id="createevent">Recipient</h4>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                           <h6>Whom to send</h6>
                        </div>
                    </div>
                    @if($selectedcard['status_code'] == 200)
                        <div class="row row_gap">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <input id="receiver" class="eventcreate receiver" type="email" name="recipent_mail" value="{{$selectedcard['card_data']['recipient_email'] }}" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 writemsg">
                                @foreach($selectedcard['user_messages'] as $message)
                                    @if($message['message'] == "")
                                        <textarea class="eventcreate receiver" name="addmessage" placeholder="Add message"></textarea>
                                    @else
                                        @if($_COOKIE['orchid_unumber'] == $message['user_id'])
                                            <?php $mymsg = $message['message'] ?>
                                            <?php $i = 0; ?>
                                        @else
                                            <?php $i = 1; ?>
                                        @endif
                                    @endif
                                @endforeach
                                @if(empty($mymsg))
                                <textarea class="eventcreate receiver" name="addmessage" cols="36" rows="1" placeholder="Add message"></textarea>
                                @else
                                <textarea class="eventcreate receiver" name="addmessage" cols="36" rows="1" placeholder="Add message" ><?php echo $mymsg?> </textarea>
                                @endif
                            </div>
                        </div>
                        @foreach($selectedcard['user_messages'] as $message)
                            @if($_COOKIE['orchid_unumber'] == $message['user_id'])
                                <div id="main" class="row row_gap">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        @if(isset($message['file_name']))
                                            @if ((pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'JPG') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'jpg') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'PNG') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'png') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'gif'))
                                                <div id="main" class="row row_gap">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 img_align">
                                                        <img data-imgid="{{$message['file_location']}}" src="{{$message['file_location']}}"  class="viewimg row_gap" data-toggle="modal" data-target="#viewimg" width="80px" height="80px"/>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 img_align">
                                                        <img data-imgid="{{$message['scrible_image']}}" src="{{$message['scrible_image']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="150px" height="80px"/>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'mp3')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 img_align">
                                                        <audio style="width : 250px !important" controls class="row_gap">
                                                            <source src="{{$message['file_location']}}" type="audio/mpeg">
                                                        </audio>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 img_align">
                                                        <img data-imgid="{{$message['scrible_image']}}" src="{{$message['scrible_image']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="150px" height="80px"/>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'mp4')
                                                <div id="main" class="row row_gap">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 img_align">
                                                        <video width="250px" controls class="row_gap">
                                                            <source src="{{$message['file_location']}}" type="video/mp4">
                                                        </video>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 img_align">
                                                        <img data-imgid="{{$message['scrible_image']}}" src="{{$message['scrible_image']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="150px" height="80px"/>
                                                    </div>
                                                </div>
                                            @endif
                                            <!--View Full image-->
                                            <div class="modal fade" id="viewimg" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered addfriends_dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <img id="enlarge" src="" width="450px" height="100px"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="row row_gap recvr_detls">
                            <div class="col-2 col-sm-2 col-md-2 col-lg-12 col-xl-2 write">
                                <button id="signature_data" class="sign_write" type="button" data-toggle="modal" onclick="pop();">Write</button>
                            </div>
                            <div class="col-10 col-sm-10 col-md-10 col-lg-12 col-xl-10">
                                <div class="input-group fudiv">
                                    <span class="input-group-btn">
                                      <span class="btn btn-primary file_btn" onclick="$(this).parent().find('input[type=file]').click();">Browse</span>
                                      <input class="msg_file" name="file-upload" accept="image" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                    </span>
                                    <span class="form-control file_span"></span>
                                </div>
                                <script>
                                    //fileupload size
                                    $(".msg_file").on("change", function () {
                                        if(this.files[0].size > 10000000) {
                                            alert("Please upload file less than 10MB. Thanks!!");
                                            $(this).val('');
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    @else
                        <div class="row row_gap">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <input id="receiver" class="eventcreate receiver" type="email" name="recipent_mail"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 writemsg">
                                <textarea class="eventcreate receiver" name="addmessage" cols="36" rows="1" placeholder="Write message to your friend"></textarea>
                            </div>
                        </div>
                        <div class="row row_gap recvr_detls">
                            <div class="col-2 col-sm-2 col-md-2 col-lg-12 col-xl-2 write">
                                 <button id="signature_data" class="sign_write" type="button" data-toggle="modal" onclick="pop();">Write</button>
                            </div>
                            <div class="col-10 col-sm-10 col-md-10 col-lg-12 col-xl-10">
                                <div class="input-group fudiv">
                                    <span class="input-group-btn">
                                      <span class="btn btn-primary file_btn" onclick="$(this).parent().find('input[type=file]').click();">Browse</span>
                                      <input class="msg_file" name="file-upload" accept="image" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                    </span>
                                    <span class="form-control file_span"></span>
                                </div>
                                <script>
                                    //fileupload size
                                    $(".msg_file").on("change", function () {
                                        if(this.files[0].size > 10000000) {
                                            alert("Please upload file less than 10MB. Thanks!!");
                                            $(this).val('');
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    @endif
                </div>
                <!--pick card-->
                <div id="profile_details" class="col-12 col-sm-12 col-md-11 col-lg-5 col-xl-5 profile_details pickcard">
                    <div class="row  row_gap">
                        <div class="col-6 col-sm-6 col-md-9 col-md-9 col-xl-9">
                            <h4 id="createevent">Pick a card</h4>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                            <a id="createevent" href="#" class="pickcards-modal viewall" data-toggle="modal" data-target="#viewcards">View all</a>
                        </div>
                    </div>
                    <div class="row scroll_bvr">
                    @if($selectedcard['status_code'] == 200)
                    @foreach($cardslist['output'] as $cards)
                        <div class="col-6 col-md-4 col-sm-4 col-lg-4 col-xl-4 event_cls {{ $cards['cards_category_id'] }}">
                            <label class="card">
                                <div id="main" class="row card_img">
                                    <img id="card_img" src="{{ $cards['cards_location_url'] }}" />
                                </div>
                                <div id="main" class="row">
                                    @if($cards['cards_id'] == $selectedcard['card_data']['cards_id'])
                                        <input id="card-btn" class="cards" type="radio" name="cards" value="{{$selectedcard['card_data']['cards_id'] }}&&{{$selectedcard['card_data']['cards_location_url'] }}" checked="true"> Select
                                    @else
                                        <input id="card-btn" class="cards" type="radio" name="cards" value="{{$cards['cards_id']}}&&{{ $cards['cards_location_url'] }}"> Select
                                    @endif
                                </div>
                            </label>
                        </div>
                    @endforeach
                    @else
                        @foreach($cardslist['output'] as $cards)
                            <div class="col-6 col-md-4 col-sm-4 col-lg-4">
                                <label class="card">
                                    <div id="main" class="row card_img">
                                        <img id="card_img" src="{{ $cards['cards_location_url'] }}" />
                                    </div>
                                    <div id="main" class="row">
                                        <input id="card-btn" class="cards" type="radio" name="cards" value="{{$cards['cards_id']}}&&{{ $cards['cards_location_url'] }}"> Select
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    @endif  
                    </div>
                </div>
                
             
                <!-- view all cards popup -->  
                <div class="modal fade" id="viewcards" role="dialog">
                    <div id="cards_dialog" class="modal-dialog cards_dialog">
                        <div id="cards_content" class="modal-content">
                            <div id="cards_header" class="modal-header">
                                <div class="row popcards_header">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mediadiv inlneblk">
                                        <div class="col-6 col-sm-5 col-md-5 col-lg-4 col-xl-4">
                                            <button id="Searchcards_btn" type="button" class="all_cards" data-dismiss="modal"> <span><img class="left_button" src="svg/left.svg"></span>Search Cards</button>
                                        </div>
    <!--                                    <div class="col-6 col-sm-7 col-md-7 col-lg-7 search_fnd">
                                            <input id="searchbtn" type="search" class="card_search" placeholder="Search name..." size="65"/>
                                            <span class="search-btn"> 
                                                <button type="button" class="btn btn_value"><img class="searchicon" src="svg/searchicon.svg"></button>
                                            </span>
                                        </div>-->
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                            <div class="input-group fudiv">
                                                <span class="input-group-btn">
                                                  <span class="btn btn-primary file_btn" onclick="$(this).parent().find('input[type=file]').click();">Browse</span>
                                                  <input  id="upload_card" class="msg_file" name="upload-card" accept="image" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                                </span>
                                                <span class="form-control file_span"></span>
                                            </div>
                                            <button type="button" id="card_upload" class="msgsave">Save</button>
                                            <script>
                                                //fileupload size
                                                $(".msg_file").on("change", function () {
                                                    if(this.files[0].size > 10000000) {
                                                        alert("Please upload file less than 10MB. Thanks!!");
                                                        $(this).val('');
                                                    }
                                                });
                                                //call controller
                                                $("#card_upload").on("click",function(e){
                                                    e.preventDefault();
                                                    var formData = new FormData();
                                                    formData.append('fileName', $('#upload_card')[0].files[0]);
                                                    $.ajax({
                                                        type: 'POST',
                                                        enctype: 'multipart/form-data',
                                                        url: '/upload-card',
                                                        contentType: false,
                                                        processData: false,
                                                        data: formData,
                                                        cache: false,
                                                        success: function(result) {
                                                            if(result == 200){
                                                                $("#profile_details").load(" #profile_details > *");
                                                                $("#viewcards").load(" #viewcards > *", function(){
                                                                    $('.eventcls').addClass('show');
                                                                });
                                                            }
                                                        }
                                                      });
                                                });
                                            </script>
                                        </div>
                                        <div class="d-none d-sm-none d-md-none d-lg-block col-lg-5 col-xl-5">
                                            <button type="button" class="btn btn-warning btn_warning all_cards" data-dismiss="modal">Select</button>
                                        </div>
                                        <div class="col-1 col-sm-1 col-md-1 d-lg-none d-xl-none">
                                            <button type="button" class="all_cards" data-dismiss="modal"><img class="left_button" src="svg/check-mark.svg"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="modal_body" class="modal-body cards_body">
                                <form class="form-horizontal" role="form">
                                    <div class="row">
                                        <div class="col-6 col-sm-5 col-md-4 col-lg-4 col-xl-4 filter_cards">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pdng">
                                                    <h4>Filter</h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 pdng_top">
                                                    <h5>CATEGORIES</h5>
                                                </div>
                                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 clearall">
                                                    <img src="svg/close.svg" width="8"><span> <input class="clearallbtn" type="button" onclick='UnSelectAll()' value="Clear all"/></span>
                                                </div>
                                            </div>
                                            @foreach($cardscategory['output'] as $cardscat)
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 divmedia">
                                                    <label class="filter">
                                                        <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                            <input class="check_box" type="checkbox" name="cardname" value="{{ $cardscat['cards_category_id'] }}">
                                                        </div>
                                                        <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                                                            <h6>{{ $cardscat['cards_category_name'] }}</h6>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="col-6 col-sm-7 col-md-8 col-lg-8 col-xl-8 show_cards">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pdng">
                                                    <h4>Gift cards</h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach($cardslist['output'] as $cards)
                                                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 eventcls {{ $cards['cards_category_id'] }}">
                                                        <label class="card">
                                                            <div id="main" class="row card_img">
                                                                <img id="card_img" src="{{ $cards['cards_location_url'] }}" />
                                                            </div>
                                                            <div id="main" class="row">
                                                                <input id="card-btn" class="poper" type="radio" name="card" value="{{ $cards['cards_id'] }}&&{{ $cards['cards_location_url'] }}"> Select
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <!-- write message Popup-->
                <div class="modal" id="write-msg" role="dialog">
                    <div id="signature-pad" class="signature-pad">
                        <div class="signature-pad--header">
                            <button type="button" class="btn" data-dismiss="modal" style="float: right;">&times;</button>
                        </div>
                      <div class="signature-pad--body">
                        <canvas id="canvas" width="200" height="200" ></canvas>
                      </div>
                      <div class="signature-pad--footer">
                        <div class="description">Sign above</div>

                        <div class="signature-pad--actions">
                          <div>
                            <button type="button" class="button clear" data-action="clear">Clear</button>
                            <button type="button" class="button" data-action="change-color">Change color</button>
                            <button type="button" class="button" data-action="undo">Undo</button>

                          </div>
                          <div>
                            <button type="button" class="button save" data-action="save-png">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <script src="js/signature_pad.js"></script>
                
                
                @endforeach
                
                <div class="col-12 col-sm-12 d-md-none d-lg-none d-xl-none">
                    <input id="saveevent" type="submit" name="saveprofile" class="createevent" value="Save Event">
                </div>
                
            </div>
        </div>
    </form>
</div>
@stop