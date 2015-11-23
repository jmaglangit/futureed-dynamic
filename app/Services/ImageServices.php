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

	/*function will iterate throught the provided array and will output an updated array*/
	public function getIconImageUrl($report){
		foreach($report['rows'] as $row){
			$row->icon_image = $this->getIconImageAttribute($row->icon_image, $row->module_id, 'url');
		}
		
		return $report;
	}

	public function getIconImagePath($report){
		foreach($report['rows'] as $row){
			$row->icon_image = $this->getIconImageAttribute($row->icon_image, $row->module_id, 'path');
		}

		return $report;
	}

	/*This function will get the full path of the icon_image and will concatinate it with the provided icon_image filename*/
	public function getIconImageAttribute($icon_image, $module_id, $type){
		$filesystem = new Filesystem();

		//get path
		$image_path = config('futureed.icon_image_path_final') . '/' . $module_id . '/' . $icon_image;

		//check path
		if($filesystem->exists($image_path)){
			switch ($type) {
				case 'url':
					return asset(url() . config('futureed.icon_image_path_final_public') . '/' . $module_id . '/' . $icon_image);
					break;

				case 'path':
					return config('futureed.icon_image_path_final').'/'.$module_id.'/'.$icon_image;
					break;
			}
		} else {
			return null;
		}

		return $image_path;
	}

}