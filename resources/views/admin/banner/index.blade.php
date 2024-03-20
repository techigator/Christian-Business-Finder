@extends('admin/layouts/app')

@section('title', 'Banner')

@section('page_heading', 'Banner')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Banner</li>
    </ol>
@endsection

@section('content')





<div class="card">
	<!-- /.card-header -->
	<div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <form action="{{url('admin/banner')}}" method="post" enctype="multipart/form-data">
    			@csrf
                    <div class="input-group">
                        <input name="file" type="file" class="form-control form-control-lg" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<!-- /.card-header -->
	
	  <div class="card-body">
	    <table id="example1" class="table table-bordered table-striped">
	      
	      <thead>
                <tr>
                    <th>#</th>
                    <th>Banner</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($banners as $banner)
                <!-- Preview -->
                <tr id="clPreview{{$banner->id}}">
                    <td>BR#{{$banner->id}}</td>
                    <td><img src="{{asset('assets/uploads/banner/'.$banner->file)}}" width="90" height="90"></td>
                    <td>
                    	<div class="form-group">
		                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
		                      	<input type="checkbox" class="custom-control-input switch-input" id="{{$banner->id}}" {{($banner->status==1)?"checked":""}}>
								<label class="custom-control-label" for="{{$banner->id}}"></label>
		                    </div>
		                </div>
					</td>
                    <td>
                        <a class="btn btn-danger btn-sm" href="{{url('admin/banner/'.$banner->id.'/delete')}}">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <!-- Preview -->

                @endforeach
                </tbody>

	    </table>
	  </div>
	  <!-- /.card-body -->
</div>
@endsection

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('assets/backend_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      /*"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]*/
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script>

$(".switch-input").change(function(){
    
    if(this.checked)
        var status=1;
    else
        var status=0;
    $.ajax({
        url: '{!! URL("admin/banner/status/404") !!}',
        type: 'post',
        /*dataType: 'json',*/
        data: {'_token': '{{ csrf_token() }}','user_id': this.id,'status':status},
        success: function (response) {
            if(status==1)
              toastr.success("Banner turned ON");
            else
              toastr.error("Banner turned OFF");
        }, error: function (error) {
            toastr.error("Some error occured!");
        }
    });
});

$(".btn-edit").click(function(){

    $(".clEdit").addClass('d-none');
    $(this).closest('tr').next('tr').removeClass('d-none');
    
    /*if($(this).closest('tr').next('tr').hasClass("d-none"))
        $(this).closest('tr').next('tr').removeClass('d-none');
    else
        $(this).closest('tr').next('tr').addClass('d-none');*/

});

</script>



@endpush

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush