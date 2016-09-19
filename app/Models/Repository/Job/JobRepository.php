<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/19/16
 * Time: 2:11 PM
 */

namespace FutureEd\Models\Repository\Job;


use FutureEd\Models\Core\Job;

class JobRepository implements JobRepositoryInterface {

	/**
	 * Get all queue list.
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getQueueList(){

		return Job::all();
	}
}