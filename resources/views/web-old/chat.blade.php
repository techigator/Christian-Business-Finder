@extends('web.layouts.main')
@section('content')  

<section class="ChatSec">
    <div class="container">
        <div class="col-md-12 col-xs-12">
            <div class="chat-messages">
                <h2 class="h2">Chat {{$touser['name']}}</h2>
                <!--<div class="chat-active-name">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Harrison Hamilton</h3>
                        </div>
                    </div>
                </div>-->
                <div class="main-chat">
                    <div class="scroll-chat-box scroll4" id="show_messages">
                         <?php
                        if(!$messages->isEmpty()){
                            foreach ($messages as $key=>$value):
                                if($value['from_user_id']==auth::user()->id){?>

            <div class="prof-icon d-flex">
                     <img src="{{asset('web/images/icons/avatars/'.strtoupper(auth::user()->name[0]))}}.svg" alt="">
                     <p><strong><?php echo auth::user()->name;?></strong><br><?=date("F j, Y",strtotime($value['created_at'])) ?> At <?=ltrim(date(" h:i A",strtotime($value['created_at'])), " 0")?></p>
            </div>
                                    <div class="send">
             
                                        <div class="chat-text">
                                            <p><?php echo $value['message'];?></p>
                                        </div>
                                    </div>
                                <?php }
                                else{?>
            <div class="prof-icon d-flex">
                     <img src="{{asset('web/images/icons/avatars/'. strtoupper($touser['name'][0]))}}.svg" alt="">
                     <p><strong><?php echo $touser['name'];?></strong><br><?=date("F j, Y",strtotime($value['created_at'])) ?> At <?=ltrim(date(" h:i A",strtotime($value['created_at'])), " 0")?></p>
            </div>
                                    <div class="recive">
                                    
                                        <div class="chat-text">
                                            <p><?php echo $value['message'];?></p>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            <?php endforeach;
                        }
                        ?> 
                    </div>
                    <div class="message-send-box">
                        <div class="form-group">
                            <div class="col-md-12">
                                <form method="post" action="{{route('save_msg')}}" id="form-chat">
                                    <input type="text" name="message" class="form-control" placeholder="Type your message ..." required>
                                    <input type="hidden" name="from_user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="group_id" value="{{$group_id}}">
                                    @csrf
                                    <!--<div class="btn-attecment">
                                        <input class="choose-file" type="file" id="choose-file" required="">
                                        <label for="choose-file" class="upload-file"></label>
                                    </div>-->
                                    <div class="btn-sent-chat">
                                        <button class="btn btn-default" type="submit">
                                            <img src="{{asset('web/images/chat-sent-iocn.png')}}" class="img-responsive" alt="" style="width:59px;height:59px">
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('css')
<link href="{{asset('web/css/chat.css')}}" rel="stylesheet" type="text/css">
<style>
    strong {
        color: white;
    }
    .prof-icon p{
        color: white;
    }
    .h2{
        text-transform:capitalize;
    }
    .ChatSec {
    padding: 15% 0 8% 0;
    background: #01091b;
}
.chat-messages {
    margin-bottom: 15px;
}
.main-chat {
    padding: 20px 0;
}
.scroll-chat-box {
    padding: 30px 0;
}
.message-send-box {
    padding-top: 20px;
    display: inline-block;
    position: relative;
    width: 100%;
}
.chat-messages form, .form-bg {
    background-color: #00818e;
    border-radius: 10px;
    padding: 45px 45px;
    box-shadow: 0px 0px 23px 0px rgba(0, 0, 0, 0.3);
}
.message-send-box input {
    box-shadow: 0px 0px 7px rgba(53, 152, 219, 0.13);
    height: 60px;
    border: 0;
    font-size: 13px;
    border-radius: 0;
    padding-left: 20px;
    font-family: 'Titillium Web', sans-serif;
    position: relative;
}
.btn-sent-chat {
    position: absolute;
    top: 60px;
    right: 66px;
}
.btn-sent-chat button {
    /* background: #b20000; */
    border: 0;
    width: 50px;
    height: 50px;
    text-align: center;}
img {
    overflow-clip-margin: content-box;
    overflow: clip;
}
</style>

@endsection
@section('js')
@if (!$messages->isEmpty())
<script type="text/javascript">
    // $(document).ready(function(){
            //     setInterval(function () {
            //         fetcher();
            //     }, 1000);
            // });
            $("#show_messages").mouseleave(function() {
                // setInterval(function () {
                    fetcher();
                    // }, 2000);
                });
                function fetcher() {
                    // alert(1);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: "{{ route('fetch_msg') }}",
                        data: {
                            to: {{$touser['id']}}
                        },
                        success: function(response) {
                            // alert(4)
                            //$('#msg').val("");
                        $('#show_messages').html(response.body);
                        $("#show_messages").animate({
                            scrollTop: $('#show_messages').prop("scroll-chat-box")
                        }, 500);
                    }
                });
                }
</script>
@endif
@endsection