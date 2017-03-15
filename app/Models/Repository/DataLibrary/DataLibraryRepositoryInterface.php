<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/15/17
 * Time: 3:31 PM
 */

namespace FutureEd\Models\Repository\DataLibrary;


interface DataLibraryRepositoryInterface {

	public function getDataLibraries($criteria=[],$limit=0,$offset=0);

	public function getDataLibrary($id);

	public function addDataLibrary($data);

	public function updateDataLibrary($id,$data);

	public function deleteDataLibrary($id);
}