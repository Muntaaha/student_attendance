<?php

include('header.php');

?>

<div class="container" style="margin-top:30px">
  <div class="card">
   <div class="card-header">
      <div class="row">
        <div class="col-md-9">Class List</div>
        <div class="col-md-3" align="right">
          <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
        </div>
      </div>
    </div>
   <div class="card-body">
    <div class="table-responsive">
        <span id="message_operation"></span>
     <table class="table table-striped table-bordered" id="class_table">
      <thead>
       <tr>
        <th>Class Name</th>
        <th>Edit</th>
        <th>Delete</th>
       </tr>
      </thead>
      <tbody>

      </tbody>
     </table>
    </div>
   </div>
  </div>
</div>

</body>
</html>

<div class="modal" id="formModal">
  <div class="modal-dialog">
    <form method="post" id="class_form">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Class Name <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="class_name" id="class_name" class="form-control" />
                <span id="error_class_name" class="text-danger"></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="class_id" id="class_id" />
          <input type="hidden" name="action" id="action" value="Add" />
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
    </form>
  </div>
</div>



<script>
$(document).ready(function(){
	
	var dataTable = $('#class_table').DataTable({
		"processing":true,
		"serveSide":true,
		"order":[],
		"ajax":{
			url:"class_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[0, 1, 2],
				"orderable":false,
			},
		],
		
	});
	
	$('#add_button').click(function(){
    $('#modal_title').text("Add class");
    $('#button_action').val('Add');
    $('#action').val('Add');
    $('#formModal').modal('show');
    clear_field();
  });

  function clear_field()
  {
    $('#class_form')[0].reset();
    $('#error_class_name').text('');
  }

  $('#class_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"class_action.php",
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",
      beforeSend:function()
      {
        $('#button_action').attr('disabled', 'disabled');
        $('#button_action').val('Validate...');
      },
      success:function(data){
        $('#button_action').attr('disabled', false);
        $('#button_action').val($('#action').val());
        if(data.success)
        {
          $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
          clear_field();
          dataTable.ajax.reload();
          $('#formModal').modal('hide');
        }
        if(data.error)
        { 
          if(data.error_class_name != '')
          {
            $('#error_class_name').text(data.error_class_name);
          }
          else
          {
            $('#error_class_name').text('');
          }
        }
      }
    });
  });
});


</script>




