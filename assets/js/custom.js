// add user form validation
$("#form_reg").validate({
	rules: {
		f_name: {
			required: true,
		},
		l_name: {
			required: true,
		},
		email: {
			required: true,
		},
		password: {
			required: true,
		},
		retype_password: {
			required: true,
		},
		address: {
			required: true,
		},
		phone_number: {
			required: true,
		},
		gender: {
			required: true,
		},
		"technology[]": {
			required: true,
		},
		fileToUpload: {
			required: true,
			extension: "jpg|png|jpeg|gif"
		}
	},messages:{
		f_name: {
			required:"Enter user First Name",
		},
		l_name: {
			required:"Enter user Last Name",
		},
		email: {
			required:"Enter user Email ID",
		},
		password: {
			required:"Enter user Password",
		},
		retype_password: {
			required:"Enter user Confirm Password",
		},
		address: {
			required:"Please select City",
		},
		phone_number: {
			required:"Enter user Phone Number",
		},
		gender: {
			required:"Please select Gender",
		},
		"technology[]": {
			required:"Please Checked any technology",
		},
		fileToUpload: {
			required:"Please browse image",
			extension: "Only jpg,jpeg,png,gif file allowed"
		}
	},
	errorPlacement: function(error, element) 
	{
		if ( element.is(":radio") ) 
		{
			error.appendTo( element.parents('.radio_button') );
		}
		else if( element.is(":checkbox") ){
			error.appendTo( element.parents('.check_box') );
		}
		else
		{ 
			error.insertAfter( element );
		}
	}
});
// edit user form validation
$("#form_edit").validate({
	rules: {
		f_name: {
			required: true,
		},
		l_name: {
			required: true,
		},
		email: {
			required: true,
		},
		password: {
			required: true,
		},
		retype_password: {
			required: true,
		},
		address: {
			required: true,
		},
		phone_number: {
			required: true,
		},
		gender: {
			required: true,
		},
		"technology[]": {
			required: true,
		},
		profileimg: {
			required: true,
		}
	},messages:{
		f_name: {
			required:"Enter user First Name",
		},
		l_name: {
			required:"Enter user Last Name",
		},
		email: {
			required:"Enter user Email ID",
		},
		password: {
			required:"Enter user Password",
		},
		retype_password: {
			required:"Enter user Confirm Password",
		},
		address: {
			required:"Please select City",
		},
		phone_number: {
			required:"Enter user Phone Number",
		},
		gender: {
			required:"Please select Gender",
		},
		"technology[]": {
			required:"Please Checked any technology",
		} 
	},
	errorPlacement: function(error, element) 
	{
		if ( element.is(":radio") ) 
		{
			error.appendTo( element.parents('.radio_button') );
		}
		else if( element.is(":checkbox") ){
			error.appendTo( element.parents('.check_box') );
		}
		else
		{ 
			error.insertAfter( element );
		}
	}
});

$("#form_add_technology").validate({
	rules: {
		technology: {
			required: true,
		}
	},messages:{
		technology: {
			required:"Enter Technology Name",
		}
	}
});

$("#form_edit_technology").validate({
	rules: {
		technology: {
			required: true,
		}
	},messages:{
		technology: {
			required:"Enter Technology Name",
		}
	}
});


$(document).ready(function(){	

	$("#user_table").dataTable({
		bSort: false,
		columnDefs: [
            { width: 120, targets: 9 }
        ],
	});
	$("#technology_table").dataTable({
		bSort: false,
	});
	$('select[multiple]').multiselect();
	//quick open image on select image from browse button
	$(document).on('change', '#profile-img', function() {
		readURL(this,1);
	});
	$("#edit_profile-img").change(function(){
		readURL(this,2);
	});

	$('#add_technology_modal').on('hidden.bs.modal', function () { 
		$(this).find('form')[0].reset();
		$(this).validate().resetForm();
		$(".errordata").attr("style", "display:none");
	});

	//remove data from add user form when modal hide
	$('#add_user').on('hidden.bs.modal', function () { 
		$(this).find('form')[0].reset();
		$(this).validate().resetForm();
		$(".errordata").attr("style", "display:none");
		$('#profile-img-tag').removeAttr('src');
		$('.remove_img').remove();
		// $("input[type=checkbox]").prop("checked", false);
		// $(".multiselect").attr("title", "None selected");
		$('#Technology').multiselect('refresh');
	});
	
	//remove data from edit user form when modal hide
	$('#edit_user_modal').on('hidden.bs.modal', function () { 
		$(this).find('form')[0].reset();
		$(this).validate().resetForm();
		$("input[type=radio]").prop("checked", false);
		// $("input[type=checkbox]").prop("checked", false);
		// $('#edit_Technology').multiselect('refresh');
		
	});
	//ajax for toggle button to change status of user
	$(document).on('change', '.change_status', function(e) {
		var id=$(this).attr('data-id');
		if($(this).is(':checked')) {
			var status=1;
		}else{
			var status=0;
		}
		$.ajax({
			type: 'POST',
			url: "../admin/controller/user_manage.php", 
			data:{id:id,status:status,flag:"toggle_button"},
			dataType: "json",
			success: function(data){
				if(data.success==1){
					if(status==1){
						$(this).prop('checked', true);
					}else{
						$(this).prop('checked', false);
					}
				}
			}
		})
	});
// ajax for submit add user form data to database 
$(document).on('submit', '#form_reg', function(e) {
	e.preventDefault();
	if( $("#form_reg").validate()){
		var srno = $('.srno').val();
		var formdata = new FormData($('#form_reg')[0]);
		formdata.append("flag","form_reg_submit");
		$.ajax({
			type: 'POST',
			url: "../admin/controller/user_manage.php", 
			data: formdata,
			contentType: false,
			cache: false,
			processData:false,
			dataType: "json",
			success: function(data){
				console.log(data);
				if(data.success==0){
					// $(".errordata").attr("style", "display:block");
					// $('.errordata').text(data.message);
					$.notify({
						wrapper: 'body',
						message: data.message,
						type: 'error',
						position: 3,
						dir: 'rtl',
						duration: 4000
					});
					return false;
				}
				$('#add_user').modal('hide');
				if(data.success==1){

					if((data.data.status)==1){
						var checked = "checked";
					}else{
						var checked = "";
					}
					var num=parseInt(srno)+1;
					newRow = $('#user_table').dataTable().fnAddData([
						'<label class="checkboxcont"><input type="checkbox" data-id="'+data.data.id+'" class="markall"><span class="checkmark"></span></label>',
						num,
						data.data.fname,
						data.data.lname,
						data.data.email,
						data.data.phonenumber,
						data.data.techname,
						'<img src="../assets/image/'+data.data.image+'"width="100px" height="100px">',
						'<input class="change_status" id="switch" type="checkbox" data-toggle="toggle" data-id="'+data.data.id+'" '+checked+'>',
						'<a href="user_view.php?id='+data.data.id+'"><button class="btn btn-default btn-sm edit_user_modal" data-id="'+data.data.id+'" style="margin-right: 5px; background-color: #FDE671;"><span class="fa fa-eye"></span></button></a><button data-toggle="modal" data-target="#edit_user_modal" class="edit_user_modal btn btn-default btn-sm" data-id="'+data.data.id+'" data-count="'+num+'" style="margin-right: 5px; background-color: #F2AF4A;"><span class="glyphicon glyphicon-pencil"></span></button><button class="delete_user btn btn-default btn-sm" data-id="'+data.data.id+'" style="background-color: #EF534E;"><span class="glyphicon glyphicon-trash"></span></button>'
						]);

					var row = $('#user_table').dataTable().fnGetNodes(newRow);
					$(row).attr('id', data.data.id);
					var oSettings = $('#user_table').dataTable().fnSettings();
					var nTr = oSettings.aoData[ newRow[0] ].nTr;


					$("[data-toggle='toggle']").bootstrapToggle('destroy');                 
					$("[data-toggle='toggle']").bootstrapToggle();
					$('.srno').val(num);
					$.notify({
						wrapper: 'body',
						message: " User Added Successfuly!",
						type: 'success',
						position: 3,
						dir: 'rtl',
						duration: 3500
					});
				}
			}

		})
	}
});
	// ajax for selected data of user in edit form
	$(document).on('click', '.edit_user_modal', function() {
		var id=$(this).attr('data-id');
		var srno=$(this).attr('data-count');
		$.ajax({
			url: "../admin/controller/user_manage.php",
			data:{id:id,flag:"edit_user"},
			dataType: "json",
			type: "POST",
			success: function(data){
				console.log(data);
				if(data.success==1){
					$('#edit_Fname').val(data.data.fname);
					$('#edit_Lname').val(data.data.lname);
					$('#edit_Email').val(data.data.email);
					$('#editid').val(data.data.id);
					$('#edit_srno').val(srno);
					$('#edit_Address option:selected').text(data.data.address);
					$('#edit_Phonenumber').val(data.data.phonenumber);

					$('input[name=gender][value="'+data.data.gender+'"]').prop('checked', true);
					// $("#edit_Technology").val(data.data.technology_id).attr("selected", "selected");
					var technology = data.data.technology_id.split(',');

					$("#edit_Technology").val(technology);
					$("#edit_Technology").multiselect("refresh");
					// // $.each(technology, function (index, value) {
					// 	 $('input[type=checkbox][value="'+value+'"]').prop("checked", true);
					// 	//$("#edit_Technology").prop('selected',true);
					// });
					// $('#edit_Technology').multiselect('refresh');
					$('#edit_profile-img-tag').attr("src","../assets/image/"+data.data.image);
					$('#editimage').attr("value",data.data.image);
				}
			}		
		})
	});
// ajax for submit edit user form to update in database
$(document).on('submit', '#form_edit', function(e) {
	e.preventDefault();
	if( $("#form_reg").validate()){
		var srno = $('#edit_srno').val();
		var table = $('#user_table').DataTable();
		var info = table.page.info();
		var currentpage = info.start;
		$.ajax({
			type: 'POST',
			url: "../admin/controller/user_manage.php", 
			data: new FormData($('#form_edit')[0]),
			contentType: false,
			cache: false,
			processData:false,
			dataType: "json",
			success: function(data){
				console.log(data);
				$('#edit_user_modal').modal('hide');
				if(data.success==1){
					if((data.data.status)==1){
						var checked = "checked";
					}else{
						var checked = "";
					}
					$('#user_table').dataTable().fnDeleteRow($('#'+data.data.id));
					newRow = $('#user_table').dataTable().fnAddData([
						'<label class="checkboxcont"><input type="checkbox" data-id="'+data.data.id+'" class="markall"><span class="checkmark"></span></label>',
						parseInt(srno),
						data.data.fname,
						data.data.lname,
						data.data.email,
						data.data.phonenumber,
						data.data.techname,
						'<img src="../assets/image/'+data.data.image+'"width="100px" height="100px">',
						'<input class="change_status" id="switch" type="checkbox" data-toggle="toggle" data-id="'+data.data.id+'" '+checked+'>',
						'<a href="user_view.php?id='+data.data.id+'"><button class="btn btn-default btn-sm edit_user_modal" data-id="'+data.data.id+'" style="margin-right: 5px; background-color: #FDE671;"><span class="fa fa-eye"></span></button></a><button data-toggle="modal" data-target="#edit_user_modal" class="edit_user_modal btn btn-default btn-sm" data-id="'+data.data.id+'" data-count="'+srno+'" style="margin-right: 5px; background-color: #F2AF4A;"><span class="glyphicon glyphicon-pencil"></span></button><button class="delete_user btn btn-default btn-sm" data-id="'+data.data.id+'" style="background-color: #EF534E;"><span class="glyphicon glyphicon-trash"></span></button>'
						]);
					var row = $('#user_table').dataTable().fnGetNodes(newRow);
					$(row).attr('id', data.data.id);
					var oSettings = $('#user_table').dataTable().fnSettings();
					var nTr = oSettings.aoData[ newRow[0] ].nTr;

					$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
					$("[data-toggle='toggle']").bootstrapToggle();
					$.notify({
						wrapper: 'body',
						message: " User Information Edited Successfuly!",
						type: 'success',
						position: 3,
						dir: 'rtl',
						duration: 3500
					});
				}
			}
		})	
	}
});
// ajax for delete user from database and datatable
$(document).on('click', '.delete_user', function() {
	if (confirm("Are you sure delete_user ?? ")) {
		var id=$(this).attr('data-id');
		var srno=$('.srno').val();
		var table = $("#user_table").DataTable();
		$.ajax({
			url: "../admin/controller/user_manage.php",
			type: "POST", 
			data:{id:id,flag:"delete_user"},
			dataType: "json",
			cache: false,
			success: function(data){
				console.log(data);
				if(data.success==1){
					table.row('#'+id).remove().draw(false);
					$('.srno').val(parseInt(srno)-1);
					$.notify({
						wrapper: 'body',
						message: " User Deleted Successfuly!",
						type: 'success',
						position: 3,
						dir: 'rtl',
						duration: 3500
					});
				}
			}
		})  
	}else{
		return false;
	}             
});

//script for technology page
//ajax for add technology
$(document).on('submit', '#form_add_technology', function(e) {
	e.preventDefault();
	if( $("#form_add_technology").validate()){
		var technology=$('#Technology').val();
		$.ajax({
			type: 'POST',
			url: "../admin/controller/technology_manage.php", 
			data: {technology:technology,flag:"add_technology"},
			dataType: "json",
			success: function(data){
				console.log(data);
				if(data.success==0){
						// $(".errordata").attr("style", "display:block");
						// $('.errordata').text(data.message);
						$.notify({
							wrapper: 'body',
							message: data.message,
							type: 'error',
							position: 3,
							dir: 'rtl',
							duration: 40000
						});
						return false;
					}
					$('#add_technology_modal').modal('hide');
					if(data.success==1){
						newRow = $('#technology_table').dataTable().fnAddData([
							technology,
							'<button data-toggle="modal" data-target="#edit_technology_modal" class="edit_technology_modalclass btn btn-default btn-sm" data-id="'+data.id+'"><span class="glyphicon glyphicon-pencil"></span></button><button class="delete_technology btn btn-default btn-sm" data-id="'+data.id+'"><span class="glyphicon glyphicon-trash"></span></button>'
							]);

						var row = $('#technology_table').dataTable().fnGetNodes(newRow);
						$(row).attr('id', data.id);
						var oSettings = $('#technology_table').dataTable().fnSettings();
						var nTr = oSettings.aoData[ newRow[0] ].nTr;
						$.notify({
							wrapper: 'body',
							message: " Technology Added Successfuly!",
							type: 'success',
							position: 3,
							dir: 'rtl',
							duration: 3500
						});
					}
				}

			})
	}
});
// ajax for selected data of technology in edit form
$(document).on('click', '.edit_technology_modalclass', function() {
	var id=$(this).attr('data-id');
	$.ajax({
		url: "../admin/controller/technology_manage.php",
		data:{id:id,flag:"edit_technology"},
		dataType: "json",
		type: "POST",
		success: function(data){
			// console.log(data);
			if(data.success==1){
				$('#edit_Technology').val(data.data.name);
				$('#edit_id').val(data.data.id);
			}
		}		
	})
});
// ajax for submit edit technology form to update in database
$(document).on('submit', '#form_edit_technology', function(e) {
	e.preventDefault();
	if( $("#form_edit_technology").validate()){
		var technology=$('#edit_Technology').val();
		var id=$("#edit_id").val();
		var table = $('#technology_table').DataTable();
		var info = table.page.info();
		var currentpage = info.start;
		$.ajax({
			type: 'POST',
			url: "../admin/controller/technology_manage.php", 
			data: {id:id,technology:technology,flag:"edit_technology_update"},
			dataType: "json",
			success: function(data){
				console.log(data);
				$('#edit_technology_modal').modal('hide');
				if(data.success==1){
					$('#technology_table').dataTable().fnDeleteRow($('#'+id));
					newRow = $('#technology_table').dataTable().fnAddData([

						technology,
						'<button data-toggle="modal" data-target="#edit_technology_modal" class="edit_technology_modalclass btn btn-default btn-sm" data-id="'+id+'"><span class="glyphicon glyphicon-pencil"></span></button><button class="delete_technology btn btn-default btn-sm" data-id="'+id+'"><span class="glyphicon glyphicon-trash"></span></button>'
						]);
					var row = $('#technology_table').dataTable().fnGetNodes(newRow);
					$(row).attr('id', id);
					var oSettings = $('#technology_table').dataTable().fnSettings();
					var nTr = oSettings.aoData[ newRow[0] ].nTr;
					$.notify({
						wrapper: 'body',
						message: " Technology Edited Successfuly!",
						type: 'success',
						position: 3,
						dir: 'rtl',
						duration: 3500
					});
				}
			}
		})	
	}
});
// ajax for delete technology from database and datatable
$(document).on('click', '.delete_technology', function() {
	if (confirm("Are you sure delete_technology ?? ")) {
		var id=$(this).attr('data-id');
		var table = $("#technology_table").DataTable();
		$.ajax({
			url: "../admin/controller/technology_manage.php",
			type: "POST", 
			data:{id:id,flag:"delete_technology"},
			dataType: "json",
			cache: false,
			success: function(data){
				console.log(data);
				if(data.success==1){
					table.row('#'+id).remove().draw(false);
					$.notify({
						wrapper: 'body',
						message: " Technology Deleted Successfuly!",
						type: 'success',
						position: 3,
						dir: 'rtl',
						duration: 3500
					});
				}
			}
		})  
	}else{
		return false;
	}             
});
 // Multiple images preview in browser
 var imagesPreview = function(input, placeToInsertImagePreview) {
 	if (input.files) {
 		var filesAmount = input.files.length;
 		var formdata = new FormData($('#form_reg')[0]);
 		formdata.append("flag","multi_image");
 		$.ajax({
 			type: 'POST',
 			url: "../admin/controller/user_manage.php", 
 			data: formdata,
 			contentType: false,
 			cache: false,
 			processData:false,
 			dataType: "json",
 			success: function(data){
 				console.log(data);
 				if(data.success==1){
 					var image=$("#multiple_img").val();
 					$("#multiple_img").val(image+','+data.data);
 					var html= "";
 					$.each(data.data , function(index, val) {
 						var image_ext = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
 						var xle_ext = ['xls', 'csv', 'xlsx'];
 						if ($.inArray(val.split('.').pop().toLowerCase(), image_ext) == -1) {
 							if($.inArray(val.split('.').pop().toLowerCase(), xle_ext) == -1){
 								if(val.split('.').pop().toLowerCase()=="docx"){
 									html +='<span class="remove_img"><img width="70px" height="60px" class="multi-select-img" name="multiselectimg[]" style="margin-top: 10px;" src="../assets/image2/doc.png" title="'+val+'"><span data-name="'+val+'" class="remove_img_preview"></span></span>';
 								}else if(val.split('.').pop().toLowerCase()=="pdf"){
 									html +='<span class="remove_img"><img width="70px" height="60px" class="multi-select-img" name="multiselectimg[]" style="margin-top: 10px;" src="../assets/image2/pdf.png" title="'+val+'"><span data-name="'+val+'" class="remove_img_preview"></span></span>';

 								}else{
 									html +='<span class="remove_img"><img width="70px" height="60px" class="multi-select-img" name="multiselectimg[]" style="margin-top: 10px;" src="../assets/image2/file.jpg" title="'+val+'"><span data-name="'+val+'" class="remove_img_preview"></span></span>';
 								}
 							}else{
 								html +='<span class="remove_img"><img width="70px" height="60px" class="multi-select-img" name="multiselectimg[]" style="margin-top: 10px;" src="../assets/image2/axcel.png" title="'+val+'"><span data-name="'+val+'" class="remove_img_preview"></span></span>';
 							}
 						}else{

 							html +='<span class="remove_img"><img width="90px" height="50px" class="multi-select-img" name="multiselectimg[]" style="margin-top: 10px;" src="../assets/image2/'+val+'"><span data-name="'+val+'" class="remove_img_preview"></span></span>';
 						}
 					});
 					$( ".gallery" ).append(html);
 				}
 			}
 		})
 	}
 };
 $('#gallery-photo-add').on('change', function() {
 	imagesPreview(this, 'div.gallery');
 });
 $('.gallery').on('click', '.remove_img_preview',function () {
 	var image=$(this).attr("data-name");
 	var image_data= image+',';
 	$(this).parent('span').remove();
 	var data=$("#multiple_img").val();
 	var response = data.replace(image_data,"");
 	if(data==response){
 		response = data.replace(image,"");
 	}
 	$("#multiple_img").val(response);

 });
//import data from uploaded csv file
$(document).on('submit', '#form_import_user', function(e) {
	e.preventDefault();
	var srno = $('.srno').val();
	var formdata = new FormData($('#form_import_user')[0]);
	formdata.append("flag","form_import_user");
	$.ajax({
		type: 'POST',
		url: "../admin/controller/user_manage.php", 
		data: formdata,
		contentType: false,
		cache: false,
		processData:false,
		dataType: "json",
		success: function(data){
			console.log(data);
			if(data.success==0){
				$.notify({
					wrapper: 'body',
					message: data.message,
					type: 'error',
					position: 3,
					dir: 'rtl',
					duration: 4000
				});
				return false;
			}
			$('#import_user_modal').modal('hide');
			if(data.success==1){
				window.location="users.php";
			}
		}
	});

});
// select all user
$(document).on('click', '.select_all_box', function() {
	if($(this).is(':checked')){
		$('.markall').prop('checked', true);
	}else{
		$('.markall').prop('checked', false);
	}
});

// delete selected user from database and datable
$(document).on('click', '.multidelete', function() {
	var srno = $('.srno').val();
	var selected = new Array();
	$(".markall").each(function(){
		if($(this).is(':checked')){
			selected.push($(this).attr('data-id'));
		}
	});
	var len=selected.length;
	srno=srno-len;
	if(selected==""){
		$.notify({
			wrapper: 'body',
			message: " Please select Users!",
			type: 'error',
			position: 3,
			dir: 'rtl',
			duration: 3500
		});
	}else{
		if (confirm("Are you sure delete selected user ?? ")) {
			var table = $("#user_table").DataTable();
			$.ajax({
				url: "../admin/controller/user_manage.php",
				type: "POST", 
				data:{id:selected,flag:"delete_selected_user"},
				dataType: "json",
				cache: false,
				success: function(data){
					console.log(data);
					if(data.success==1){
						$.each(selected , function(index, val) {
							table.row('#'+val).remove().draw(false);
						});
						$('.srno').val(srno);
						$.notify({
							wrapper: 'body',
							message: " User Deleted Successfuly!",
							type: 'success',
							position: 3,
							dir: 'rtl',
							duration: 3500
						});
					}
				}
			}) 
		}else{
			return false;
		} 
	} 

});
//filter technology 
$(document).on('click', '.apply_filter', function() {
	var filter_tech=$('#Filter_Technology option:selected').val();
	var filter_gender=$('#Filter_Gender option:selected').val();

	var table = $("#user_table").DataTable();
	var num=1;
	$.ajax({
		url: "../admin/controller/user_manage.php",
		type: "POST", 
		data:{id:filter_tech,gender:filter_gender,flag:"filter"},
		dataType: "json",
		cache: false,
		success: function(data){
			// console.log(data);
			if(data.success==1){
				table.clear().draw();
				$.each(data.data , function(index, val) {
					if((val.status)==1){
						var checked = "checked";
					}else{
						var checked = "";
					}
					newRow = $('#user_table').dataTable().fnAddData([
						'<label class="checkboxcont"><input type="checkbox" data-id="'+val.id+'" class="markall"><span class="checkmark"></span></label>',
						num,
						val.fname,
						val.lname,
						val.email,
						val.phonenumber,
						val.techname,
						'<img src="../assets/image/'+val.image+'"width="100px" height="100px">',
						'<input class="change_status" id="switch" type="checkbox" data-toggle="toggle" data-id="'+val.id+'" '+checked+'>',
						'<a href="user_view.php?id='+val.id+'"><button class="btn btn-default btn-sm edit_user_modal" data-id="'+val.id+'" style="margin-right: 5px; background-color: #FDE671;"><span class="fa fa-eye"></span></button></a><button data-toggle="modal" data-target="#edit_user_modal" class="edit_user_modal btn btn-default btn-sm" data-id="'+val.id+'" data-count="'+num+'" style="margin-right: 10px; background-color: #F2AF4A;"><span class="glyphicon glyphicon-pencil"></span></button><button class="delete_user btn btn-default btn-sm" data-id="'+val.id+'" style="background-color: #EF534E;"><span class="glyphicon glyphicon-trash"></span></button>'
						]);

					var row = $('#user_table').dataTable().fnGetNodes(newRow);
					$(row).attr('id', val.id);
					var oSettings = $('#user_table').dataTable().fnSettings();
					var nTr = oSettings.aoData[ newRow[0] ].nTr;
					num++;
				});
				$("[data-toggle='toggle']").bootstrapToggle('destroy');                 
				$("[data-toggle='toggle']").bootstrapToggle();
			}
		}
	})             
});
//Clear filter
$(document).on('click', '.clear_filter', function() {
	var filter_tech="";
	var table = $("#user_table").DataTable();
	var num=1;
	$.ajax({
		url: "../admin/controller/user_manage.php",
		type: "POST", 
		data:{id:filter_tech,flag:"filter"},
		dataType: "json",
		cache: false,
		success: function(data){
			 // console.log(data);
			 if(data.success==1){
			 	table.clear().draw();
			 	$.each(data.data , function(index, val) {
			 		if((val.status)==1){
			 			var checked = "checked";
			 		}else{
			 			var checked = "";
			 		}
			 		newRow = $('#user_table').dataTable().fnAddData([
			 			'<label class="checkboxcont"><input type="checkbox" data-id="'+val.id+'" class="markall"><span class="checkmark"></span></label>',
			 			num,
			 			val.fname,
			 			val.lname,
			 			val.email,
			 			val.phonenumber,
			 			val.techname,
			 			'<img src="../assets/image/'+val.image+'"width="100px" height="100px">',
			 			'<input class="change_status" id="switch" type="checkbox" data-toggle="toggle" data-id="'+val.id+'" '+checked+'>',
			 			'<button data-toggle="modal" data-target="#edit_user_modal" class="edit_user_modal btn btn-default btn-sm" data-id="'+val.id+'" data-count="'+num+'" style="margin-right: 10px; background-color: #F2AF4A;"><span class="glyphicon glyphicon-pencil"></span></button><button class="delete_user btn btn-default btn-sm" data-id="'+val.id+'" style="background-color: #EF534E;"><span class="glyphicon glyphicon-trash"></span></button>'
			 			]);

			 		var row = $('#user_table').dataTable().fnGetNodes(newRow);
			 		$(row).attr('id', val.id);
			 		var oSettings = $('#user_table').dataTable().fnSettings();
			 		var nTr = oSettings.aoData[ newRow[0] ].nTr;
			 		num++;
			 	});
			 	$("[data-toggle='toggle']").bootstrapToggle('destroy');                 
			 	$("[data-toggle='toggle']").bootstrapToggle();
			 	$('#Filter_Technology option:selected').prop('selected', false);
			 	$('#Filter_Gender option:selected').prop('selected', false);
			 }
			}
		})             
});

$(document).on('submit', '#add__tech', function(e) {
	e.preventDefault();
		var technology=$('#tech_name').val();
		$.ajax({
			type: 'POST',
			url: "../admin/controller/add_tech.php", 
			data: {technology:technology,flag:"add_technology"},
			dataType: "json",
			success: function(data){
				console.log(data);
				if(data.success==0){
						// $(".errordata").attr("style", "display:block");
						// $('.errordata').text(data.message);
						$.notify({
							wrapper: 'body',
							message: data.message,
							type: 'error',
							position: 3,
							dir: 'rtl',
							duration: 4000
						});
						return false;
					}
					$('#addtechno').modal('hide');
					if(data.success==1){
						$("#Filter_Technology").append('<option value='+data.id+'>'+technology+'</option>');
						$.notify({
							wrapper: 'body',
							message: " Technology Added Successfuly!",
							type: 'success',
							position: 3,
							dir: 'rtl',
							duration: 3500
						});
					}
				}

			})
});



});


function readURL(input,flag) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			if(flag==1){
				$('#profile-img-tag').attr('src', e.target.result);
				$(".errordata").attr("style", "display:none");
			}else{
				$('#edit_profile-img-tag').attr('src', e.target.result);
			}
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function confirmation(){
	if (confirm("Are you sure create csv file of users ?? ")) {
		return true;
	}else{
		return false;
	}
}


