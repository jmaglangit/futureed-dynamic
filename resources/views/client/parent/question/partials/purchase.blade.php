<div class="col-xs-12 search-container" ng-if="question.purchase">
    <div class="col-xs-12 btn-content margin-10-bot">
            <center>
                <h2 class="title-content">
                    You have reached the end of the trial questions. Please subscribe if you want to continue using Future Lesson!
                </h2>

                <a class="dashboard-content-btn" href="{{ route('client.parent.payment.index') }}">
                    <button class="subscribe-button" type="button">
                        Subscribe Now
                    </button>
                </a>
            </center>
    </div>

</div>