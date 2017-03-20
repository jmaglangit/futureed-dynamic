<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 2:00 PM
 */

namespace FutureEd\Models\Repository\QuestionCache;


interface QuestionCacheRepositoryInterface {

	public function getQuestionCaches($criteria=[],$limit=0,$offset=0);

	public function getQuestionCache($id);

	public function addQuestionCache($data);

	public function updateQuestionCache($id,$data);

	public function deleteQuestionCache($id);
}