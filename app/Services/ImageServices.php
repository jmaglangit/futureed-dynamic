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
	 * Updates the image icon full url for each row
	 * @param $report
	 * @return object
	 */
	public function getIconImageUrl($report){
		foreach($report['rows'] as $row){
			$row->icon_image = $this->getIconImageAttribute($row->icon_image, $row->module_id, 'url');
		}
		
		return $report;
	}

	/**
	 * Updates the image icon base path for each row
	 * @param $report
	 * @return object
	 */
	public function getIconImagePath($report){
		foreach($report['rows'] as $row){
			$row->icon_image = $this->getIconImageAttribute($row->icon_image, $row->module_id, 'path');
		}

		return $report;
	}

	/**
	 * Updates and assigns the correct url or base path for the icon image
	 * @param $icon_image
	 * @param $module_id
	 * @param $type
	 * @return string
	 */
	public function getIconImageAttribute($icon_image, $module_id, $type){
		$filesystem = new Filesystem();

		//get path
		if($icon_image != null){
			$image_path = config('futureed.icon_image_path_final') . '/' . $icon_image;
		}
		else{
			$image_path = null;
		}

		//check path
		if($filesystem->exists($image_path)){
			switch ($type) {
				case 'url':
					return asset(url() . config('futureed.icon_image_path_final_public') . '/' . $icon_image);
					break;

				case 'path':
					return config('futureed.icon_image_path_final').'/'.$icon_image;
					break;
			}
		} else {
			return null;
		}

		return $image_path;
	}

	/**
	 * Get background image url.
	 * @param $filename
	 * @return string
	 */
	public function getBackgroundImage($filename){

		return url() .'/'. config('futureed.background_images_folder') .'/'.$filename;
	}

}