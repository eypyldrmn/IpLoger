<?php


function gercekIP() {
	if(getenv("HTTP_CLIENT_IP")) {
 		$ip = getenv("HTTP_CLIENT_IP");
 	} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 		$ip = getenv("HTTP_X_FORWARDED_FOR");
 		if (strstr($ip, ',')) {
 			$bol = explode (',', $ip);
 			$ip = trim($bol[0]);
 		}
 	} else {
 	$ip = getenv("REMOTE_ADDR");
 	}
	return $ip;
}
$ipBas = gercekIP();

if (!isset($_SESSION)) {
    session_start();
}
if($_SESSION['last_session_request'] > time() - 2) {
if(!file_exists(".htaccess")) {
	touch(".htaccess");
	$banDosya = @fopen(".htaccess", "a");
	$banYaz = "order deny,allow"."\n";
	@fwrite($banDosya, $banYaz);
	@fclose($banDosya);
	header('refresh: 0; url=/');
}else{
	$banDosya = @fopen(".htaccess", "a");
	$banYaz =  "deny from " . $ipBas."\n";
	@fwrite($banDosya, $banYaz);
	@fclose($banDosya);
	}
    exit;
}
$_SESSION['last_session_request'] = time();

$gunler = array(
	'Pazartesi',
	'Sali',
	'Carsamba',
	'Persembe',
	'Cuma',
	'Cumartesi',
	'Pazar'
);

$aylar = array(
	'Ocak',
	'Subat',
 	'Mart',
 	'Nisan',
 	'Mayis',
 	'Haziran',
 	'Temmuz',
 	'Agustos',
 	'Eylul',
 	'Ekim',
 	'Kasim',
 	'Aralik'
);
$ayBastir = $aylar[date('m') - 1];
$gunBastir = $gunler[date('N') - 1];

function isletimSistemi() {
$isletimSistemiTespit=$_SERVER['HTTP_USER_AGENT'];
if(stristr($isletimSistemiTespit,"Windows NT 4.00")){
	$isletimSistemiTespit="Windows 95";
}elseif(stristr($isletimSistemiTespit,"Windows NT 4.10")){
	$isletimSistemiTespit="Windows 98";
}elseif(stristr($isletimSistemiTespit,"Windows NT 4.90")){
	$isletimSistemiTespit="Windows ME";
}elseif(stristr($isletimSistemiTespit,"Windows NT 5.0")){
	$isletimSistemiTespit="Windows 2000";
}elseif(stristr($isletimSistemiTespit,"Windows NT 5.1")){
	$isletimSistemiTespit="Windows XP";
}elseif(stristr($isletimSistemiTespit,"Windows NT 5.2")){
	$isletimSistemiTespit="Windows XP PRO";
}elseif(stristr($isletimSistemiTespit,"Windows NT 6.0")){
	$isletimSistemiTespit="Windows Vista";
}elseif(stristr($isletimSistemiTespit,"Windows NT 6.1")){
	$isletimSistemiTespit="Windows 7";
}elseif(stristr($isletimSistemiTespit,"Windows NT 6.2")){
	$isletimSistemiTespit="Windows 8";
}elseif(stristr($isletimSistemiTespit,"Windows NT 6.3")){
	$isletimSistemiTespit="Windows 8.1";
}elseif(stristr($isletimSistemiTespit,"Windows NT 10.0")){
	$isletimSistemiTespit="Windows 10";
}elseif(stristr($isletimSistemiTespit,"Ios")){
	$isletimSistemiTespit="Ios";
}elseif(stristr($isletimSistemiTespit,"Android")){
	$isletimSistemiTespit="Android";
}elseif(stristr($isletimSistemiTespit,"Mac")){
	$isletimSistemiTespit="Mac";
}elseif(stristr($isletimSistemiTespit,"Linux")){
	$isletimSistemiTespit="Linux";
}else{
	$isletimSistemiTespit="Bilinmiyor";
}return $isletimSistemiTespit;
}

function tarayici() {
$tarayiciTespit=$_SERVER['HTTP_USER_AGENT'];
if(stristr($tarayiciTespit,"Trident/7.0")){
	$tarayici="Internet Explorer 11";
}elseif(stristr($tarayiciTespit,"Trident/6.0")){
	$tarayici="Internet Explorer 10";
}elseif(stristr($tarayiciTespit,"Trident/5.0")){
	$tarayici="Internet Explorer 9";
}elseif(stristr($tarayiciTespit,"Trident/4.0")){
	$tarayici="Internet Explorer 8";
}elseif(stristr($tarayiciTespit,"Firefox")){
	$tarayici="Mozilla Firefox";
}elseif(stristr($tarayiciTespit,"Edge")){
	$tarayici="Edge";
}elseif(stristr($tarayiciTespit,"Chrome")){
	$tarayici="Google Chrome";
}elseif(stristr($tarayiciTespit,"YaBrowser")){
	$tarayici="Yandex Browser";
}elseif(stristr($tarayiciTespit,"Safari")){
	$tarayici="Safari";
}elseif(stristr($tarayiciTespit,"Opera")){
	$tarayici="Opera";
}else{
	$tarayici="Bilinmiyor";
}return $tarayici;
}

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
if($iphone == true){
	$mobilKontrol = "iPhone";
}elseif($android == true){
	$mobilKontrol = "Android";
}elseif($palmpre == true){
	$mobilKontrol = "webOS";
}elseif($berry == true){
	$mobilKontrol = "BlackBerry";
}elseif($ipod == true){
	$mobilKontrol = "iPod";
}else{
	$mobilKontrol="Bilgisayar";
}

if(!file_exists("kayit.txt")) {
	touch("kayit.txt");
	$dosya = @fopen("kayit.txt", "+r");
	@fclose($dosya);
	header('refresh: 0; url=/');
}else{
	$dosya = @fopen("kayit.txt", "a");
	$dosyaYaz = "-------------------------------------------------"."\r\n"."Giris Tarihi: ".date('j ').$ayBastir.date(' Y ').$gunBastir.date(' H:i:s')."\r\n"."Giris Yapilan Url: ".getenv('HTTP_REFERER')."\r\n"."IP Adresi: ".$ipBas."\r\n"."Aygit: ".$mobilKontrol."\r\n"."Isletim Sistemi: ".isletimSistemi()."\r\n"."Tarayici: ".tarayici()."\r\n"."-------------------------------------------------"."\r\n";
	@fwrite($dosya, $dosyaYaz);
	@fclose($dosya);
	}
?>
