@extends('student.app')

@section('content')
<style>
body {background: url("/images/bg-option-1.jpg") no-repeat scroll right bottom / cover;}
footer{display: none;}
</style>

  <div class="container">
    <div class="col-md-6 col-md-offset-3" style="margin-top:80px;">
      <div class="form-style">
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