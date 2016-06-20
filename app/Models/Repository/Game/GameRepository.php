<?php namespace FutureEd\Models\Repository\Game;

use FutureEd\Models\Core\Game;
use FutureEd\Models\Traits\LoggerTrait;

class GameRepository implements GameRepositoryInterface{

	use LoggerTrait;

	/**
	 * Get list of games with information
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array|bool
	 */
	public function getGames($criteria = [], $limit = 0, $offset = 0){

		try{

			$games = new Game();

			if(isset($criteria['code'])){

				$games = $games->code($criteria['code']);
			}

			if(isset($criteria['name'])){

				$games = $games->name($criteria['name']);
			}

			if(isset($criteria['points_price'])){

				$games = $games->pointsPrice($criteria['points_price']);
			}

			$count = $games->count();

			if($limit > 0 && $offset >= 0) {

				$games = $games->limit($limit)->offset($offset);
			}

			$response = [
				'total' => $count,
				'records' => $games->get()->toArray()
			];

		}catch (\Exception $e){

			$this->errorLog($e->getMessage());

			return false;
		}

		return $response;
	}

	/**
	 * Get game information.
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getGame($id){

		return Game::find($id);
	}
}