@extends('layout.main')

@section('content')
<div class="jumbotron text-center">
  <h1>Hello Admin!</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div align="right" style="margin-bottom: 10px;">
        <button type="button" class="btn btn-info btn-lg" id="create-new-user">Add Product</button>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Code</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Stock</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $item)
          <tr>
            <td>@</td>
            <td>as</td>
            <td>asd</td>
            <td>asda</td>
            <td>asdadasd</td>
            <td>
              <a href="javascript:void(0)" id="edit-user" data-id="dgf" class="btn btn-info">Edit</a>
              <a href="javascript:void(0)" id="delete-user" data-id="dfg" class="btn btn-danger delete-user">Delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="userCrudModal"></h4>
        </div>
        <div class="modal-body">
            <form id="productForm" name="productForm" class="form-horizontal">
               <input type="hidden" name="user_id" id="user_id">
                <div style="display: grid;">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email">Name:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="Enter Name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Qty:</label>
                  <div class="col-sm-10"> 
                    <input type="number" class="form-control" name="qty" min="0" placeholder="Enter Qty">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Harga:</label>
                  <div class="col-sm-10"> 
                    <input type="number" class="form-control" name="price" min="0" placeholder="Enter Price">
                  </div>
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="create">Save changes
            </button>
        </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /*  When user click add user button */
    $('#create-new-user').click(function () {
        $('#btn-save').val("create-user");
        $('#productForm').trigger("reset");
        $('#userCrudModal').html("Add New User");
        $('#ajax-crud-modal').modal('show');
    });
 
   /* When click edit user */
    $('body').on('click', '#edit-user', function () {
      var user_id = $(this).data('id');
      $.get('ajax-crud/' + user_id +'/edit', function (data) {
         $('#userCrudModal').html("Edit User");
          $('#btn-save').val("edit-user");
          $('#ajax-crud-modal').modal('show');
          $('#user_id').val(data.id);
          $('#name').val(data.name);
          $('#email').val(data.email);
      })
   });
   //delete user login
    $('body').on('click', '.delete-user', function () {
        var user_id = $(this).data("id");
        confirm("Are You sure want to delete !");
 
        $.ajax({
            type: "DELETE",
            url: "{{ url('ajax-crud')}}"+'/'+user_id,
            success: function (data) {
                $("#user_id_" + user_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });   
  });

  $("#btn-save").click(function() {
    // var data = $('#productForm').serialize();
    // console.log(data)
    // alert('oke')
    $.ajax({
          data: $('#productForm').serialize(),
          url: "{{url('/admin')}}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              var user = '<tr id="user_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.email + '</td>';
              user += '<td><a href="javascript:void(0)" id="edit-user" data-id="' + data.id + '" class="btn btn-info">Edit</a></td>';
              user += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + data.id + '" class="btn btn-danger delete-user">Delete</a></td></tr>';
               
              
              if (actionType == "create-user") {
                  $('#users-crud').prepend(user);
              } else {
                  $("#user_id_" + data.id).replaceWith(user);
              }
 
              $('#productForm').trigger("reset");
              $('#ajax-crud-modal').modal('hide');
              $('#btn-save').html('Save Changes');
              
          },
          error: function (data) {
              console.log('Error:', data);
              $('#btn-save').html('Save Changes');
          }
      });
  });
 
//  if ($("#productForm").length > 0) {
//       $("#productForm").validate({
 
//      submitHandler: function(form) {
 
//       var actionType = $('#btn-save').val();
//       $('#btn-save').html('Sending..');
      
//       $.ajax({
//           data: $('#productForm').serialize(),
//           url: "https://www.tutsmake.com/laravel-example/ajax-crud/store",
//           type: "POST",
//           dataType: 'json',
//           success: function (data) {
//               var user = '<tr id="user_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.email + '</td>';
//               user += '<td><a href="javascript:void(0)" id="edit-user" data-id="' + data.id + '" class="btn btn-info">Edit</a></td>';
//               user += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + data.id + '" class="btn btn-danger delete-user">Delete</a></td></tr>';
               
              
//               if (actionType == "create-user") {
//                   $('#users-crud').prepend(user);
//               } else {
//                   $("#user_id_" + data.id).replaceWith(user);
//               }
 
//               $('#productForm').trigger("reset");
//               $('#ajax-crud-modal').modal('hide');
//               $('#btn-save').html('Save Changes');
              
//           },
//           error: function (data) {
//               console.log('Error:', data);
//               $('#btn-save').html('Save Changes');
//           }
//       });
//     }
//   })
// }
   
  
</script>

@endsection