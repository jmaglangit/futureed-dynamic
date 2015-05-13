<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FuturedEd\Models\Repository\Announcement\AnnouncementRepositoryInterface;

class AnnouncementController extends ApiController {

    //holds the announcement repository
	protected $announcement;

	/**
	 * Announcement Controller constructor
	 *
	 * @return void
	 */
	public function __construct(AnnouncementRepositoryInterface $announcement) 
	{
		$this->announcement = $announcement;
	}
	
    public function show(){
        return $this->respondWithData($this->announcement->getAnnouncement());
    }
    
    public function update(){
        //$input = Input::only('announcement','date_start','date_end');
    }
}