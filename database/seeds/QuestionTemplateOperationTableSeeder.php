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
            'ADDITION',
            'SUBTRACTION',
            'MULTIPLICATION',
            'DIVISION',
			'FRACTION_ADDITION',
			'FRACTION_SUBTRACTION',
			'FRACTION_DIVISION',
			'FRACTION_ADDITION_BUTTERFLY',
			'FRACTION_SUBTRACTION_BUTTERFLY',
			'FRACTION_ADDITION_WHOLE',
			'FRACTION_SUBTRACTION_WHOLE',
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
