<?php



Routes::resource('/invoice','Api\v1\InvoiceController',
    ['except' => ['create','edit']]);



//for sales invoice
