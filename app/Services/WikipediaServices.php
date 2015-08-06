<?php namespace FutureEd\Services;


class WikipediaServices {

	//get url json result from other site.
	public function getFileContents($api_url){

		$json = file_get_contents($api_url);

		$obj = json_decode($json,true);

		return $obj;

	}

	//set api url
	public function wikiUrlSetter($subject){

		//https://en.wikipedia.org/w/api.php?action=query&titles={ATTRIBUTE_SUBJECT}&prop=pageimages&format=json&pithumbsize={ATTRIBUTE_SIZE}
		$wikipedia_api_url = "https://en.wikipedia.org/w/api.php?action=query&titles={ATTRIBUTE_SUBJECT}&prop=pageimages&format=json";

		//do string replace subject
		$wikipedia_api_url = str_replace("{ATTRIBUTE_SUBJECT}",$subject, $wikipedia_api_url);

		//string replace image size
//		$wikipedia_api_url= str_replace("{ATTRIBUTE_SIZE}",$image_size, $wikipedia_api_url);

		return $wikipedia_api_url;

	}


	//parse and get image base on size.
	public function getImage($api_url){

		$wikipedia = 'https://en.wikipedia.org/wiki/';

		//remove wikipedia site. 'https://en.wikipedia.org/wiki/'
		$subject = trim($api_url,$wikipedia);


		//remove string from wikipedia site.
		//TODO: get api url for wikipedia.
		$url = $this->wikiUrlSetter($subject);


		$get_file_content = $this->getFileContents($url);

		if(array_key_exists('query',$get_file_content)
			&&  array_key_exists('pages',$get_file_content['query'])){

			$file_content_image = array_keys($get_file_content['query']['pages']);

			$subject_wiki_id = $file_content_image[0];

			if(array_key_exists('thumbnail',$get_file_content['query']['pages'][$subject_wiki_id])
				&& array_key_exists('source',$get_file_content['query']['pages'][$subject_wiki_id]['thumbnail'])){

				$subject_thumbnail_image = $get_file_content['query']['pages'][$subject_wiki_id]['thumbnail']['source'];

				return $subject_thumbnail_image;

			}

		} else {

			return false;
		}

	}



}