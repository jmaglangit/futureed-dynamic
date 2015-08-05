<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\AvatarWiki\AvatarWikiRepositoryInterface;
use FutureEd\Services\WikipediaServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AvatarWikiController extends ApiController {

	public function __construct(
		AvatarWikiRepositoryInterface $avatarWikiRepositoryInterface,
		WikipediaServices $wikipediaServices
	){

		$this->avatar_wiki = $avatarWikiRepositoryInterface;

		$this->wikipedia = $wikipediaServices;

	}

	public function getAvatarWikiByAvatarId(){

		$return = $this->avatar_wiki->getAvatarWikiByAvatarId(Input::get('avatar_id'));

		//get link image from wikipedia
		//e.g. https://en.wikipedia.org/w/api.php?action=query&titles=Alexey_Leonov&prop=pageimages&format=json&pithumbsize=250
		//parse api get image location.

		//pixel size
		$image_size = 250;

		$api_url = "https://en.wikipedia.org/w/api.php?action=query&titles=Alexey_Leonov&prop=pageimages&format=json&pithumbsize=250";


		$image = $this->wikipedia->getImage($api_url,$image_size);

		dd($image);

		return $return;

	}
}
