<?php

namespace FutureEd\Models\Repository\SecurityLog;


interface SecurityLogRepositoryInterface {

	public function getSecurityLogs($criteria, $offset, $limit);

}