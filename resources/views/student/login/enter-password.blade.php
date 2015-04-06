@extends('student.app')

@section('content')

  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style form-select-password">
        <div class="title">Please Select Your Password</div>
        <div class="error">
          <p>warning style 1</p>
        </div>
        <div class="form_content">
          <ul class="form_password list-unstyled list-inline">
            <li class="item" id="">
              {!! Html::image('images/password-01.png') !!}
            </li>
            <li class="item" id="">
              {!! Html::image('images/password-02.png') !!}
            </li>            
            <li class="item" id="">
              {!! Html::image('images/password-03.png') !!}
            </li>
            <li class="item" id="">
              {!! Html::image('images/password-04.png') !!}
            </li>
            <li class="item" id=""> 
              {!! Html::image('images/password-05.png') !!}
            </li>            
            <li class="item" id="">
              {!! Html::image('images/password-06.png') !!}
            </li>
            <li class="item" id="">
              {!! Html::image('images/password-07.png') !!}
            </li>
            <li class="item" id=""> 
              {!! Html::image('images/password-08.png') !!}
            </li>            
            <li class="item" id="">
              {!! Html::image('images/password-09.png') !!}
            </li> 
            <p><a href="" class="btn btn-red">Submit</a></p>
          </ul>
        </div>

      </div>
    </div>
  </div>
  
@stop

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop