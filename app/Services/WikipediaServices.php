<?php namespace FutureEd\Services;


class WikipediaServices {

	//get url json result from other site.
	public function getFileContents($api_url){

		$json = file_get_contents($api_url);

		$obj = json_decode($json);

		return $obj;

	}

	//set api url
	public function wikiUrlSetter($subject,$image_size){

		//https://en.wikipedia.org/w/api.php?action=query&titles={ATTRIBUTE_SUBJECT}&prop=pageimages&format=json&pithumbsize={ATTRIBUTE_SIZE}
		$wikipedia_api_url = "https://en.wikipedia.org/w/api.php?action=query&titles={ATTRIBUTE_SUBJECT}&prop=pageimages&format=json&pithumbsize={ATTRIBUTE_SIZE}";

		//do string replace subject
		$wikipedia_api_url = str_replace("{ATTRIBUTE_SUBJECT}",$subject, $wikipedia_api_url);

		//string replace image size
		$wikipedia_api_url= str_replace("{ATTRIBUTE_SIZE}",$image_size, $wikipedia_api_url);

		return $wikipedia_api_url;

	}


	//parse and get image base on size.
	public function getImage($api_url, $image_size){

		//remove string from wikipedia site.
		//TODO: get api url for wikipedia.

		//

	}



}