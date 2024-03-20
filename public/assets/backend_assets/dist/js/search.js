var Search = {
	init: function () {
        
        var selectedRole = $("select[name='role'] option:selected").val();
		if(selectedRole!=="")
			this.fetchUsers();
		
		$("select[name='role']").on("change", this.fetchUsers);
		$("select[name='select_brand']").on("change", this.fetchAirports);
        
	},

	fetchUsers: function () {
		var overlay = $(this).closest('.card-header').find('.overlay-wrapper');
		var role = $("select[name='role'] option:selected").val();
		var url = $("select[name='role'] option:selected").attr("data-url");

      	//$("select[name='brand']").find("option").not(":first").remove();
      	$("#appendUsers").find("option").not(":first").remove();
      	
      	if(!role)
      		return false;
      	
		overlay.removeClass("d-none");

      	$.ajax({
	        url: url,
	        type:'get',
	        dataType:'json',
	        success:function (response) {
	        	overlay.addClass("d-none");
				var len=0;
	            if (response.data != null) {
	                len = response.data.length;
	            }

	            if (len>0) {
	                for (var i = 0; i<len; i++) {
	                     var id = response.data[i].id;
	                     var name = response.data[i].name;

	                     var option = "<option value='"+id+"'>"+name+"</option>"; 

	                     //$("select[name='brand']").append(option);
	                     $("#appendUsers").append(option);
	                }
	            }
	        }
	    });
	},

	fetchAirports: function () {
		var overlay = $(this).closest('.card-header').find('.overlay-wrapper');
		overlay.removeClass("d-none");

		var brandID = $(this).val();
      	$("select[name='select_airport']").find("option").not(":first").remove();

		$.ajax({
	        url: '/administrator/brand/'+brandID+'/airports',
	        type:'get',
	        dataType:'json',
	        success:function (response) { console.log(response.data);
	        	overlay.addClass("d-none");
				var len = 0;
	            if (response.data != null) {
	                len = response.data.length;
	            }

	            if (len>0) {
	                for (var i = 0; i<len; i++) {
	                     var id = response.data[i].id;
						 var name = response.data[i].name;

	                     var option = "<option value='"+id+"'>"+name+"</option>"; 

	                     $("select[name='select_airport']").append(option);
	                }
	            }
	        }
	    });
	}
    
    
}