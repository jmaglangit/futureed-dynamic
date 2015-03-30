@extends('student.app')

@section('content')
<style>
body {background: url("/images/bg-option-1.jpg") no-repeat scroll right bottom / cover;}
footer{display: none;}
</style>

  <div class="container">
    <div class="col-md-6 col-md-offset-3" style="margin-top:80px;">
      <div class="form-style form-select-password">
        <div class="title">Please Select Your Password</div>
        <div class="error">
          <p>warning style 1</p>
        </div>
        <div class="form_content">
          <ul class="form_password list-unstyled list-inline">
            <li class="item" id="">
              <img src="images/password-01.png" alt="">
            </li>
            <li class="item" id="">
              <img src="images/password-02.png" alt="">
            </li>            
            <li class="item" id="">
              <img src="images/password-03.png" alt="">
            </li>
            <li class="item" id="">
              <img src="images/password-04.png" alt="">
            </li>
            <li class="item" id=""> 
              <img src="images/password-05.png" alt="">
            </li>            
            <li class="item" id="">
              <img src="images/password-06.png" alt="">
            </li>
            <li class="item" id="">
              <img src="images/password-07.png" alt="">
            </li>
            <li class="item" id=""> 
              <img src="images/password-08.png" alt="">
            </li>            
            <li class="item" id="">
              <img src="images/password-09.png" alt="">
            </li> 
            <p><a href="" class="btn btn-red">Submit</a></p>
          </ul>
        </div>

      </div>
    </div>
  </div>
@endsection