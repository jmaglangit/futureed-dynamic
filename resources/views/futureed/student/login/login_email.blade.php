@extends('app')

@section('content')

                        <form class="form-horizontal" role="form" method="POST" action="/student/password">

                            <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value=" ">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        Next
                                    </button>
                                </div>
                            </div>

                        </form>

@endsection
