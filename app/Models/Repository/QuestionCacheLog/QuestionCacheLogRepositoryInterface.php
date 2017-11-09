<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 2:23 PM
 */

namespace FutureEd\Models\Repository\QuestionCacheLog;


interface QuestionCacheLogRepositoryInterface {

	public function getQuestionCacheLogs($criteria=[],$limit=0,$offset=0);

	public function getQuestionCacheLog($id);

	public function addQuestionCacheLog($data);

	public function updateQuestionCacheLog($id,$data);

	public function deleteQuestionCacheLog($id);
}