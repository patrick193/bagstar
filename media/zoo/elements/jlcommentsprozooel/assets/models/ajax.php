<?php

 /**
 * @package plugin mail sync. Ya
 * @author Artem Zhukov (artem@joomline.ru)
 * @version 1.2
 * @copyright (C) 2008-2012 by JoomLine (http://www.joomline.net)
 * @license JoomLine: http://joomline.net/licenzija-joomline.html
 *
*/
global $rez;

$variant = $_POST['variant'];
$typeGet = $_POST['tpget'];
$curl = $_POST['curl'];
if ($variant!='gp'){
	if ($typeGet==0){$request = @file_get_contents($curl);/*$msg='GET FILEGETCONTENT';*/}
		else {
			$ch = curl_init($curl);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; ru-RU; rv:1.9.2) Gecko/20100115 AdCentriaIM/1.7 Firefox/3.6 GTB6 (.NET CLR 3.5.30729)");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$request = curl_exec($ch);
			curl_close($ch);
			//$msg='GET CURL';
		}
        $tmp = array();
}		

		switch ($variant) {
			case 'od': $pattern = "/^ODKL.updateCountOC\('[\d\w]+','(\d+)','(\d+)','(\d+)'\);$/i";break;
			//case 'gp': $pattern = "/\<div id\=\"aggregateCount\" class\=\"V1\"\>(\d+)\<\/div\>/i";break;
			case 'gp': $count = get_plusones($curl); echo $count; break;
			case 'mail': $pattern = "{\"shares\":(\d+),\"clicks\":(\d+)}";break;			
			case 'ya': $pattern = "/(.+?)Ya.Share.showCounter(([^<]+)(\d+)([^<]+))(.+?)/i";break;			
			case 'lin': $pattern = '/^IN.Tags.Share.handleCount\({"count":(\d+),"fCnt":"(\d+)","fCntPlusOne":"(\d+)","url":"(.*?)"}\);$/i';break;			
		}	
		if ($variant!='gp'){	
			preg_match($pattern,$request,$tmp);
			if ($variant=='ya'){if (isset($tmp[4][0])) {echo $tmp[4][0];}} else {if (isset($tmp[1])) {echo $tmp[1];} else {echo '';}}
			//echo $msg;
		}
		
function get_plusones($url) {
	$ch = curl_init();  
	curl_setopt($ch, CURLOPT_URL, "https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	$curl_results = curl_exec ($ch);
	curl_close ($ch);
	//var_dump($curl_results);
	$json = json_decode($curl_results, true);
	return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
}
	
?>

