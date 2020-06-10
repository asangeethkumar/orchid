/*script for profile picture */
        $(document).ready(function() {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".file-upload").on('change', function(){
                readURL(this);
            });
            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });
        });
  
/*script for calender*/
        $(document).ready(function() {
            var minDate ;
            var maxDate;
            var mDate;
            $( "#endTime" ).datepicker({
                showAnim: 'drop',
                dateFormat: "d-M-yy"
            });
            $('.cal_icon1').click(function() {
                $("#startTime").focus();
            });
            $('.cal_icon2').click(function() {
                $("#endTime").focus();
            });
            $( "#startTime" ).datepicker({
                showAnim: 'drop',
                dateFormat: "d-M-yy",
                onSelect: function() {
                    minDate = $( "#startTime" ).datepicker("getDate");
                    var mDate = new Date(minDate.setDate(minDate.getDate()));
                    maxDate = new Date(minDate.setDate(minDate.getDate() - 1));
                    $("#endTime").datepicker("setDate", maxDate);
                    $( "#endTime" ).datepicker( "option", "maxDate", mDate);
                }
            });
            $( "#endTime" ).datepicker();
        });
  
/*script for wordcount in textarea */
        function limitText(limitField, limitCount, limitNum) {
                if (limitField.value.length > limitNum) {
                        limitField.value = limitField.value.substring(0, limitNum);
                } else {
                        limitCount.value = limitNum - limitField.value.length;
                }
        }   

/*Script for popup in createEvents page*/
        $(document).on('click','.addfriend-modal',function(){
           // $('#addpeople').modal('show'); //to add people
            $('.form-horizontal').show();
            $('.modal-title').text('Invite your Friends');
        });

        $(document).on('click','.pickcards-modal',function(){
            //$('#viewcards').modal('show'); //to get all cards
            $('.form-horizontal').show();
            $('.modal-title').text('Add Post');
        });

        $(document).on('click','.significantevent-modal',function(){
           // $('#addsignificant_event').modal('show'); //to get all cards
            $('.form-horizontal').show();
            $('.modal-title').text('Add Significant Event');
        });

/*For fadeout the message in profile page*/
        $(document).ready(function(){ 
            $('#changepsd_status').delay(5000).fadeOut('slow'); 
        });

/*unselect all checkbox in view all cards popup*/
        function UnSelectAll(){
            var items=document.getElementsByName('cardname');
            for(var i=0; i<items.length; i++){
                if(items[i].type=='checkbox')
                    items[i].checked=false;
            }
        }		

/*to get the value of card in vieweventspage*/
        $(function() {
            $('#selectcards').click(function() {
              $('#selectcards').show();
            });

            var value ;

            $('input[type=radio]').click(function(){value = $(this).val();});
            $('#selectedcard').click(function() {
                var card_selected = value.split("&&");
                $(".card_id").attr("value",card_selected[0]);
                $(".selec_card").attr("src",card_selected[1]);
                $(".nocard").css('display','none');
                $('#selectcards').hide();
          });
        });

/*to display edit profile*/
        function editProfile() {
            $("#show_primary_details").css('display','none');
            $("#edit_primary_details").css('display','block');
        }

/*close button for deleting signfevent in profilepage*/
        $(document).ready(function() {
           $(".del_event").click(function(){
                var datp = $(this).data('id');
                var delval = $('#del_val').attr('href')+datp;
                $("#del_val").attr("href", delval);
            });
        });

/*close button for deleting events in homepage*/
        $(document).ready(function() {
           $(".delevent").click(function(){
                var datp = $(this).data('uid');
                var delval = $('#delval').attr('href')+datp;
                $("#delval").attr("href", delval);
            });
        });

/*close button for deleting events in homepage*/
        $(document).ready(function() {
           $(".del_past").click(function(){
                var datp = $(this).data('pid');
                var delval = $('#del_past_val').attr('href')+datp;
                $("#del_past_val").attr("href", delval);
            });
        });

/*for required condition for cards and recipent in createeventpage*/
    $(document).ready(function () {
        $("#saveevent").click(function () {
            if($('#receiver').val() != '') {
                $('#card-btn').attr('required', true);
            }else if($('#receiver').val() === ''){
                $('#card-btn').attr('required', false);
            }
            var checked_card = document.querySelector('input[name = "card"]:checked');
            if(checked_card != null){  
                $('#receiver').attr('required', true);
            } else if($('#card-btn').val() == null){
                $('#receiver').attr('required', false); 
            }
        });
     });
     
/*view full image in showcard page*/
        $(document).ready(function() {
           $(".viewimg").click(function(){
                $('#enlarge').attr('src',"")
                var datimg = $(this).data('imgid');
                var imgval = $('#enlarge').attr('src')+datimg;
                $("#enlarge").attr("src", imgval);
            });
        });

/*for copy the url in show card page*/
    function copyLink(element){
        $(element).select();
        document.execCommand("copy");
    }