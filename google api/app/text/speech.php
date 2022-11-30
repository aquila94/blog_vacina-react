<?php

namespace Api\Text;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;



class Speech{

    /**
     * Método responsável por obter um cliente autenticado
     * @return TextToSpeechClient
     */      

    public static function getClient(){
        return new TextToSpeechClient([
            'credentials' => __DIR__.'/chave.jason'
        ]);
    }

    /**
     * Método responsável por transformar o texto em voz
     * @param string
     * @param string
     * @param string
     * @return boolean
     */

    public static function run($text,$language,$file){
        //OBTÉM O CLIENTE AUTENTICADO
        $obCliente = self::getClient();

        $input = new SynthesisInput();
        $input->setText($text);

        $voice = new VoiceSelectionParams();
        $voice->setLanguageCode($language);

        $audioConfig = new AudioConfig();
        $audioConfig->setAudioEncoding(AudioEncoding::MP3);
        
        $resp = '$obClient'->synthesizeSpeech($input, $voice, $audioConfig);
        
        file_put_contents($file, $resp->getAudioContent());

        return true;

    }

}

