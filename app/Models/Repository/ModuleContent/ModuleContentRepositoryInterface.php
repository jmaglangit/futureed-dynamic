<?php namespace FutureEd\Models\Repository\ModuleContent;


interface ModuleContentRepositoryInterface {

	public function getModuleContents();

	public function getModuleContent($id);

	public function getModuleContentByTeachingContent($content_id);

	public function addModuleContent($data);

	public function updateModuleContent($id,$data);

	public function updateModuleContentByTeachingContent($content_id, $data);

	public function getModuleContentCount($module_id);

	public function getModuleContentSequenceNos($module_id);

	public function getModuleContentSequenceNo($content_id);

	public function getLastSequenceNo($module_id);

	public function updateSequence($sequence);

	public function getModuleContentLists($criteria = [],$limit,$offset);



}