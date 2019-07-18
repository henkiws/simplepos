@extends('layout.main')

@section('content')
<div class="jumbotron text-center">
  <h1>Hello Admin!</h1>
  <p>
    <a href="logout"> Logout</a>
  </p> 
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div align="right" style="margin-bottom: 10px;">
        <button type="button" class="btn btn-info btn-lg" id="create-new-product">Add Product</button>
      </div>
      <table class="table table-bordered" id="items">
        <thead>
          <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="tbodyid">
          @foreach($data as $item)
          <tr id="item_id_{{ $item->id }}">
            <td>{{ $item->product_code }}</td>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item['price']->currency }} {{ $item['price']->publish_price }}</td>
            <td>{{ $item->stock }}</td>
            <td>
            <a href="javascript:void(0)" id="edit-item" data-id="{{ $item->id }}" class="btn btn-info">Edit</a>
              <a href="javascript:void(0)" id="delete-item" data-id="{{ $item->id }}" class="btn btn-danger delete-user">Delete</a>
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
            <h4 class="modal-title" id="titleModal"></h4>
        </div>
        <div class="modal-body">
            <form id="productForm" name="productForm" class="form-horizontal">
               <input type="hidden" name="user_id" id="user_id">
                <div style="display: grid;">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email">Name:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Stock:</label>
                  <div class="col-sm-10"> 
                    <input type="number" class="form-control" name="stock" id="stock" min="0" placeholder="Enter Stock">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Purchase Price:</label>
                  <div class="col-sm-10"> 
                    <input type="number" class="form-control" name="purchase" id="purchase" min="0" placeholder="Enter Purchase Price">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Selling Price:</label>
                  <div class="col-sm-10"> 
                    <input type="number" class="form-control" name="selling" id="selling" min="0" placeholder="Enter Selling Price">
                  </div>
                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="create">Save changes</button>
        </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {

    var id

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $('#create-new-product').click(function () {
        $('#btn-save').val("create");
        $('#productForm').trigger("reset");
        $('#titleModal').html("Add New Product");
        $('#ajax-crud-modal').modal('show');
    });
 
    $('body').on('click', '#delete-item', function () {
        var product_id = $( this ).attr( "data-id" )
        confirm("Are You sure want to delete !");
 
        $.ajax({
            type: "DELETE",
            url: "{{ url('admin')}}"+'/'+product_id,
            success: function (data) {
                $("#item_id_" + product_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });   
  });

    $('body').on('click', '#edit-item', function () {
    id = $( this ).attr( "data-id" )
    $.ajax({
        type: "GET",
        url: "{{ url('admin')}}"+'/'+id,
        success: function (data) {
          $('#titleModal').html("Edit Product");
          $('#btn-save').val("edit");
          $('#ajax-crud-modal').modal('show');
          $('#name').val(data.product_name);
          $('#purchase').val(data['price'].original_price);
          $('#stock').val(data.stock);
          $('#selling').val(data['price'].publish_price);
          console.log(data)
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
  });

  $("#btn-save").click(function() {
    var actionType = $('#btn-save').val();
    if(actionType == "create"){
      $.ajax({
          data: $('#productForm').serialize(),
          url: "{{url('/admin')}}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            $("#tbodyid").empty();
              var trHTML = '';
              $.each(data, function (key,value) {
                trHTML += 
                    '<tr><td>' + value.product_code + 
                    '</td><td>' + value.product_name + 
                    '</td><td>' + value['price'].currency +' '+ value['price'].publish_price +
                    '</td><td>' + value.stock + 
                    '</td><td> <a href="javascript:void(0)" id="edit-item" data-id="' + value.id + '" class="btn btn-info">Edit</a><a href="javascript:void(0)" id="delete-item" data-id="' + value.id + '" class="btn btn-danger delete-user">Delete</a>' + 
                    '</td></tr>';     
              });
              $('#items').append(trHTML); 
              $('#productForm').trigger("reset");
              $('#ajax-crud-modal').modal('hide');
              $('#btn-save').html('Save Changes');
          },
          error: function (data) {
              console.log('Error:', data);
              $('#btn-save').html('Save Changes');
          }
      });
    }else{
      console.log('haloo ', id)
      $.ajax({
          data: $('#productForm').serialize(),
          url: "{{url('admin')}}/"+id,
          type: "PUT",
          dataType: 'json',
          success: function (data) {
              var trHTML = '';
                trHTML += 
                    '<tr><td>' + data.product_code + 
                    '</td><td>' + data.product_name + 
                    '</td><td>' + data['price'].currency +' '+ data['price'].publish_price +
                    '</td><td>' + data.stock + 
                    '</td><td> <a href="javascript:void(0)" id="edit-item" data-id="' + data.id + '" class="btn btn-info">Edit</a><a href="javascript:void(0)" id="delete-item" data-id="' + data.id + '" class="btn btn-danger delete-user">Delete</a>' + 
                    '</td></tr>';     
              $('#item_id_'+id).replaceWith(trHTML); 
              $('#productForm').trigger("reset");
              $('#ajax-crud-modal').modal('hide');
              $('#btn-save').html('Save Changes');
          },
          error: function (data) {
              console.log('Error:', data);
              $('#btn-save').html('Save Changes');
          }
      });
    }
    
  });
  
</script>

@endsection