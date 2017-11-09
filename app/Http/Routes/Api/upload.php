<?php
/**
 * Upload routes
 */

Routes::post('/peaches/api/v1/data-library/import',[
	'uses' => 'Api\v1\DataLibraryController@dataLibraryImport',
	'as' => 'api.v1.data-library.import.csv'
]);

Routes::post('/peaches/api/v1/word-problem-data/import',[
	'uses' => 'Api\v1\WordProblemDataMappingController@wordProblemDataImport',
	'as' => 'api.v1.word-problem-data.import.csv'
]);