<?php

use Illuminate\Database\Seeder;
use \League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class TranslationThaiMessageFileSeeder extends Seeder
{
    public function run()
    {
        $lang_id_reader = Reader::createFromPath(storage_path('seeders') . '/' . 'thai.csv');
        $text_var_reader = Reader::createFromPath(storage_path('seeders') . '/' . 'translation_variable_text.csv');

        $text_var_array = [];
        $lang_id_array = [];

        $content = '<?php'."\n\r";
        $content = $content.'return ['."\n\r";
        $this->command->info('Getting Language Pack');
        foreach($lang_id_reader as $index => $value)
        {
            try {
                if ($index != 0 && $index != 1) {
                    $lang_id_array[$value[0]] = $value[1];
                }
            }
            catch(Exception $e){
                dd($value);
            }
        }
        $this->command->info('Unpacking');
        foreach($text_var_reader as $index => $value)
        {
            if($index != 0 && $index != 1)
            {
                $text_var_array[trim($value[0], " ")] = $value[1];
            }
        }
        $this->command->info('Generating File');
        foreach($text_var_array as $key => $value)
        {
            if(isset($lang_id_array[$value]))
            {
                $content = $content."\t".'"'.$key.'" => "'.trim(addslashes(mb_substr($lang_id_array[$value], 0, strlen($lang_id_array[$value]), 'UTF-8'))).'",'."\n\r";
            }
        }

        $content = $content.'];';

        Storage::disk('language_local')->put('th/messages.php', $content);
    }
}
