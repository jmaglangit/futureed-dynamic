<?php 
Routes::resource('/subscription','Api\v1\SubscriptionController', ['except' => ['create','edit']]);