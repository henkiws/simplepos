@extends('layout.main')
@section('css')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container" >
    <div class="row">
        <div class="col-sm-4">
            <p class="text-center">Silahkan login</p>
            <form action="auth" method="POST">
                @csrf
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="password">
              </div>
              <div class="form-group">
                <label for="pwd">Login As:</label>
                <select name="loginas" class="form-control">
                    <option disabled selected>- Please Select -</option>
                    <option value="admin">Administrator</option>
                    <option value="kasir">Kasir</option>
                </select>
              </div>
              <button type="submit" class="btn btn-default">Login</button>
            </form>
        </div>
    </div>
</div>  
@endsection