<body style="background-color: #fafafa">      
<p style="text-align: center; font-size: 1.2rem;">Hi,</p>
<p style="text-align: center; font-size: 1.2rem;">{{$event_creator_name}} {{$etAl}}sent you a card from Orchid.</p>
<p style="text-align: center;"><a href="http://dameeko.com/orchid/orchid_v0.0.1/public"><button
        style="background-color: #0c1f34;
        border: none;
        color: white;
        padding: 15px 25px;
        text-align: center;
        font-size: 16px;
        cursor: pointer;">Join Orchid</button></a></p>
<table style="width: 95%; 
        border-left-style: outset;
	border-left-width: 5px;
	border-right-style: outset;
	border-right-width: 5px;
	border-bottom-style: outset;
	border-bottom-width: 5px;
        border-top-style: outset;
	border-top-width: 5px;
        background-color: #0c1f34;
        " 
        align="center" border="0">
    <tr>
        <td width="50%" style="text-align: center; background-color: #FFFFFF;">
            <table align="center" 
                   width="100%" 
                   border="0" 
                   cellpadding="10" 
                   style="display: block; height: 450px; overflow-y: auto; text-align: center;">
               @foreach($user_messages as $data)
               <tr width="100%">
                        <td style="text-align: center; width: 570px;" >
                            <span style="font-size: 1.2rem;"><i>{{$data->message}}</i></span>
                        <br />  

                        -- {{$data->first_name}} --
                        </td>
                    </tr>

                @endforeach
            </table>            
        </td>
        <td width="50%" style="text-align: center; border-left-style: dashed;
	border-left-width: 5px; border-color: #0c1f34; background-color: #FFFFFF;">            
            <img width="95%" src="{{$card_link}}" />       
        </td>
    </tr>

</table> 
</body>
                        


