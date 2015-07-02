<?php
namespace FutureEd\Models\Repository\Tip;

interface TipRepositoryInterface {

	public function addTip($data);

	public function getTips($criteria = array(), $limit = 0, $offset = 0);

	public function viewTip($id);

	public function updateTip($id, $data);

	public function deleteTip($id);

	public function viewClassTips($criteria = array(), $limit = 0, $offset = 0);


}