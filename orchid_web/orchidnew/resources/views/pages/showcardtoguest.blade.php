@extends('layout.default')
@section('content')
<div id="addmsg">
    <div class="row">
        <div class="col-12 col-sm-12 offset-md-1 col-md-11 offset-lg-2 col-lg-8 card_preview">
            <div class="row" style="height: 100px;">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 congrats">
                    <h2 id="congrats">{{$selectedcard['card_data']['event_type_name']}}!</h2>
                </div>
            </div>
            <div class="row">
                @if($selectedcard['status_code'] == 200)
                    <div class="col-12 col-sm-5 col-md-4 order-md-7 col-lg-4 order-lg-7 maxcard">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <input class="card_id" name="ce_mapping_id" value="{{$selectedcard['card_data']['ce_mapping_id']}}" style="display: none;">
                                <input class="card_id" name="card_id" value="{{$selectedcard['card_data']['cards_id']}}" style="display: none;">
                                <img src="{{$selectedcard['card_data']['cards_location_url']}}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <h4 class="lett_bold recvr_detls">{{$selectedcard['card_data']['event_name']}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-7 col-md-7 order-md-4 col-lg-7 order-lg-4 created">
                        <div class="row allmsg">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                @foreach($selectedcard['user_messages'] as $message)
                                    @if($message['message'] != "")
                                    <div class="row" style="margin-bottom: 15px;">
                                        @if(($message['first_name'] == "''") || ($message['first_name'] == null))
                                        <div class="col-2 col-sm-2 col-md-1 col-lg-1">
                                           <img class="event_pic" src="{{$message['profile_picture']}}"/>
                                        </div>
                                        <div class="col-10 col-sm-10 col-md-11 col-lg-11">
                                            <h6 class="message">{{$message['email']}} : <span class="msg">{{$message['message']}}</span></h6>
                                        </div>
                                        @else
                                        <div class="col-2 col-sm-2 col-md-1 col-lg-1">
                                           <img class="event_pic" src="{{$message['profile_picture']}}"/>
                                        </div>
                                        <div class="col-10 col-sm-10 col-md-11 col-lg-11">
                                            <h6 class="message">{{$message['first_name']}} : <span class="msg">{{$message['message']}}</span></h6>
                                        </div>
                                        @endif
                                    </div>
                                    @if(isset($message['file_name']))
                                        @if ((pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'JPG') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'jpg') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'PNG') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'png') || (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'gif'))
                                            <div id="main" class="row row_gap">
                                                <div class="col-12 col-sm-12 col-md-8 col-lg-8 img_align">
                                                    <img data-imgid="{{$message['file_location']}}" src="{{$message['file_location']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="80px" height="80px"/>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                    <img data-imgid="{{$message['scrible_image']}}" src="{{$message['scrible_image']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="150px" height="80px"/>
                                                </div>
                                            </div>
                                        @endif
                                        @if (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'mp3')
                                            <div id="main" class="row row_gap">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-8 img_align">
                                                    <audio width="150px;" controls="controls">
                                                        <source src="{{$message['file_location']}}" type="audio/ogg">
                                                        <source src="{{$message['file_location']}}" type="audio/mpeg">
                                                    </audio>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                                                    <img data-imgid="{{$message['scrible_image']}}" src="{{$message['scrible_image']}}"  class="viewimg" data-toggle="modal" data-target="#viewimg" width="150px" height="80px"/>
                                                </div>
                                            </div>
                                        @endif
                                        @if (pathinfo($message['file_name'], PATHINFO_EXTENSION) == 'mp4')
                                            <div id="main" class="row row_gap">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-8 img_align">
                                                    <video width="300px;" controls>
                                                        <source src="{{$message['file_location']}}" type="video/mp4">
                                                        <source src="{{$message['file_location']}}" type="video/ogg">
                                                     Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-4">
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
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop