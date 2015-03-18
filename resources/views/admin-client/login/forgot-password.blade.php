@extends('app')

@section('content')
<style>
body {background: url("images/bcg_bookapple.jpg") no-repeat scroll right bottom / cover;}
footer{display: none;}
</style>

  <div class="container">
    <div class="col-md-4 col-md-offset-1" style="margin-top:80px;">
      <div class="form-style form-narrow">
        <div class="title">Retrieve Password</div>
        <form action="">
          <!-- <span>Email or Username</span> -->
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <input placeholder="Email or Username" type="email" name="" id="">
          </div>
          <div class="submit">SEND</div>
        </form>
      </div>
    </div>
  </div>
@endsection