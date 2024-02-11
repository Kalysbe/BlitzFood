<?php
exec("ping www.mail.ru -c5 -i0", $ping);
// ÷ Windows - exec("ping -n 5 www.php.net. $ping);
//sleep(10);
echo'ping='.count($ping);
for ($i=0; $i< count($ping);$i++)
{
echo '<br>'.$ping[$i];
};
