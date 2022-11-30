<?php

require __DIR__.'/vendor/autoload.php';

use \app\text\speech;


speech::run('TESTE DE ÁUDIO','pt-BR',__DIR__.'/audio.mp3');

//NÃO CONSEGUIMOS EXECUTAR. ARQUIVO BAIXADO NO GOOGLE APARECE COM ERROS QUE NÃO CONSEGUIMOS SOLUCIONAR