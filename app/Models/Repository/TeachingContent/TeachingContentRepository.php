<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/6/15
 * Time: 5:04 PM
 */

namespace FutureEd\Models\Repository\TeachingContent;


use FutureEd\Models\Core\TeachingContent;
use League\Flysystem\Exception;

class TeachingContentRepository implements TeachingContentRepositoryInterface{

	public function addTeachingContent($data){

		try{

			return TeachingContent::create($data);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}
}