<?php 
Routes::resource('/client-discount','Api\v1\ClientDiscountController', ['except' => ['edit']]);