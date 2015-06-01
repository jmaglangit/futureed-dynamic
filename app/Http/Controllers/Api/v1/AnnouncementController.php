<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Models\Repository\Announcement\AnnouncementRepositoryInterface as Announcement;

class AnnouncementController extends ApiController {

    //holds the announcement repository
	protected $announcement;

	/**
	 * Announcement Controller constructor
	 *
	 * @return void
	 */
	public function __construct(Announcement $announcement) 
	{
		$this->announcement = $announcement;
	}
	
    /**
     *   display announcement.
     *   @return announcement record.
     */
    
    public function index(){
        $announcement =  $this->announcement->getAnnouncement();

        $date_start = Carbon::parse($announcement['date_start']);
        $date_end = Carbon::parse($announcement['date_end']);

        //Determine if the announcement is between current date.
        if(!Carbon::now()->between($date_start,$date_end)){

            return $this->respondWithData([]);
        }

        return $this->respondWithData($announcement);
    }
    
    /**
     *   store announcement.
     *   @return announcement record.
     */
    public function store(){
        $input = Input::only('announcement','date_start','date_end');
        
        $this->addMessageBag($this->validateString($input,'announcement'));
        $this->addMessageBag($this->validateDate($input,'date_start'));
        $this->addMessageBag($this->validateDate($input,'date_end'));
        $this->addMessageBag($this->validateDateRange($input,'date_start','date_end'));
        
        $msg_bag = $this->getMessageBag();
        
        if(!empty($msg_bag)){
            return $this->respondWithError($this->getMessageBag());
        }
        
        $result = $this->announcement->updateAnnouncement($input);
        return $this->respondWithData($result);
    }
}