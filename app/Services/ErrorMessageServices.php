<?php

namespace FutureEd\Services;

/**
 * Error Message services for new errors
 * Numbers Correspond to the Key Index of futureed-error.php
 *
 * Class ErrorMessageServices
 * @package FutureEd\Services
 */
class ErrorMessageServices
{
	const   BILLING_INFO_MISSING = 2800;

	//  Subscription request error messages
	const   SUBSCRIPTION_MUST_BE_A_NUMBER   = 2900;
	const   SUBSCRIPTION_NAME_REQUIRED      = 2901;
	const   SUBSCRIPTION_NAME_INVALID       = 2902;
	const   SUBSCRIPTION_LSP_REQUIRED       = 2903;
	const   SUBSCRIPTION_LSP_INVALID        = 2904;
	//  Trial module error messages
	const   TRIAL_MODULE_ANSWER_IS_REQUIRED = 3000;
	const   TRIAL_MODULE_QUAD_PLOTTING_REQUIRED = 3001;
}