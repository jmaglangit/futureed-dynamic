<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class QuestionTemplateOperationTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        //ADD ADDITION
        $datas = [
            'addition',
            'subtraction',
            'multiplication',
            'division',
            'fraction_addition',
            'fraction_subtraction',
            'fraction_multiplication',
            'fraction_division',
            'fraction_addition_butterfly',
            'fraction_subtraction_butterfly',
            'fraction_addition_whole',
            'fraction_subtraction_whole',
			'integer_sort_small',
			'integer_sort_large',
			'integer_counting',  //MO
            'integer_addition',
			'integer_convert_number',
			'integer_decimal',
			'integer_expanded_decimal',
			'integer_extended',
			'integer_identify',
			'integer_regroup',
			'integer_rounding_number',
        ];

        $seeder = [];
        foreach($datas as $data){

            //insert data
            array_push($seeder,[
                'operation_data' => $data,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('question_template_operation')->truncate();
        DB::table('question_template_operation')->insert($seeder);
    }
}
