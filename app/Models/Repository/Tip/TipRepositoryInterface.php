<?php
namespace FutureEd\Models\Repository\Tip;

interface TipRepositoryInterface {

	public function addTip($data);

	public function getTips($criteria = array(), $limit = 0, $offset = 0);

}