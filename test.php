<?php

// Parse pdf file and build necessary objects.

include 'pdfparser/vendor/autoload.php';
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('fisier');
 
$text = $pdf->getText();
echo "<pre>".$text;


//echo preg_replace ('/\?|#/',' xxx ','c?ac#ac');

echo preg_replace ('/\?|&|#|\\|%|\<|\>/',' xxx ','c?a>c#ac&');

echo exec('pwd');

echo phpinfo();

?>