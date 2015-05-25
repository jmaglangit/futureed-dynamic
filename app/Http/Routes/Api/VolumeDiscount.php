<?php 
Routes::resource('/volume-discount','Api\v1\VolumeDiscountController', ['except' => ['create','edit']]);
