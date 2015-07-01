<?php namespace FutureEd\Models\Repository\HelpRequest;

interface HelpRequestRepositoryInterface {
    public function addHelpRequest($data);
    public function getHelpRequest($id);
    public function getHelpRequests($criteria = array(), $limit = 0, $offset = 0);
    public function updateHelpRequest($id,$data);
    public function deleteHelpRequest($id);
}