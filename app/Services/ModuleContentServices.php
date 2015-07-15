<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;

class ModuleContentServices
{

	protected $module_content;

	public function __construct(
		ModuleContentRepositoryInterface $moduleContentRepositoryInterface
	)
	{
		$this->module_content = $moduleContentRepositoryInterface;
	}

	/**
	 * Sort sequence by adding.
	 * @param $module_id
	 * @param $seq_no
	 * @return mixed
	 */
	public function updateSequence($module_id, $seq_no)
	{

		//get sequence number
		$sequence = $this->module_content->getModuleContentSequenceNos($module_id);


		foreach ($sequence as $seq => $list) {

			if ($list->seq_no >= $seq_no && $list->seq_no >= $seq_no) {

				$list->seq_no++;
			}
		}

		return $sequence;
	}

	public function pullSequenceNo($module_id,$seq_no, $id){

		//get sequence number
		$sequence = $this->module_content->getModuleContentSequenceNos($module_id);


		foreach ($sequence as $seq => $list) {

			//retrack sequence
			if ($list->id == $id) {

				$list->seq_no = 0;
			}

			if ($list->seq_no > $seq_no) {

				$list->seq_no--;
			}
		}

		return $sequence;
	}


}