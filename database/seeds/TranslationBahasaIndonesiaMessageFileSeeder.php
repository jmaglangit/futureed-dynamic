<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class TranslationBahasaIndonesiaMessageFileSeeder extends Seeder
{
    public function run()
    {
        $lang_id_reader = Reader::createFromPath(storage_path('seeders') . '/' . 'bahasa_indonesia.csv');
        $text_var_reader = Reader::createFromPath(storage_path('seeders') . '/' . 'translation_variable_text.csv');

        $text_var_array = [];
        $lang_id_array = [];
        $final_array = [];

        $content = '<?php'."\n\r";
        $content = $content.'return ['."\n\r";
        $this->command->info('Retrieving Language Pack');

        foreach($lang_id_reader as $index => $value)
        {
            if($index != 0 && $index != 1 && $value[0] != '')
            {
                $lang_id_array[] = addslashes($value[0]);
                $lang_id_array[] = addslashes($value[1]);
            }
        }
        foreach($text_var_reader as $index => $value)
        {
            if($index != 0 && $index != 1 && $value[0] != '')
            {
                $text_var_array[] = addslashes($value[0]);
                $text_var_array[] = addslashes($value[1]);
            }
        }
        foreach($text_var_array as $index => $value)
        {
            if($value != '')
            {
                $numIndex = array_search($value, $lang_id_array);
                if(!empty($numIndex))
                {
                    $final_array[$text_var_array[$index-1]] = $lang_id_array[$numIndex+1];
                }
            }
        }

        $this->command->info('Generating File');
        foreach($final_array as $key => $value)
        {
            $content = $content."\t".'"'.$key.'" => "'.$value.'",'."\n\r";
        }

        $content = $content.'];';

        Storage::disk('language_local')->put('id/messages.php', $content);
    }
}
