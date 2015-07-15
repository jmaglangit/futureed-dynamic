<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;

class ModuleContent
{

	protected $module_content;

	public function __construct(
		ModuleContentRepositoryInterface $moduleContentRepositoryInterface
	)
	{
		$this->module_content = $moduleContentRepositoryInterface;
	}

	public function updateSequence($module_id, $seq_no)
	{

		//get sequence number
		$sequence = $this->question->getQuestionSequenceNos($module_id);

		foreach ($sequence as $seq => $list) {

			if ($list->seq_no >= $seq_no && $list->seq_no >= $seq_no) {

				$list->seq_no++;
			}
		}

		return $sequence;
	}

}