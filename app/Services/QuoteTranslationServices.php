<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Quote\QuoteRepositoryInterface;
use FutureEd\Models\Repository\QuoteTranslation\QuoteTranslationRepositoryInterface;
use Illuminate\Support\Facades\App;

class QuoteTranslationServices {

	protected $quote_translation;

	protected $quote;

	protected $google_translate;

	/**
	 * @param QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface
	 * @param QuoteRepositoryInterface $quoteRepositoryInterface
	 * @param GoogleTranslateServices $googleTranslateServices
	 */
	public function __construct(
		QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface,
		QuoteRepositoryInterface $quoteRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices
	) {
		$this->quote_translation = $quoteTranslationRepositoryInterface;
		$this->quote = $quoteRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
	}

	/**
	 * Google translate quote table.
	 * @param $input
	 * @return mixed
	 */
	public function googleTranslate($input) {

		//loop throughout every 1000 rows.
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');
		$record_count = $this->quote_translation->quoteCount();

		$current_lang = App::getLocale();
		App::setLocale(config('translatable.fallback_locale'));

		for ($i = 0; $i <= ceil( $record_count/ $limit); $i++) {

			$quote = $this->quote_translation->getQuote([], $limit, $offset);

			$offset += $limit;

			//parse to array and add translations to target_language
			foreach ($quote['records'] as $record) {

				//check if translatable and tagged
				$translatable = 0;

				if ($input['tagged'] == config('futureed.true')
					&& $record['translatable'] == config('futureed.true')
				) {

					$translatable++;

				} elseif ($input['tagged'] == config('futureed.false')) {

					//if all are translatable
					$translatable++;
				}

				if ($translatable == config('futureed.true')) {

					//set target language
					$this->google_translate->setTarget($input['target_lang']);

					//get translation using google translate
					$translated_text = $this->google_translate->translate($record[$input['field']]);

					$data = [
						'quote_id' => $record['id'],
						'string' => $translated_text
					];

					$this->quote_translation->updatedTranslation($data, $input['target_lang'], $input['field']);

					//update translatable into 0
					$this->quote->updateQuote($record['id'], [
						'translatable' => config('futureed.false')
					]);
				}
			}
		}

		//get back previous locale
		App::setLocale($current_lang);

		return $input;
	}
}