@extends('admin/layouts/app')  @section('content')
<div class="main-content-wrap sidenav-open d-flex flex-column">
    <div class="main-content">
        <div class="separator-breadcrumb border-top"></div>        
        <main>
   <div class="container-fluid site-width">
      <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <!-- <h2>Laravel 8 CRUD Example from scratch - ItSolutionStuff.com</h2> -->
                        </div>
                        <div class="pull-right text-right p-2">
                            
                        </div>
                    </div>
                </div>
      <div class="row">
         <div class="col-12 mt-3">
            <div class="card">
               <div class="card-header justify-content-between align-items-center flex-btn">
                  <h4 class="card-title"><strong>Setting Managment</strong></h4>
                  {{--
                  <a class="btn btn-success" href="" data-toggle="modal" data-target="#AddModal" style="background: #28a745; border-color: #28a745;"> Create New Inner Banner</a>
                    --}}
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="example" class="display table dataTable table-striped table-bordered">
                     <form action="{{ route('setting_update') }}" method="POST" enctype="multipart/form-data" id="form1" runat="server">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Company </label>
                                    <div class="col-md-12">
                                        <input type="text" name="company" value="{{ $setting['company'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Facebook </label>
                                    <div class="col-md-12">
                                        <input type="text" name="facebook" value="{{ $setting['facebook'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Instagram </label>
                                    <div class="col-md-12">
                                        <input type="text" name="instagram" value="{{ $setting['instagram'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Twitter </label>
                                    <div class="col-md-12">
                                        <input type="text" name="twitter" value="{{ $setting['twitter'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                {{--
                                
                                
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Linkedin </label>
                                    <div class="col-md-12">
                                        <input type="text" name="linkedin" value="{{ $setting['linkedin'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Trustpilot </label>
                                    <div class="col-md-12">
                                        <input type="text" name="trustpilot" value="{{ $setting['trustpilot'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Reviews </label>
                                    <div class="col-md-12">
                                        <input type="text" name="reviews" value="{{ $setting['reviews'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                --}}
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Address </label>
                                    <div class="col-md-12">
                                        <input type="text" name="address" value="{{ $setting['address'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Phone </label>
                                    <div class="col-md-12">
                                        <input type="text" name="phone" value="{{ $setting['phone'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Email </label>
                                    <div class="col-md-12">
                                        <input type="text" name="email" value="{{ $setting['email'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="con1"> Copyright </label>
                                    <div class="col-md-12">
                                        <input type="text" name="copyright" value="{{ $setting['copyright'] }}" id="con1" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>   
                        
                        
                    </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- END: Card DATA-->
   </div>
</main>
    </div>
</div>
<br />
<br />
@endsection
@section('link') 
<link rel="stylesheet" href="{{asset('vendors/datatable/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('vendors/datatable/buttons/css/buttons.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('vendors/x-editable/css/bootstrap-editable.css')}}" />

@endsection 
@section('script') 
<!-- END: Template JS-->
<script src="{{asset('vendors/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/x-editable/js/bootstrap-editable.min.js')}}"></script>
<script src="{{asset('vendors/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/datatable.script.js')}}"></script>
@endsection 
@section('css')
<style>
        #form1 {
        width: auto;
    }
   .modal-footer {
    border: none;
}
.table-responsive {
    overflow-x: hidden;
}  
    .dropdown-item.active, .dropdown-item:active {
    color: #fff!important;
    text-decoration: none;
    background-color: #17b2a2;
}
.flex-btn {
    display: flex;
}
.btn-group span{
    text-transform: capitalize;
}
div#example_filter {
    float: right;
}
.form-delete {    
    margin: 0;

}
.toggle-group .btn-success{
    color: #fff;
    background-color: #218838;
    border-color: #1e7e34;
}
</style>
@endsection
@section('js')
@endsection
