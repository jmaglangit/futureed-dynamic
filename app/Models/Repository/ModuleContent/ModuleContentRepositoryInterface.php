<?php namespace FutureEd\Models\Repository\ModuleContent;


interface ModuleContentRepositoryInterface {

	public function getModuleContents();

	public function getModuleContent($id);

	public function getModuleContentByTeachingContent($content_id);

	public function addModuleContent($data);

	public function updateModuleContent($id,$data);

	public function updateModuleContentByTeachingContent($content_id, $data);

}