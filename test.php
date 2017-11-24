<?php

//$ch=curl_init('http://goo.gl/yp6VAe');
//$ch=curl_init('http://res.cloudinary.com/hiuo9fkio/image/upload/v1511536359/admin/example_wgimfq.png');
//curl_exec($ch);

file_get_contents('http://goo.gl/yp6VAe');

header('Content-Disposition: attachment; filename="caca.png"');
//readfile('http://goo.gl/yp6VAe');
readfile('goo.gl/oMeP1B');

?>
