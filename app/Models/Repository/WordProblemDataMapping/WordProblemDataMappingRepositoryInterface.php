<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/28/17
 * Time: 11:50 AM
 */

namespace FutureEd\Models\Repository\WordProblemDataMapping;


interface WordProblemDataMappingRepositoryInterface {

	public function getDatas($limit,$offset);

	public function getData($id);

	public function addData($data);

	public function editData($id,$data);

	public function deleteData($id);

	public function deleteAllData();

	public function insertDatas($data);

}