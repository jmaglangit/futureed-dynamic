<?php namespace FutureEd\Models\Repository\Event;


interface EventRepositoryInterface {

	public function getEvents($criteria = array(), $limit = 0, $offset = 0);

}