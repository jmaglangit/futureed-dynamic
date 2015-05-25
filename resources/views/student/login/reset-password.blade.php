@extends('student.app')

@section('content')
  <div class="container login" ng-cloak>
    <div class="col-md-8 col-md-offset-2" ng-show="!success">
      {!! Form::open(array('id' => 'reset_password_form'))!!}
        <div class="form-style form-select-password">
          <div  id="title" class="title">
            <p ng-if="!password_selected">Select a picture for your new picture password</p>
            <p ng-if="password_selected">Select a picture to confirm your new picture password</p>
          </div>
          
          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>
          
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline" ng-init="getImagePassword()">
              <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
                 <img ng-src="{! item.url !}" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
            </ul>

            {!! Form::button('Proceed'
                , array(
                    'class' => 'btn btn-maroon btn-medium'
                    , 'ng-click' => 'selectNewPassword()'
                    , 'ng-if' => '!password_selected'
                ) 
            ) !!}

            <div ng-if="password_selected">
                <div class="btn-container">
                    {!! Form::button('Previous'
                        , array(
                            'class' => 'btn btn-maroon btn-medium'
                            , 'ng-click' => 'undoNewPassword()'
                        ) 
                    ) !!}

                    {!! Form::button('Save'
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => 'studentResetPassword()'
                        ) 
                    ) !!}
                </div>  
            </div>
          </div>
        </div>

        {!! Form::hidden('code', $code, array('ng-model' => 'code')) !!}
        {!! Form::hidden('id', $id, array('ng-model' => 'id')) !!}

      {!! Form::close() !!}
    </div>

    <div class="col-md-6 col-md-offset-3" ng-if="success">
      <div class="form-style form-select-password">
        <div class="title">Success!</div>

          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
          
           Your picture password has been reset. <br /> 
           You may now use your new picture password to login. <br />

           <br />

           {!! Html::link(route('student.login') , 'Click here to Login'
              , array(
                  'class' => 'btn btn-maroon'
              )
           ) !!}
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop