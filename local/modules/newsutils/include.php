<?php

\Bitrix\Main\Loader::registerAutoLoadClasses('newsutils', [
    'Local\\NewsUtils\\NewsUtils' => 'lib/newsutils.php',
    'Local\\NewsUtils\\CanonicalIBlockUtils' => 'lib/canonicaliblockutils.php'
]);
