<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\AnnouncementRequest;
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
        if(Carbon::today() >= $date_start && Carbon::today() <= $date_end){

            return $this->respondWithData($announcement);
        }

        return $this->respondWithData([]);

    }
    
    /**
     *   store announcement.
     *   @return announcement record.
     */
    public function store(AnnouncementRequest $request){

        $input = $request->only('announcement','date_start','date_end');

        $date_start = Carbon::parse($input['date_start'])->toDateTimeString();
        $date_end = Carbon::parse($input['date_end'])->toDateTimeString();

        if($date_start <= $date_end && $date_end >= $date_start && $date_start >= Carbon::today()){

            $result = $this->announcement->updateAnnouncement($input);
            return $this->respondWithData($result);
        } else {

            return $this->respondErrorMessage(2500);
        }
    }
}