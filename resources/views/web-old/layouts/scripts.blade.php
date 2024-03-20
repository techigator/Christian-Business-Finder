<script src="{{asset('web/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('web/js/bootstrap.min.js')}}"></script>
<script src="{{asset('web/js/slick.js')}}"></script>
<script src="{{asset('web/js/slick.min.js')}}"></script>
<script src="{{asset('web/js/owl-custom.js')}}"></script>
<script src="{{asset('web/js/vanilla-tilt.js')}}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="{{asset('web/js/custom.js')}}"></script>
<script src="{{asset('web/js/toastr.min.js')}}"></script>
<script>
  // Hide the loader after the page finishes loading
  window.addEventListener('load', function() {
    setTimeout(function() {
      var loader = document.querySelector('.loader');
      loader.style.display = 'none';

    }, 2000)

  });
</script>

<script>
  document.getElementsByTagName("body")[0].style.overflowX = "hidden";
</script>

<!-- scroll-top the page  -->

<script>
  var btn = $('#button');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, '300');
  });
</script>
@if(Auth::check())
@if(Auth::user()->id == 1)      
@endif
@endif
<script>
@if(Session::has('message'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true,

  	"debug": false,

  	"positionClass": "toast-bottom-right",

  }

  		toastr.success("{{ session('message') }}");

  @endif
@if(Session::has('success'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true,

  	"debug": false,

  	"positionClass": "toast-bottom-right",

  }

  		toastr.success("{{ session('success') }}");

  @endif



  @if(Session::has('error'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true,

  	"debug": false,

  	"positionClass": "toast-bottom-right",

  }

  		toastr.error("{{ session('error') }}");

  @endif



  @if(Session::has('info'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true,

  	"debug": false,

  	"positionClass": "toast-bottom-right",

  }

  		toastr.info("{{ session('info') }}");

  @endif



  @if(Session::has('warning'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true,

  	"debug": false,

  	"positionClass": "toast-bottom-right",

  }

  		toastr.warning("{{ session('warning') }}");

  @endif
</script>
