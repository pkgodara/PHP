<?php
function crawl($url , $depth=2)
{
//array containing all visited urls
static $urlArray = array() ;

//check if already visited
if( isset($urlArray[$url]) )
{
return;
}

echo "\nCrawling URL: ".$url;

$urlArray[$url] = true;

$doc = new DOMDocument();

@$doc->loadHTMLFile($url);

$a = $doc->getElementsByTagName('a');

foreach ($a as $u )
{
$link = $u->getAttribute('href');

if( 0 !== strpos($link, 'http') )
{
   $path = '/'.ltrim($link , '/');
   
   if( extension_loaded('http') )
   {
      $link = http_build_url($url,array('path'=>$path) );
   }
   else
   {
   $parts = parse_url($url);
   $link = $parts['scheme'].'://' ;
   if( isset($parts['user']) && isset($parts['pass'] ) )
   {
      $link .= $parts['user'].':'.$parts['pass'].'@';
   }
   
   $link .= $parts['host'];
   
   if( isset($parts['port']) )
   {
      $link .= ':'.$parts['port'];
   }
   $link .= $path;
   }
}

if( substr($link,-1) == '/' )
$link = substr($link,0,strlen($link)-1) ;

crawl($link , $depth-1 );
}

}//function end

//program starts
echo "Welcome to php web-crawler\n" ;

$url = readline("Enter url to crawl : ");

if( 0 !== strpos($url,'http') )
$url = 'http://'.$url ;

crawl($url);

?>
