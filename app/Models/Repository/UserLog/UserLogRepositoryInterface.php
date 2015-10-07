<?php

namespace FutureEd\Models\Repository\UserLog;


interface UserLogRepositoryInterface {

	public function getUserLog($id);

	public function getUserLogs($criteria, $offset, $limit);

}