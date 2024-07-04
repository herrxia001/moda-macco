<?php
/* 	
	File:		getVIES.php
	Purpose: 	Check VAT Number via VIES
	Return: 	VIES return
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

if(isset($_GET['countrycode']) && isset($_GET['vatnumber']))
{
	$client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
    if(!$client) {
        $error = "web service at ec.europa.eu unavailable";
        goto QH;
    }
    try {
        $response = $client->checkVat(array(
            'countryCode' => $_GET['countrycode'],
            'vatNumber' => $_GET['vatnumber']
        ));
    }
    catch (SoapFault $e) {
        $faults = array (
            'INVALID_INPUT'       => '国家代码有误或税号为空',
            'SERVICE_UNAVAILABLE' => '欧盟税号服务暂时问题, 请稍后再试',
            'MS_UNAVAILABLE'      => '该国家税号服务暂时问题, 请稍后再试',
            'TIMEOUT'             => '该国家税号服务无法连接, 请稍后再试',
            'SERVER_BUSY'         => '欧盟税号服务无法处理请求, 请稍后再试'
        );
        $error = $faults[$e->faultstring];
        if (!is_set($error))
            $error = $e->faultstring;
        goto QH;
    }
    if (!$response->valid) {
        $error = "VAT Number INVALID";
        goto QH;
    }
    $retval = "VAT Number VALID";
    foreach ($response as $key => $prop) {
        $retval .= "\n".$key.": ".str_replace('"', '\"', $prop)."";
        if ($key == 'name')
            $name = $prop;
        else if ($key == 'address')
            $address = $prop;
    }
    $retval .= "\n";
    echo $retval;
	return;
QH:
    echo "欧盟税号查询结果: 错误"."\n"."错误代码: ".$error;
	return;

}
else
	echo '缺少信息';


?>
