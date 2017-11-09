<?php

namespace FutureEd\Models\Repository\AdminLog;


interface AdminLogRepositoryInterface {

	public function getAdminLog($id);

	public function getAdminLogs($criteria, $offset, $limit);

	public function addAdminLog($data);


}