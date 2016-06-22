<?php namespace FutureEd\Models\Repository\Game;


interface GameRepositoryInterface {

	public function getGames($criteria = [], $limit = 0, $offset = 0);

	public function getGame($id);

	public function getGamesWithUser($user_id, $limit = 0, $offset = 0);

}