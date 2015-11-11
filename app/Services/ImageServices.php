<?php
/**
 * Created by ejingco
 * 
 * This is a reusable serivce that will concatinate the full URL path + image file name
 *
 * Currently being used in the Current Learning tab of the reports section of Student
 *  
 */

namespace FutureEd\Services;
use Illuminate\Filesystem\Filesystem;

class ImageServices {

	/**
	 * Constructors
	 */
	
	public function __construct(){
		// $this->avatar = $avatar;
		// $this->validator=$validator;
		// $this->student = $student;
	}

	/*function will iterate throught the provided array and will output an updated array*/
	public function getIconImageUrl($current_learning){
		foreach($current_learning as $row){
			$row->icon_image = $this->getIconImageAttribute($row->icon_image, $row->module_id);
		}
		
		return $current_learning;
	}

	/*This function will get the full path of the icon_image and will concatinate it with the provided icon_image filename*/
	public function getIconImageAttribute($icon_image, $module_id){
		$filesystem = new Filesystem();

		//get path
		$image_path = config('futureed.icon_image_path_final') . '/' . $module_id . '/' . $icon_image;

		//check path
		if($filesystem->exists($image_path)){
			return asset(url() . config('futureed.icon_image_path_final_public') . '/' . $module_id . '/' . $icon_image);
		} else {

			return 'None';
		}


		return $image_path;
	}

}