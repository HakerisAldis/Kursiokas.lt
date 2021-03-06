<?php
copy('https://getcomposer.org/installer', 'composer-setup.php');
if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { 
	echo 'Installer verified'; 
} 
else { 
	echo 'Installer corrupt';
       	unlink('composer-setup.php');
} 
echo PHP_EOL;

exec('php composer-setup.php');
unlink('composer-setup.php');

exec('php composer.phar update');
exec('php artisan migrate --force', $output);
exec('php artisan db:seed --force', $output);
foreach($output as $text){
        echo "$text\n";
}
exec('php artisan key:generate --force');
$localIP = getHostByName(getHostName());
echo $localIP;
exec('php artisan serve --host '.$localIP);
