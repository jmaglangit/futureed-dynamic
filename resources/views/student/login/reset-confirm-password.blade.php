@extends('student.app')

@section('content')
  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style form-select-password clearfix">
        <div class="title">Select a picture to confirm your new password</div>
        <div class="error">
          <p>warning style 1</p>
        </div>
        <div class="form_content">
          <ul class="form_password list-unstyled list-inline">
            <li class="item" id="">
              <img src="/images/password-01.png" alt="">
            </li>
            <li class="item" id="">
              <img src="/images/password-02.png" alt="">
            </li>            
            <li class="item" id="">
              <img src="/images/password-03.png" alt="">
            </li>
            <li class="item" id="">
              <img src="/images/password-04.png" alt="">
            </li>
            <li class="item" id=""> 
              <img src="/images/password-05.png" alt="">
            </li>            
            <li class="item" id="">
              <img src="/images/password-06.png" alt="">
            </li>
            <li class="item" id="">
              <img src="/images/password-07.png" alt="">
            </li>
            <li class="item" id=""> 
              <img src="/images/password-08.png" alt="">
            </li>            
            <li class="item" id="">
              <img src="/images/password-09.png" alt="">
            </li>
            <div class="row">
              <div class="col-sm-6"><a href="" class="btn btn-red">Previous</a></div>
              <div class="col-sm-6"><a href="" class="btn btn-red">Reset</a></div>
            </div>
          </ul>
        </div>

      </div>
    </div>
  </div>
@endsection