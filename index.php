<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Get proxy</title>
</head>
<body>
    <form method="post" align= "center">
   <input type="submit" name="test" value= "получить прокси!"  />
       <?php
       if (isset ( $_POST ['test'])) 
            {
                require_once 'vendor/autoload.php';
                ///==========================================FUNCS=================================================//

                function free_proxy_sale()
                {
                    $p_list = 'import/proxy_list.txt';
                    $url = 'https://free.proxy-sale.com/';
                    $main = file_get_contents($url);
                    // получена главная страница
                    $doc = phpQuery::newDocument($main);
                    $href = $doc->find('.ico-export-tre a')->attr('href');
                    $href = 'https://free.proxy-sale.com'.$href;
                    // получена нужная ссылка
                    $file = file_get_contents($href);
                    $file = json_encode($file);
                    $file = explode('\r\n', $file);

                    return $file;  
                }

                function foxtools()
                {
                    $ip = [];
                    $url = 'http://api.foxtools.ru/v2/Proxy';
                    $file = file_get_contents($url);
                    // получена страница с ip
                    $proxys = json_decode($file);
                    $proxys = $proxys->response->items;

                    foreach($proxys as $proxy) 
                    {
                        array_push($ip, ($proxy->ip.":".$proxy->port));
                    }
                    return $ip;
                }

                ///==========================================CODE=================================================//

                file_put_contents("import/proxy_list.txt", '');

                $ips = foxtools();

                unset($ips[count($ips)-1]);   // удаление ковычки которая последняя в массиве

                foreach ($ips as $ip) {
                    file_put_contents("import/proxy_list.txt", $ip."\r\n",FILE_APPEND);
                }

                echo "<br><br><br>Прокси получены!";
            }
        ?>
    
    </form>


</body>
</html>