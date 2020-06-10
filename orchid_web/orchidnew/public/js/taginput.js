var i_val = 0;
var emailArray = [];
//function to remove email tags on clicking x button.
$('#tags').on('click', 'span', function () {
   $(this).remove();
});

var backKeyPressed = 0;

//function to remove added email address on pressing back key.
$(".emailtag").on({
   keyup: function (ev) {
       if (/(8)/.test(ev.which)) {
           if ($('#tags span').last().hasClass("focusTag")) {
               backKeyPressed++;
               if (backKeyPressed % 2 === 0) {
                   $('#tags span').last().remove();
                   $('#tags span').last().addClass("focusTag");
                   backKeyPressed = 1;
               }
           }
       }
   }
})


//function to validate entered strings.
$("#tags input").on({
   keyup: function (ev) {
       if (/(13|32)/.test(ev.which) && this.value) {
           validateEmail(this.value, this);
       }
       if (/(8)/.test(ev.which)) {
           if (!this.value) {
               if ($('#tags span').last().hasClass("focusTag")) {
               }
               else {
                   $('#tags span').last().addClass("focusTag");
               }
           }
       }
   }
})

//validate email address
function validateEmail(inputValue, that) {
   var emailAddresses = inputValue.replace(/\s+$/, '').split(",");
   var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
   emailAddresses.forEach(function (emailAddress) {
       $("#invitee_email2").css("border", "1px #ccc solid");
       if (regex.test(emailAddress)) {
           //$("<span/>", { text: emailAddress.toLowerCase(), insertBefore: that, class: 'emailAdd', id:"email"+i_val, tabindex: '1' });
           var emailData = emailAddress.toLowerCase();
           var html = '<div id="main" class="row sign_event friendList3">'+
                   '<div class="col-3 col-sm-3 col-md-2 col-lg-2"><img src="img/png/email.png"></div>'+
                   '<div class="col-8 col-sm-8 col-md-9 col-lg-9 sign_detail events"><h5 class="sign_name">'+emailData.slice(0, 18)+'..'+'</h5>'+
                    '<img src="img/png/email.png" width="20" height="20"></div>'+
                    '<div class="col-1 col-sm-1 col-md-1 col-lg-1 removeEmail">X</div>';
            $("#friends_list2").append(html);
            if($("#no_friends2").text().length > 0){
                    $("#no_friends2").remove();
                }
            //adding Email to array
            emailArray[i_val] = emailData;
           i_val++;
           that.value = "";
       }
       else {
           document.getElementById("invitee_email2").value = emailAddress;
           $("#invitee_email2").css("border", "1px solid red");
           //alert("invalid");
       }
   });
}

//to read all email addresses
$(document).ready(function(){
    $(document).on("click", "#formSubmit", function(){
        var emailData = "";
        for(var i=0; i<emailArray.length; i++){
            emailData = emailData + ","+emailArray[i];
        }
        document.getElementById("invitee_email").value = emailData;
    });
});
   
//remove Email from right end
$(document).ready(function(){
    
    var noData = '<div class="no_friends nocard" id="no_friends2">'+
                    '<h6>You have not added friend / friend\'s</h6>'+
                '</div>';
    $(document).on("click", ".removeEmail", function(){
        var emailId = $(this).parents(".friendList3").text();
        $(this).parents(".friendList3").remove();
        
        var data2 = $('#friends_list2').text().trim();
        if(data2.length === 0){
            $("#friends_list2").append(noData);
        }
        
        var emailValue = emailId.substring(0, emailId.length-1);
        var arrEmail = [];
        for(var i=0; i<emailArray.length; i++){
            arrEmail[i] = emailArray[i];
        }
        emailArray.length = 0;
        var k = 0;
        for(var i=0; i<arrEmail.length; i++){
            if(emailValue !== arrEmail[i]){
                emailArray[k] = arrEmail[i];
                k++;
            }
        }
        i_val = emailArray.length;
    });
});