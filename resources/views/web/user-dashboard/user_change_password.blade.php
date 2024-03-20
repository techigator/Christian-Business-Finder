@extends('web.layouts.main')
@section('content')
<section class="dash1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 dash2" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Change Password</h2>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xxl-12 dashboard2">
                <div class="dashboard-container">
                    @include('web.user-dashboard.sidebar')
                    <div class="content-container password1">
                        <div class="password2">
                            <form class="sign4" id="sumbitform">
                                <div class="mb-3">
                                    <input type="password" class="form-control" placeholder="Enter current password" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" placeholder="Create your new password" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" placeholder="Confirm your password" name="confirm_new_password" required>
                                </div>

                                <!-- <a href="javascript:void(0)" class="btn sign5 btn-sumbit">SUBMIT</a> -->
                                <button type="button" class="btn sign5 btn-sumbit">SUBMIT</button>


                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@section('css')
@endsection
@section('js')
<script>
$( document ).ready(function() {
$(".btn-sumbit").on( "click",function(){
toastr.options ={"closeButton":true,"progressBar":true,"debug":false,"positionClass":"toast-bottom-right",}
            current_password = $("input[name='current_password']").val();
            new_password = $("input[name='new_password']").val();
            confirm_new_password = $("input[name='confirm_new_password']").val();
if(current_password==''){
            toastr.error('Please enter current password field');
}else if(new_password==''){
            toastr.error('Please enter create new password field');
}else if(confirm_new_password==''){
            toastr.error('Please enter confirm password field');
}else{
            var url = "{{ url('change-password')}}";
            $.ajax({
                 headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                type:'POST',
                url:url,
                 data:$("#sumbitform").serialize(),
                success: function(data) {
                       if(data.success===true){
                        toastr.success(data.message);
                       }else{
                        toastr.error(data.message);
                       }
                }
            });
}
            });
          });
</script>
@endsection
