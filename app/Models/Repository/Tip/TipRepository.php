<?php

namespace FutureEd\Models\Repository\Tip;

use Carbon\Carbon;
use FutureEd\Models\Core\Tip;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;


class TipRepository implements TipRepositoryInterface{

	//create record
	public function addTip($data){

		try {

			$tip = Tip::create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $tip;



	}

	public function getTips($criteria = array(), $limit = 0, $offset = 0){

		$tip = new Tip();

		$tip = $tip->with('subject','module','subjectarea')->where('tip_status','!=','Rejected');

		$count = 0;

		if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $tip->count();

		} else {


			if (count($criteria) > 0) {

				//for tip_status
				if(isset($criteria['status'])) {

					$tip = $tip->tipStatus($criteria['status']);

				}

				//check for link_type
				if(isset($criteria['link_type'])){

					$tip = $tip->linkType($criteria['link_type']);
				}

				//check relation to subject
				if(isset($criteria['subject'])){

					$tip = $tip->subjectName($criteria['subject']);
				}

				//check relation to module
				if(isset($criteria['module'])){

					$tip = $tip->moduleName($criteria['module']);
				}

				//check relation to subject_area
				if(isset($criteria['area'])){

					$tip = $tip->subjectAreaName($criteria['area']);
				}

			}

			$count = $tip->count();

			if ($limit > 0 && $offset >= 0) {
				$tip = $tip->offset($offset)->limit($limit);
			}

		}
		$tip = $tip->orderBy('created_at', 'desc');
		return ['total' => $count, 'records' => $tip->get()->toArray()];

	}

	public function viewTip($id){

		$tip = new Tip();

		$tip = $tip->with('subject','module','subjectarea','student');
		$tip = $tip->find($id);
		return $tip;	

	}

	public function updateTip($id, $data){

		try{

			return Tip::find($id)
						->update($data);

		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}

	}

	public function deleteTip($id){

		try {

			$tip = Tip::find($id);

			return !is_null($tip) ? $tip->delete() : false;

		} catch(Exception $e) {

			return $e->getMessage();

		}
	}

	/**
	 *
	 * @return list of tips under a class
	 */
	public function viewClassTips($criteria = array(), $limit = 0, $offset = 0){

		$tip = new Tip();

		$tip = $tip->with('subject','module','subjectarea','student')->where('tip_status','!=','Rejected');

		$count = 0;

		if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $tip->count();

		} else {

			if (count($criteria) > 0) {

				//for class_id
				if(isset($criteria['class_id'])) {

					$tip = $tip->classId($criteria['class_id']);
				}

				//for module_id
				if(isset($criteria['module_id'])) {

					$tip = $tip->moduleId($criteria['module_id']);
				}

				//check for link_type
				if(isset($criteria['link_type'])){

					$tip = $tip->linkType($criteria['link_type']);
				}

				//check for link_id
				if(isset($criteria['link_id'])){

					$tip = $tip->linkId($criteria['link_id']);
				}

				//for title
				if(isset($criteria['title'])) {

					$tip = $tip->title($criteria['title']);
				}


				//for tip_status
				if(isset($criteria['tip_status'])) {

					$tip = $tip->tipStatus($criteria['tip_status']);

				}

				//for status
				if(isset($criteria['status'])){

					$tip = $tip->status($criteria['status']);
				}

				//relation to student query creators name
				if(isset($criteria['created'])) {

					$tip = $tip->name($criteria['created']);

				}

				//check relation to subject
				if(isset($criteria['subject'])){

					$tip = $tip->subjectName($criteria['subject']);
				}

				//check relation to subject_area
				if(isset($criteria['area'])){

					$tip = $tip->subjectAreaName($criteria['area']);
				}

			}



			$count = $tip->count();

			if ($limit > 0 && $offset >= 0) {
				$tip = $tip->offset($offset)->limit($limit);

			}

		}
		$tip = $tip->orderBy('created_at', 'desc');

		return ['total' => $count, 'records' => $tip->get()->toArray()];

	}

	/**
	 *
	 * @return  3 currently added general tips for student under a certain class
	 */

	public function viewCurrentTips($class_id){

		$tip = new Tip();

		$tip = $tip->with('subject','module','subjectarea','student')->accepted();
		$tip = $tip->general()->classId($class_id);
		$tip = $tip->orderBy('created_at','desc')->take(config('futureed.tip_take'));
		return $tip->get();

	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 */
	public function getStudentActiveTips($student_id, $subject_id){
		//
		//select
		//t.id, t.class_id,t.student_id
		//from tips t
		//left join classrooms c on c.id=t.class_id
		//left join orders o on o.order_no=c.order_no
		//where
		//t.student_id = 3
		//and t.subject_id = 3
		//and o.date_start <= now() and o.date_end >= now()
		//;

		return Tip::select('tips.*')->leftJoin('classrooms as c','c.id','=','tips.class_id')
			->leftJoin('orders as o','o.order_no','=','c.order_no')
			->where('tips.student_id',$student_id)
			->where('tips.subject_id',$subject_id)
			->where('o.date_start','<=',Carbon::now())
			->where('o.date_end','>=',Carbon::now())
			->get();
	}




	

}