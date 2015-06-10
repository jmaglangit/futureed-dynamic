<?php
return array(
    // set your paypal credential
    'client_id' => 'AVBxiG2-aPAAjr4NnVEHzJmWD-PAR05eKbWHOWN9-lX4apSkskyFmx-puktO5zOAgNa2BwAq1r4VZgEY',
    'secret' => 'ENXU9PWyWqRKgl5_lK-AixureTZSqYn2IMrG6W1FvCjmgc1-_MDgbHb2Do-sDxM69ai-90qIXI22xHg9',

    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);