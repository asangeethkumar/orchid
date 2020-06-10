@extends('layout.default')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    $(document).ready(function() {

        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };

        //loading url's of mobile's or desktop
        if( isMobile.any() ){
            //WhatsApp-mobile

            //viber
            var text = $("#viber").attr("data-text");
            var url = $("#viber").attr("data-link");
            var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
            $('#viber').each(function() {
                $(this).attr("href", $(this).attr("href") + message);
            });
        }else{ 
            //WhatsApp-desktop
            $('#whatsapp').attr("href", "https://web.whatsapp.com/send?text=");
            var text = $("#whatsapp").attr("data-text");
            var url = $("#whatsapp").attr("data-link");
            var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
            $('#whatsapp').each(function() {
                $(this).attr("href", $(this).attr("href") + message);
            });

            //messenger
            $("#messenger").remove();
            
            //viber
            $("#viber").remove();
        }

        //linked url loading
        var text = $("#linkedin").attr("data-text");
        var url = $("#linkedin").attr("data-link");
        var src = $("#linkedin").attr("data-source");
        var title = $("#linkedin").attr("data-title");
        var message = encodeURIComponent(url)+"&title="+encodeURIComponent(title)+"&summary="+encodeURIComponent(text)+"&source="+encodeURIComponent(src);
        $('#linkedin').each(function() {
            $(this).attr("href", $(this).attr("href") + message);
        });

        $(document).on("click", '.whatsapp', function() {
            if( isMobile.any() ) {
                var text = $(this).attr("data-text");
                var url = $(this).attr("data-link");
                var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
                var whatsapp_url = "whatsapp://send?text=" + message;
                window.location.href = whatsapp_url;
                setTimeout(function(){ window.location.href="https://play.google.com/store/apps/details?id=com.whatsapp"}, 1250);
            }	 
        });

        $(document).on("click", '#messenger', function() {
            if( isMobile.any() ) {
                var text = $(this).attr("data-text");
                var url = $(this).attr("data-link");
                var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
                var messenger_url = "fb-messenger://share/?link=" + message;
                window.location.href = messenger_url;
                setTimeout(function(){ window.location.href="https://play.google.com/store/apps/details?id=com.facebook.orca"}, 1250);

            }	 
        });

        $(document).on("click", '#viber', function() {
            if( isMobile.any() ) {
                var text = $(this).attr("data-text");
                var url = $(this).attr("data-link");
                var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
                var messenger_url = "viber://forward?text=" + message;
                window.location.href = messenger_url;
                setTimeout(function(){ window.location.href="https://play.google.com/store/apps/details?id=com.viber.voip"}, 1250);

            }	 
        });
    });
</script>
<script type="text/javascript">
    // jQuery extension
    $(document).ready(function(){
        $.fn.extend({
            contains: function(str) {
                return this.filter(function(){
                    return $(this).html().indexOf(str) !== -1;
                });
            }
        });
    });
    $(document).ready(function(){
        var noData = '<div class="no_friends nocard" id="no_friends2">'+
                                    '<h6>You have not added friend / friend\'s</h6>'+
                                '</div>';
        $("#friends_list2").append(noData);
        $('.check-with-label').click(function(){
           if($(this).is(":checked")){
               $('.no_friends').css('display','none');
                $(this).parents(".sign_event").css("background", "#bec4ca");
                var data = $(this).parents(".sign_event").html();
                var html = '<div id="main" class="row sign_event friendList3">'+data+'<div class="uncheck">X</div></div>';
                $("#friends_list2").append(html);
                if($("#no_friends2").text().length > 0){
                    $("#no_friends2").remove();
                }
            }
            else{
                $(this).parents(".sign_event").css("background", "none");
                var data = $(this).parents(".sign_event").html();
                var str = $(this).val();
                $(".friendList3").contains(str).remove();
                var data2 = $('#friends_list2').text().trim();
                if(data2.length === 0){
                    $("#friends_list2").append(noData);
                }
            }
        });
        $(document).on("click", ".uncheck", function(){
            var idValue = $(this).parents(".friendList3").children(".sign_detail").children("input").attr("id");
            var str = $("#"+idValue).val();
            $("#"+idValue).prop("checked", false);
            $("#"+idValue).parents(".sign_event").css("background", "none");
            $(".friendList3").contains(str).remove();
            var data2 = $('#friends_list2').text().trim();
            if(data2.length === 0){
                $("#friends_list2").append(noData);
            }
        });
    });
    //prevent form submit by hitting Enter button
    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode === 13) {
              event.preventDefault();
              return false;
            }
        });
    });
</script>


<div id="creatingevent">
        <div  class="row create_event">
            <div class="col-11 col-sm-11 col-md-12 col-lg-12  save_profile">
                <div class="col-8 col-sm-8 col-md-6 col-lg-6">
                    <span onclick="window.history.back();" style="cursor: pointer;">
                        <h4 id="createevent"> <span><img class="left_button" src="svg/left.svg"></span> Add Friends</h4>
                    </span>
                </div>
                <div class="col-4 col-sm-4 offset-md-3 col-md-1 offset-lg-3 col-lg-1">
                    <a class="skip_page" href="{{'/show-card'}}">Skip</a>
                </div>
        <form action="{{'/send-invitation'}}" method="post"> 
                <div class="d-none d-sm-none d-md-block col-md-2 col-lg-2">
                    <input type="submit" name="saveprofile" id="formSubmit" class="saveprofile" value="Invite">
                </div>
            </div>
        </div>
    
        <div id="content-col" class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 create_content">
                    <div class="col-12 col-md-8 col-sm-7 col-lg-7 mediaicons">
                        <div class="mediadiv inlneblk">
                            @if($addpeople['status_code'] == 200)
                                @foreach($addpeople['output'] as $addpeople)
                                    @if($addpeople['provider'] == 'SLACK')
                                        <div class="icons">
                                            <a href="{{'/get-slack-friends'}}"><img src="img/png/slack.png" width="35" height="35"></a>
                                        </div>
                                        @endif
                                    @if($addpeople['provider'] == 'TWITTER')
                                        <div class="icons">
                                            <a href="{{'/get-twitter-friends'}}"><img src="img/png/twitter.png" width="35" height="35"></a>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="icons">
                                <div id="fb-root"></div>
                                    <div class="fb-share-button" data-href="https://invagesystems.com" data-layout="button" data-size="large" data-mobile-iframe="false">
                                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Finvagesystems.com%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><img src="img/png/facebook.png" width="35" height="35"></a>
                                    </div>
                            </div>
                            <div class="icons">
                                <a href="" id="whatsapp" data-text="Hey, You!" data-link="http://localhost:8000" target="_blank" class="whatsapp"><img src="img/png/whatsapp.png" width="35" height="35"></a>
                            </div>
                            <div class="icons">
                                <a disabled="true" id="linkedin" data-link="https://invagesystems.com" data-source="Orchid" data-text="Join Orchid RUs to have fun with your friends" data-title="Orchid RUs" href="https://www.linkedin.com/shareArticle?mini=true&url="><img src="img/png/linkedin.png" width="35" height="35"></a>
                            </div>
                            <div class="icons">
                                <a href="#"><img src="img/png/skype.png" width="35" height="35"></a>
                            </div>
                            <div class="icons">
                                <a href="#" id="viber"><img src="img/png/viber.png" width="35" height="35"></a>
                            </div>
                            <div class="icons">
                                <a href="" id="messenger" data-text="Hey, You!" data-link="http://localhost:8000">Messenger</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    
           
            <div class="row">
                <div id="fnd_invite" class="col-11 col-sm-11 col-md-5 offset-lg-1 col-lg-5 card_msg"> 
<!--                    <form action="{{'/add-invite-people'}}" method="post"> -->
                        <input type="hidden" name="event_id" value="{{$event_id}}"/>
                        @if($friendList)
                            <div class="friends_list">
                               @for($i = 0; $i< count($friendList['users']); $i++)
                                   <label id="main" class="row sign_event friendList2">
                                       <div class="col-1 col-sm-1 col-md-1 col-lg-1 sign_detail events">
                                           @if($friendList['users'][$i]['provider'] == "SLACK")
                                               <input type="checkbox" name="email[]" id="user{{$i}}" class="check-with-label" value="{{$friendList['users'][$i]['email']}}">
                                           @endif
                                           @if($friendList['users'][$i]['provider'] == "TWITTER")
                                               <input type="checkbox" name="screen_name[]" id="user{{$i}}" class="check-with-label" value="{{$friendList['users'][$i]['screen_name']}}">
                                           @endif
                                       </div>
                                       <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                           <img src="{{$friendList['users'][$i]['profile_image_url']}}"> 
                                       </div>
                                       <div class="col-9 col-sm-9 col-md-9 col-lg-9 sign_detail events">
                                           <p class="sign_name">{{$friendList['users'][$i]['name']}}</p>
                                           @if($friendList['users'][$i]['provider'] == "TWITTER")
                                               <img src="img/png/twitter.png" width="20" height="20" />
                                           @endif
                                           @if($friendList['users'][$i]['provider'] == "SLACK")
                                               <img src="img/png/slack.png" width="20" height="20" />
                                           @endif
                                       </div>
                                   </label>
                               @endfor
                           </div>
<!--                            <div id="main" class="row">
                                <div class="col-12 col-sm-offset-7 col-sm-5 col-md-offset-7 col-md-5 col-lg-offset-7 col-lg-5">
                                    <input type="submit" name="saveprofile" class="saveprofile" value="Save">
                                </div>
                            </div>-->
                        @endif
                        @if($friendList == "")
                            <p> No friends</p>
                        @endif
<!--                    </form>-->
                </div>   
                
                <div id="fnd_invite" class="col-11 col-sm-11 col-md-5 offset-lg-1 col-lg-4 card_msg userGridCss">
<!--                    <form action="{{'/add-invite-people'}}" method="post"> -->
                    <div class="friends_list" id="friends_list2">
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-11 col-sm-11 offset-md-1 col-md-5 offset-lg-1 col-lg-5 card_msg2 userGridCss">
                    <div class="row fnds_email">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <h6>Invite your friend / friend's through email</h6>
                        </div>
                    </div>
                    <div class="row row_gap">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <input type="text" name="PROVIDER" value="EMAIL" style="display: none;"/>
                            <!--<input class="eventcreate" type="email" name="invitee_email" size="35" placeholder="Invitee email" autocomplete="off" autofocus="true"/>-->
                            <div class="emailtag">
                                <div id="tags">
                                    <input type="hidden" id="invitee_email" name="invitee_email" />
                                    <input type="text" id="invitee_email2" name="invitee_email2" placeholder="Email"/>
                                </div>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                            <script type="text/javascript" src="js/taginput.js"></script>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-12 col-sm-12 d-md-none d-lg-none">
                    <input id="formSubmit" type="submit" name="saveprofile" class="createevent" value="Invite">
                </div>    
            </div>
            
        </form>
    </div>
@stop