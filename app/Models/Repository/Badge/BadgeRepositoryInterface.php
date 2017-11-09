<?php namespace FutureEd\Models\Repository\Badge;


interface BadgeRepositoryInterface {

	public function getBadges($criteria = array(), $limit = 0, $offset = 0);

	public function getCompletedBadges($criteria = array());

}