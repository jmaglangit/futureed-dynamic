<?php

namespace FutureEd\Models\Repository\Module;

use FutureEd\Models\Core\CountryGrade;
use FutureEd\Models\Core\Module;
use FutureEd\Models\Traits\LoggerTrait;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;


class ModuleRepository implements ModuleRepositoryInterface
{
	use LoggerTrait;

	/**
	 * @param $data
	 * @return string|static
	 */
	public function addModule($data)
	{

		try {

			$module = Module::create($data);

		} catch (Exception $e) {

			return $e->getMessage();

		}

		return $module;

	}

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getModules($criteria = array(), $limit = 0, $offset = 0)
	{
		DB::beginTransaction();

		try{
			$module = new Module();

			$count = 0;

			$module = $module->with('subject', 'subjectArea', 'grade', 'studentModule');

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {
				$count = $module->count();

			} else {
				if (count($criteria) > 0) {

					//check  subject_id
					if (isset($criteria['subject_id'])) {

						$module = $module->subjectId($criteria['subject_id']);
					}

					//check grade_id
					if (isset($criteria['grade_id'])) {

						$module = $module->gradeId($criteria['grade_id']);
					}

					//check module student_id
					if (isset($criteria['student_id'])) {

						$module = $module->studentId($criteria['student_id']);
					}

					//check module class_id
					if (isset($criteria['class_id'])) {

						$module = $module->classId($criteria['class_id']);
					}

					//check module status
					if (isset($criteria['module_status'])) {

						$module = $module->moduleStatus($criteria['module_status']);
					}

					//check relation to subject
					if (isset($criteria['subject'])) {

						$module = $module->subjectName($criteria['subject']);
					}

					//check module name
					if (isset($criteria['name'])) {

						$module = $module->name($criteria['name']);
					}

					//check relation to subject_area
					if (isset($criteria['area'])) {

						$module = $module->subjectAreaName($criteria['area']);
					}

					//check age group
					if (isset($criteria['age_group_id'])) {

						$module = $module->ageGroup($criteria['age_group_id']);
					}

				}

				$count = $module->count();

				if ($limit > 0 && $offset >= 0) {
					$module = $module->offset($offset)->limit($limit);
				}

			}

			$response = ['total' => $count, 'records' => $module->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $module_id
	 * @return bool|mixed
	 */
	public function getModule($module_id){

		DB::beginTransaction();
		try{

			$response = Module::find($module_id);

		}catch(Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * @param $id
	 * @return Module|\Illuminate\Database\Eloquent\Builder|static
	 */
	public function viewModule($id)
	{
		DB::beginTransaction();

		try{
			$module = new Module();

			$module = $module->with('subject', 'subjectarea', 'grade', 'content', 'question', 'studentModuleValid');
			$response = $module->find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @param $data
	 * @return bool|int
	 * @throws Exception
	 */
	public function updateModule($id, $data)
	{
		DB::beginTransaction();

		try {
			$response = Module::find($id)
				->update($data);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * @param $id
	 * @return bool|null|string
	 */
	public function deleteModule($id)
	{
		DB::beginTransaction();

		try {

			$module = Module::find($id);

			$response = !is_null($module) ? $module->delete() : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * Get Module points to finish.
	 * @param $module_id
	 */
	public function getPointsToFinish($module_id)
	{
		DB::beginTransaction();

		try{
			$response = Module::find($module_id)->pluck('points_to_finish');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $subject_id
	 * @param $grade_id
	 * @return mixed
	 */
	public function getGradeModule($subject_id,$grade_id){
		DB::beginTransaction();

		try{
			$response = Module::subjectId($subject_id)->gradeId($grade_id)->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * count the number of module under a subject under a grade
	 * @param $subject_id ,$grade_id;
	 * @return count
	 */
	public function countSubjectModule($subject_id, $grade_id)
	{
		DB::beginTransaction();

		try{
			$module = new Module();

			$module = $module->subjectId($subject_id);
			$module = $module->gradeId($grade_id);
			$response = $module->count();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	//
	/**
	 * Modules search student_id, class_id, module_name, grade_id, module_status
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getModulesByStudentProgress($criteria, $offset = 0, $limit = 0){
		DB::beginTransaction();

		try {

			$student_module = Module::select(
				'modules.id as id',
				'modules.subject_id',
				'modules.subject_area_id',
				'modules.grade_id',
				'modules.code',
				'modules.name',
				'modules.icon_image',
				'modules.description',
				'modules.common_core_area',
				'modules.common_core_url',
				'modules.points_earned',
				'modules.points_to_unlock',
				'modules.points_to_finish',
				'student_modules.id as student_module_id',
				'student_modules.class_id',
				'student_modules.student_id',
				'student_modules.module_status',
				'student_modules.last_viewed_content_id',
				'student_modules.progress',
				'student_modules.date_start',
				'student_modules.date_end',
				'student_modules.total_time'
			)
				->leftJoinStudentModule($criteria);

			//Get module_name
			if (isset($criteria['module_name'])) {

				$student_module = $student_module->name($criteria['module_name']);
			}

			//Get grade_id
			if (isset($criteria['grade_id']))
			{
				$country_grade = CountryGrade::whereGradeId($criteria['grade_id'])->with('gradeLevel')->first()->toArray();

				$student_module = $student_module->gradeId($country_grade['grade_level']['grade_id']);
			}

			//module_status
			if (isset($criteria['module_status'])) {

				$student_module = $student_module->studentModuleStatus($criteria['module_status']);
			}

			if (isset($criteria['limit'])) {

				$limit = $criteria['limit'];
			}

			if (isset($criteria['offset'])) {

				$offset = $criteria['offset'];
			}

			$count = $student_module->count();

			if ($limit > 0 && $offset >= 0) {

				$student_module = $student_module->offset($offset)->limit($limit);
			}

			$response = ['total' => $count, 'records' => $student_module->get()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get column headers for reports based on country_id.
	 * @param $country_id
	 * @return mixed
	 */
	public function getModuleGradeByStudentCountry($country_id){
		DB::beginTransaction();

		try{
			$response = Module::select (
				\DB::raw('cg.grade_id as grade_id,g.name as grade_name')
				)->leftJoin('country_grades as cg','modules.grade_id','=','cg.grade_id')
				->leftJoin('country_grades as cg2',function($left_join) use ($country_id){
					$left_join->on('cg2.age_group_id','=','cg.age_group_id');
				})
				->leftJoin('grades as g','g.id','=','cg2.grade_id')
				->where('cg2.country_id',$country_id)
				->groupBy('g.name')
				->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}