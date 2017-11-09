<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/6/15
 * Time: 5:03 PM
 */

namespace FutureEd\Models\Repository\TeachingContent;


interface TeachingContentRepositoryInterface {

	public function addTeachingContent($data);

	public function getTeachingContents($criteria = [], $limit, $offset);

	public function deleteTeachingContent($id);

	public function updateTeachingContent($id, $data);

	public function getTeachingContent($id);

	public function getTeachingContentId($module_id);
}