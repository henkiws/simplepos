@extends('layout.main')

@section('content')
<div class="jumbotron text-center">
  <h1>Hello Kasir!</h1>
  <p>
    <a href="logout"> Logout</a>
  </p>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-6">
      <form id="formKasir">
          <div style="display: grid;">
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Produck Name:</label>
          <div class="col-sm-10">
            <select class="form-control" name="name" id="name">
              <option disabled selected>- Please Select -</option>
              @foreach($data as $item)
              <option value="{{ $item->id }}, {{ $item->product_name }}, {{ $item['price']->publish_price }}">{{ $item->product_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Qty:</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" name="qty" id="qty" placeholder="Enter Qty">
          </div>
        </div>
          </div>
      </form>
    </div>
    <div class="col-sm-6">
      <button class="btn btn-default" id="btn_input">Input</button>
      <button class="btn btn-default" id="btn_reset">Reset</button>
    </div>
  </div>
  <label>Items</label>
  <table class="table table-bordered" id="items">
    <thead>
      <tr>
        <th>Id</th>
        <th>Product Name</th>
        <th>Qty</th>
        <th>Total</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="tbodyid">
    </tbody>
  </table>

  <button class="btn btn-primary" id="btn_bayar" style="display:none">Bayar!</button>

</div>

<script>
    $(document).ready(function () {
  
      var id
  
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
      });
    
    $("#btn_reset").click(function(){
      localStorage.clear();
      $("#tbodyid").empty();
      $('#btn_bayar').hide();
    })
  
    $("#btn_input").click(function() {
        $.ajax({
            data: $('#formKasir').serialize(),
            url: "{{url('kasir/list')}}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                // console.log('data ',data)
                var cart;
                if (!localStorage['cart']) cart = [];
                else cart = JSON.parse(localStorage['cart']);            
                if (!(cart instanceof Array)) cart = [];
                cart.push(data);
                localStorage.setItem('cart', JSON.stringify(cart));

                var temp = JSON.parse(localStorage.getItem('cart')); 
                console.log(temp)
                $("#tbodyid").empty();
                var trHTML = '';
                $.each(temp, function (key,value) {
                  trHTML += 
                      '<tr><td>' + value.product_id + 
                      '</td><td>' + value.customer_name + 
                      '</td><td>' + value.order_qty +
                      '</td><td>' + value.order_price_total + 
                      '</td><td> <a href="javascript:void(0)" id="delete-item" data-id="' + value.product_id + '" class="btn btn-danger delete-user">Delete</a>' + 
                      '</td></tr>';     
                });
                $('#items').append(trHTML)
                $('#btn_bayar').show();
            },
            error: function (data) {
                console.log('Error:', data);
                $('#btn-save').html('Save Changes');
            }
        });
      
    });

    $("#btn_bayar").click(function(){
      var senddd = localStorage.getItem('cart'); 
      jQuery.post("{{url('kasir/store')}}", {data: senddd}, function(data){
          // alert(data);
          // console.log(data)
          alert(data.status)
        }).fail(function(){
          alert("Error");
        });
       
    })

  });
    
  </script>

@endsection