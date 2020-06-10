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

<div id="addmsg">
    <div class="row create_event">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12  save_profile">
            <div class="col-11 col-sm-6 col-md-6 col-lg-6">
                <span onclick="window.history.back();" style="cursor: pointer;">
                    <h4 id="createevent"> <span><img class="left_button" src="svg/left.svg"></span> Add Message to card</h4>
                </span>
            </div>
           @if(($userrole == "SUPER ADMIN") || ($userrole == "ADMIN"))
                <div class="d-none d-sm-none d-md-block offset-md-4 col-md-2 offset-lg-4 col-lg-2">
                    <a href="{{'/edit-event'}}"><input type="submit" name="saveprofile" id="save_profile" class="saveprofile" value="Edit"></a>
                </div>
            @endif
        </div>
    </div>
    
    <div id="content-col" class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 createcontent">
            <form action="{{'/create-msg'}}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 card_msg">
                       <div class="row fst_div">
                            <div class="offset-1 col-11 offset-sm-1 col-sm-11 offset-md-1 col-md-11 offset-lg-1 col-lg-11">
                                <h5 class="heading1">Event details</h5>
                            </div>
                        </div>
                        <div class="row card_details">
                            @foreach($addevents['output'] as $event)
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                    <h6 class="row_gap">Event</h6>
                                    <h6 class="row_gap">Event date</h6>
                                    <h6 class="row_gap">Response date</h6>
                                    <h6 class="row_gap">Event description</h6>
                                    <h6 class="row_gap">Occasion</h6>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                    <h6 class="row_gap">:  {{$event['event_name']}}</h6>
                                    <h6 class="row_gap">:  {{  Carbon\Carbon::parse($event['event_start_time'])->format('d M Y') }}</h6>
                                    <h6 class="row_gap">:  {{  Carbon\Carbon::parse($event['event_response_by_time'])->format('d M Y') }}</h6>
                                    <h6 class="row_gap">:  {{$event['event_description']}}</h6>
                                    <h6 class="row_gap">:  {{$event['event_type_name']}}</h6>
                                </div>
                            @endforeach
                        </div> 
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <h6 class="row_gap">Recipient Email</h6>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                @if($selectedcard['status_code'] == 200)
                                    <h6 class="row_gap">:  {{mb_strimwidth($selectedcard['card_data']['recipient_email'], 0, 15, "...")}}</h6>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 card_msg ">
                        <div id="main" class="row card_details">
                            @foreach($addevents['output'] as $event)
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 recvr_detls">
                                    <h5 class="lett_bold">{{$event['event_name']}}</h5>
                                    <h6 class="birth_day">{{  Carbon\Carbon::parse($event['event_start_time'])->format('d M') }}</h6>
                                </div>
                            @endforeach
                        </div>
                        @if($selectedcard['status_code'] == 200)
                        <div id="scroll_bvr">
                            @foreach($selectedcard['user_messages'] as $message)
                                @if($_COOKIE['orchid_unumber'] == $message['user_id'])
                                    <div id="main" class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <p class="msg">&#34;{{$message['message']}}&#34;</p>
                                            @if(isset($message['file_name']))
                                                @if ((pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'JPG') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'jpg') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'PNG') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'png') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'gif'))
                                                    <div id="main" class="row row_gap">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 img_align">
                                                            <img data-imgid="{{$message['file_location']}}" src="{{$message['file_location']}}"  class="viewimg row_gap" data-toggle="modal" data-target="#viewimg" width="80px" height="80px"/>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 img_align">
                                                            <img data-imgid="{{$message['scrible_image']}}" src="{{$message['scrible_image']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="150px" height="80px"/>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'mp3')
                                                    <div id="main" class="row row_gap">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 img_align">
                                                            <audio style="width : 250px !important" controls class="row_gap">
                                                                <source src="{{$message['file_location']}}" type="audio/mpeg">
                                                            </audio>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 img_align">
                                                            <img data-imgid="{{$message['scrible_image']}}" src="{{$message['scrible_image']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="150px" height="80px"/>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'mp4')
                                                    <div id="main" class="row row_gap">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 img_align">
                                                            <video width="250px" controls class="row_gap">
                                                                <source src="{{$message['file_location']}}" type="video/mp4">
                                                            </video>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 img_align">
                                                            <img data-imgid="{{$message['scrible_image']}}" src="{{$message['scrible_image']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="150px" height="80px"/>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 writer">
                                            @if(($message['first_name'] == "''") || ($message['first_name'] == null))
                                                <p class="msg">--{{$message['email']}}--</p>
                                            @else
                                                <p class="msg">--{{$message['first_name']}}--</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-10 col-sm-10 col-md-10 col-lg-10">
                                @if($selectedcard['status_code'] == 200)
                                    @foreach($selectedcard['user_messages'] as $message)
                                        @if($message['message'] == "")
                                            <textarea class="eventcreate" name="addmessage" cols="40" placeholder="Add message" required="true"></textarea>
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
                                        <textarea class="eventcreate" name="addmessage" cols="35" rows="1" placeholder="Add message" required="true"></textarea>
                                    @else
                                        <textarea class="eventcreate" name="addmessage" cols="35" rows="1" placeholder="Add message" ><?php echo $mymsg?> </textarea>
                                    @endif
                                @else
                                    <textarea class="eventcreate" name="addmessage" cols="35" rows="1" placeholder="Add message"></textarea>
                                @endif
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                <button type="button" id="signature_data" class="writepad" data-toggle="modal" onclick="pop();"> <img src="svg/pencil.svg"> </button>
                            </div>
                        </div>


                        <div class="row row_gap recvr_detls">
                            <div class="col-9 col-sm-9 col-md-9 col-lg-9">
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
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                                <input type="submit" name="saveprofile" class="msgsave" id="save_profile" value="Save">
                            </div>
                        </div>



                        <!-- write message Popup-->
                            <div class="modal" id="write-msg" role="dialog" style="top:15%; left:23%;">
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

                        @else
                            <h6 class="nocard">Recipient Email is not added. Edit to add</h6>
                        @endif
                    </div>

                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 card_msg">
                        @if($selectedcard['status_code'] == 200)
                        <div class="selected_card">
                            <input class="card_id" name="ce_mapping_id" value="{{$selectedcard['card_data']['ce_mapping_id']}}" style="display: none;">
                            <input class="card_id" name="card_id" value="{{$selectedcard['card_data']['cards_id']}}" style="display: none;">
                            <img class="selec_card" src="{{$selectedcard['card_data']['cards_location_url']}}" />
                        </div>
                        @else
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 card_disp">
                            <h6 class="nocard">You have not selected the card. Edit to select</h6>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
                
                @if(($userrole == "SUPER ADMIN") || ($userrole == "ADMIN"))
                <div class="col-12 col-sm-12 d-md-none d-lg-none">
                    <a href="{{'/edit-event'}}"><input id="saveevent" type="submit" name="saveprofile" class="createevent" value="Edit Event"></a>
                </div>
                @endif
            
        </div>
    </div>
</div>
@stop