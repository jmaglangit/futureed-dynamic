@extends('client.app')

@section('content')
  <div class="container login" ng-cloak>

    <div class="col-md-6 col-md-offset-1 form-style">
      {!! Form::open(
          array(
            'id' => 'confirm_email_form'
          )
      )!!}

        <div class="form_content">
          <div class="title">Confirm Email Address</div>

          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
          <div>
            <p class="text">
              Please Login then proceed to My Profile to confirm your new email address.
            </p>
          </div>

          <div class="btn-container">
            <a href="{!! route('client.profile.index') !!}" class="btn btn-blue btn-large"><i class="fa fa-home"></i> Home </a>
          </div>
        </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection

@section('scripts')

@stop