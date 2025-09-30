<style>
#chatIcon{
  
  bottom: 60px;
  right:2px;
  z-index:3;
  width: 70px;
  position:fixed;
}

.chatbot_card .card .card-content{
  background: url(//cdn.vgn.in/images/vgnchatbot/chat-background.png) no-repeat;
  background-size: cover;
  background-position:center;
  padding: 0px;
}     
.chatbot_card .crd_header{
  background: red;
  padding: 1rem;
font-size: 14px;
font-weight: 500;
text-transform: uppercase;

}

.badge_css{
  min-width: 3rem;
    padding: 3px;
    text-align: center;
    font-size: 1rem;
    line-height: inherit;
    color: #757575;
    float: right;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    background: red;
    color: #fff;
    font-size: 14px;
    border-radius: 3px;
}


.botbadge_css{
  min-width: 3rem;
    padding: 0 6px;
    text-align: center;
    font-size: 1rem;
    line-height: inherit;
    color: #757575;
    float: right;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    background: #26a69a;
    color: #fff;
    font-size: 13px;
    border-radius: 3px;
}

.chatbot_card .card .card-action{
  padding: 0px 10px;
}
.chat_header_close {
  cursor: pointer;
  font-size: 1rem !important;
margin-top: 3px;
margin-right:3px;
}
.conversation {
  
padding: 15px;
height: 300px;
overflow-y:auto;
}
.vgnchatbot {
  bottom: 0px;
  /*bottom: 50px;*/
  right:0px;
  z-index:1000;
  position:fixed;
  /*margin-left: 3px;*/
 
}
.vgnchatbot input {
  color: #000;
}
#location_chat {
  <!-- position: fixed;
  z-index: 1000; -->
}
#countrycode{
 <!-- position: fixed;
  z-index: 1000;  -->
}
.conversation::-webkit-scrollbar {
width: 0.5em;
}
.conversation::-webkit-scrollbar-track {
-webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.3);
}

.conversation::-webkit-scrollbar-thumb {
background-color: darkgrey;
outline: 1px solid slategrey;
}
.usr_response {

text-align:right;
clear: both;

}

.projectbadge, .budgetbadge,.projecttypebadge, .usr_resspanbadge {    
/*border-radius: 3px;
float: right;
margin: 3px;
cursor: pointer;*/
/*background: #26a69a;
    cursor: pointer;
    padding: 3px;
    font-size: 14px;
    text-align: center;
    border-radius: 3px;
    margin: 3px 0px;*/
}

.gen_info{
font-size: 13px;
text-align: center;
color: #000;
}

.bot_chat {
clear: both;
}

.defineblock{
  display:block !important;
}

.newultagbtn{
  float: left;
  margin: 0 25px;
}
.newultagbtn > li{
  list-style-type: none;
    background: #26a69a;
    cursor: pointer;
    padding: 5px;
    font-size: 14px;
    text-align: center;
    border-radius: 3px;
    margin: 3px;
    float: left;
}
.newlitagbtn{
    background: #26a69a;
    cursor: pointer;
    padding: 3px;
    font-size: 14px;
    text-align: center;
    border-radius: 3px;
    margin: 3px 0px;
}

 




/* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {
        .vgnchatbot {
             max-width: 100%;
             min-width: 100%;
        }
    }

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .vgnchatbot {
             max-width: 20%;
             min-width: 20%;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
        .vgnchatbot {
             max-width: 25%;
             min-width: 25%;
           
        }
    }

</style>

