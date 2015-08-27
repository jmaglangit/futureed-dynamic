<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\StudentTipRatingRequest;
use FutureEd\Models\Repository\TipRating\TipRatingRepositoryInterface;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;

use Illuminate\Http\Request;

class StudentTipRatingController extends ApiController {

	protected $tip_rating;
	protected $tip;

	public function __construct(TipRatingRepositoryInterface $tip_rating,TipRepositoryInterface $tip ){

		$this->tip_rating = $tip_rating;
		$this->tip = $tip;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StudentTipRatingRequest $request)
	{
		$data = $request->only('tip_id','student_id','rating');
		$tip = [];
		$average = NULL;

		$tip_rating = $this->tip_rating->addTipRating($data);

		$average = $this->tip_rating->getAverageRating($data['tip_id']);

		$tip['rating'] = $average;

		//update rating on tips table
		$this->tip->updateTip($data['tip_id'],$tip);

		return $this->respondWithData(['id'=>$tip_rating['id']]);


	}

}
