<div class="container-wrap">
    <div class="content_wrap">
        <div class="row">
            <div class="d-none d-sm-none d-md-block col-md-5 col-lg-6 searchbtn autocomplete srchbtn" autocomplete="off">
                <input id="searchbtn" type="text" class="card_search search_btn" onfocus="this.value=''" autocomplete="off" placeholder="Search for events by People name"/>
                <span class="search-btn"> 
                    <button  id="btn_value"  type="button" class="btn btn_value"><img src="svg/searchicon.svg"></button>
                </span>
            </div>
            <div class="d-none d-sm-none d-md-block col-md-7 col-lg-6">
                <div class="menulist">
                    <nav class="navbar menu-nav">
                        <ul id="menulinks" class="nav">
                            <li class="profile-circle nav-item"><img class="profile-pic" src="{{$_SESSION['user_profile_pic']}}"></li>
                            <li class="nav-item"><h6 class="prof_name">{{mb_strimwidth($_SESSION['user_profile_name'], 0, 20, "...")}}</h6></li>
                            <li class="nav-item active"><a class="nav-link" href="{{'/up-events'}}"  style="color: white !important;">Home</a></li>
<!--                            <li class="nav-item"><a class="nav-link" href="connectsocial"  style="color: white !important;">People</a></li>-->
                            <li class="nav-item"><a class="nav-link" href="{{'/profile'}}"  style="color: white !important;">Profile</a>
                            <li class="nav-item"><a class="nav-link" href="{{'/logout'}}" style="color: white !important;"><!--<span class="glyphicon glyphicon-log-in"></span>-->Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            
        </div>
    </div>
</div>
