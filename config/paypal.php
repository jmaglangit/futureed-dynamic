<?php
return array(
    // set your paypal credential default is the test.
    'client_id' => env('PAYPAL_CLIENT_ID','AVBxiG2-aPAAjr4NnVEHzJmWD-PAR05eKbWHOWN9-lX4apSkskyFmx-puktO5zOAgNa2BwAq1r4VZgEY'),
    'secret' => env('PAYPAL_SECRET','ENXU9PWyWqRKgl5_lK-AixureTZSqYn2IMrG6W1FvCjmgc1-_MDgbHb2Do-sDxM69ai-90qIXI22xHg9'),

    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => env('PAYPAL_MODE','sandbox'),

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => env('PAYPAL_CONNECTION_TIMEOUT',30),

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => env('PAYPAL_LOG_ENABLED',true),

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . env('PAYPAL_FILENAME','/logs/paypal.log'),

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => env('PAYPAL_LOG_LEVEL','FINE')
    ),

    /**
     * Paypal response strings
     */
    'approved' => 'approved',
);