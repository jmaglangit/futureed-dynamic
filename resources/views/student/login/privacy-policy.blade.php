<div id="policy_modal" ng-show="show_policy" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h3>{!! trans('messages.pp_msg') !!}</h3>
        </div>
        <div class="modal-body">
            <content class="form-content">
                {!! Form::open(
                    array(
                        'id' => 'terms_modal'
                        , 'class' => 'form-horizontal'
                    )
                )!!}
                    <fieldset>
                        <legend>{!! trans('messages.pp_msg2') !!}</legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg3') !!}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend> {!! trans('messages.pp_msg4') !!} </legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg5') !!}
                            </p>
                            <div class="list-container">
                                <ul class="list-content">
                                    <li>
                                        {!! trans('messages.pp_msg6') !!}
                                    </li>
                                    <li>
                                        {!! trans('messages.pp_msg7') !!}
                                    </li>
                                    <li>
                                        {!! trans('messages.pp_msg8') !!}
                                    </li>
                                    <li>
                                        {!! trans('messages.pp_msg9') !!}
                                    </li>
                                    <li>
                                        {!! trans('messages.pp_msg10') !!}
                                    </li>
                                    <li>
                                        {!! trans('messages.pp_msg11') !!}
                                    </li>
                                    <li>
                                        {!! trans('messages.pp_msg12') !!}
                                    </li>
                                    <li>
                                        {!! trans('messages.pp_msg13') !!}
                                    </li>
                                    <li>
                                        {!! trans('messages.pp_msg14') !!}
                                    </li>
                                </ul>
                            </div>
                            <p>
                                {!! trans('messages.pp_msg15') !!}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>{!! trans('messages.pp_msg16') !!}</legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg17') !!}
                            </p>
                            <p>
                                {!! trans('messages.pp_msg18') !!}
                            </p>
                            <p>
                                {!! trans('messages.pp_msg19') !!}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>{!! trans('messages.pp_msg20') !!}</legend>
                        <div>
                           <p>
                               {!! trans('messages.pp_msg21') !!}
                           </p>
                           <p>
                               {!! trans('messages.pp_msg22') !!}
                           </p>
                           <p>
                               {!! trans('messages.pp_msg23') !!}
                           </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>{!! trans('messages.pp_msg24') !!}</legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg25') !!}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>{!! trans('messages.pp_msg26') !!}</legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg27') !!}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>{!! trans('messages.pp_msg28') !!}</legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg29') !!}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>{!! trans('messages.pp_msg30') !!}</legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg31') !!}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>{!! trans('messages.pp_msg32') !!}</legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg33') !!}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend> {!! trans('messages.pp_msg34') !!} </legend>
                        <div>
                            <p>
                                {!! trans('messages.pp_msg35') !!}
                            </p>
                        </div>
                    </fieldset>

                     <fieldset>
                        <div>
                            <p>Futurelesson.com c/o</p>
                            <p>{! futureed.BILL_COMPANY !}</p>
                            <p>{! futureed.BILL_STREET !}</p>
                            <p>{! futureed.BILL_ADDRESS !}, {! futureed.BILL_COUNTRY !}</p>
                            <p>{!! trans('messages.email') !!}: <span>i n f o @ f u t u r e l e s s o n . c o m</span></p>
                        </div>
                    </fieldset>
                {!! Form::close() !!}
            </content>
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button(trans('messages.close')
                    , array(
                        'class' => 'btn btn-gold btn-medium'
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}
        	</div>
        </div>
    </div>
  </div>
</div>