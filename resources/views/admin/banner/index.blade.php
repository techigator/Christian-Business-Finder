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
                    <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group">
                            <input name="file" type="file" class="form-control form-control-lg" required>
                            <select name="business_id" class="form-control form-control-lg">
                                <option value="">Select Business</option>
                                @foreach($businesses as $business)
                                    <option value="{{ $business->id }}">{{ $business->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-plus">Save</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped text-center">

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
                    <tr id="clPreview{{ $banner->id }}">
                        <td>BR#{{ $banner->id }}</td>
                        <td>
                            <img src="{{ asset('/uploads/banner/'.$banner->file) }}" style="width: 10rem; height: 90%; border-radius: 4px;">
                        </td>
                        <td>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input switch-input"
                                           id="{{ $banner->id }}" {{ ($banner->is_active == 1) ? "checked" : "" }}>
                                    <label class="custom-control-label" for="{{ $banner->id }}"></label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info edit-btn" data-toggle="modal" data-target="#editModal" data-id="{{ $banner->id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <a class="btn btn-danger" href="{{ route('banner.delete', $banner->id) }}">
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Banner Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body edit-modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/backend_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/backend_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script
        src="{{asset('assets/backend_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script
        src="{{asset('assets/backend_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
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

        $(".switch-input").change(function () {

            let banner_id = $(this).attr('id');
            let route = '{{ route('banner.status') }}' +'/'+ banner_id;
            var status = "";

            if (this.checked) {
                status = 1;
            } else {
                status = 0;
            }

            $.ajax({
                url: route,
                type: 'POST',
                data: {'_token': '{{ csrf_token() }}', 'user_id': this.id, 'status': status},
                success: function (response) {

                    if (status === 1) {
                        toastr.success("Banner turned ON");
                    } else {
                        toastr.error("Banner turned OFF");
                    }

                }, error: function (error) {
                    toastr.error("Some error occurred!");
                }
            });
        });

        function fetchBusinesses(businesses) {
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    if (Array.isArray(businesses)) {
                        resolve(businesses);
                    } else {
                        reject(new Error("Invalid businesses data"));
                    }
                }, 1000);
            });
        }

        $(document).ready(function() {
            $(".edit-btn").click(async function () {
                try {
                    var banner_id = $(this).data('id');
                    var route = '{{ route('banner.edit') }}' + '/' + banner_id;
                    var edit_modal_body = $('.edit-modal-body');

                    // Using async/await with $.ajax
                    var response = await $.ajax({
                        url: route,
                        type: 'GET',
                        data: {'_token': '{{ csrf_token() }}'},
                    });


                    if (response.success === true) {
                        var businesses = await fetchBusinesses(response.banner_data.businesses);
                        var file = '{{ asset('uploads/banner/') }}' +'/'+ response.banner_data.file;

                        var htmlContent = `
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="col-5">
                                        <select name="business_id" class="form-control form-control-lg">
                                            <option value="">Select Business</option>
                                            ${businesses.map(business => `<option value="${business.id}">${business.name}</option>`).join('')}
                                        </select>
                                        </div>

                                        <div class="col-5">
                                        <div class="form-group edit-thumbnail-div">
                                             <strong>Edit Banner Image:</strong>
                                                <img
                                                    src="${file || 'https://media.istockphoto.com/id/1147544806/vector/no-thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=Ni8CpW8dNAV0NrS6Odo5csGcWUySFydNki9FYi1XHYo='}"
                                                    style="width: 150px; height: 100px;"
                                                    id="edit-banner"
                                                    alt="business"/>
                                                <input type="file" name="file" value="" id="banner"
                                                       class="form-control my-4"/>
                                        </div>
                                        </div>

                                        <div class="col-2">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default">
                                                <i class="fa fa-plus">Save</i>
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                        edit_modal_body.empty().append(htmlContent);
                        $('#editModal').show();
                    } else {
                        toastr.error("Failed to fetch data for editing banner.");
                    }
                } catch (error) {
                    toastr.error("An unexpected error occurred. Please try again later.");
                }
            });
        });


    </script>

@endpush

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{asset('assets/backend_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('assets/backend_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('assets/backend_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
