var Booking = {
	init: function () {

		$("#modal-change-dates").on('click', '.btn-availability', this.checkAvailability);
		$("#modal-change-dates").on('click', '.btn-checkout', this.checkOut);
	},

	checkAvailability: function () {
		var btn = $(this);
    	var body = btn.closest('#modal-change-dates').find('.modal-body');
    	var form = $("#formStep1");

		var overlay = btn.closest('#modal-change-dates').find('.overlay');
		overlay.removeClass("d-none");

    	var url = '{!! URL("administrator/booking/change-dates/2") !!}';

        $.ajax({
            url: '/administrator/booking/change-dates/2',
            type: 'POST',
            data: form.serialize(),
            success: function(data){
	          	
	          	overlay.addClass("d-none");  

	        	if(data.error){
	              toastr.error(data.msg);
	              return false;
	            }

	            body.children('#step1').hide();
	            body.children('#step2').html(data).show();
	            btn.hide();
	            $("#modal-change-dates").find('.button-stepback').removeClass('d-none');
	            $(".btn-checkout").removeClass('d-none');

	            var total = $("#modal-change-dates").find('input#total').val();
	            $("#modal-change-dates").find('td#newDetailTotal').html(total);
            },
            error: function (error) {
              overlay.addClass("d-none");
              toastr.error("Some error occured!");
          	}

        });
    },

    checkOut: function() {
    	var btn = $(this);
    	var body = btn.closest('#modal-change-dates').find('.modal-body');
    	var form = $("#formStep2");

		var overlay = btn.closest('#modal-change-dates').find('.overlay');
		overlay.removeClass("d-none");

		$.ajax({
            url: '/administrator/booking/change-dates/3',
            type: 'POST',
            data: form.serialize(),
            success: function(data){
	          	
	          	overlay.addClass("d-none");  

	        	if(data.error){
	              toastr.error(data.msg);
	              return false;
	            }

	            body.children('#step2').hide();
	            body.children('#step3').html(data).show();
	            btn.hide();
	            //$("#modal-change-dates").find('.button-stepback').removeClass('d-none');
	            $(".btn-paynow").removeClass('d-none');

	            //var total = $("#modal-change-dates").find('input#total').val();
	            //$("#modal-change-dates").find('td#newDetailTotal').html(total);
            },
            error: function (error) {
              overlay.addClass("d-none");
              toastr.error("Some error occured!");
          	}

        });

    }

}
