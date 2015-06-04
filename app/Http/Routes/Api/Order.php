<?php 
Routes::resource('/order','Api\v1\OrderController', ['except' => ['edit']]);