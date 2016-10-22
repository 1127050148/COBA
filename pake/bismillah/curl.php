<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Curl {
	
	var $headers;
	var $user_agent;
	var $compression;
	var $cookie_file;
	var $proxy;
	var $cookies;

	function cURL($cookies=TRUE,$cookie='cookie/cookie.txt',$compression='gzip',$proxy='') 
	{
		//$this->headers[] = 'Accept: text/html,application/xhtml+xml,application/xml, image/gif, image/x-bitmap, image/jpeg, image/pjpeg, image/png';
		$this->headers[] = 'Accept: text/html,application/xhtml+xml,application/xml';
		$this->headers[] = 'Connection: Keep-Alive';
		$this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$this->user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13';
		$this->compression=$compression;
		$this->proxy=$proxy;
		$this->cookies=$cookies;
	}
	function postarena($url,$url2,$data,$cookie){
		$ch = curl_init();
	}
	
	function get($url,$url2,$cookie) 
	{	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_REFERER, $url2);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch,CURLOPT_ENCODING , $this->compression);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, '300');
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		if ($this->proxy) curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		
		if($result === false)
		{
			$resultData['error_no']		= curl_errno($ch);
			$resultData['error_msg']	= curl_error($ch);
		}
		else
		{
			$resultData['error_no']		= "0";
			$resultData['result']		= $result;
		}
		
		return $resultData;
		curl_close($ch);
	}
	function post($url,$url2,$data,$cookie) 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($ch, CURLOPT_REFERER, $url2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3); 
		curl_setopt($ch, CURLOPT_ENCODING , $this->compression);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, '300');
		curl_setopt($ch, CURLOPT_TIMEOUT , '300' );
		curl_setopt($ch, CURLOPT_MAXREDIRS , '3' );
		//curl_setopt($ch, CURLOPT_FAILONERROR,true);
		
		//for windows
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch, CURLOPT_COOKIESESSION, false);
		 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		if ($this->proxy) curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$result = curl_exec($ch);
		
		if($result === false)
		{
			$resultData['error_no']		= curl_errno($ch);
			$resultData['error_msg']	= curl_error($ch);
		}
		else
		{
			$resultData['error_no']		= "0";
			$resultData['result']		= $result;
		}
		
		return $resultData;
		curl_close($ch);
	}
	
	
	function post_custom ($url, $url2, $data, $cookie, $CONNECTTIMEOUT='300', $TIMEOUT='300', $pRequest='post') 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($ch, CURLOPT_REFERER, $url2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_ENCODING , $this->compression);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $CONNECTTIMEOUT);
		curl_setopt($ch, CURLOPT_TIMEOUT , $TIMEOUT );
		curl_setopt($ch, CURLOPT_MAXREDIRS , '3' );
		//curl_setopt($ch, CURLOPT_FAILONERROR,true);
		
		//for windows
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch, CURLOPT_COOKIESESSION, false);
		
		if ($pRequest == 'post'){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		
		if ($this->proxy) curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$result = curl_exec($ch);
		
		if($result === false)
		{
			$resultData['error_no']		= curl_errno($ch);
			$resultData['error_msg']	= curl_error($ch);
		}
		else
		{
			$resultData['error_no']		= "0";
			$resultData['result']		= $result;
		}
		
		return $resultData;
		curl_close($ch);
	}

	
}

		/*$error_codes=array(
		[1] => 'CURLE_UNSUPPORTED_PROTOCOL', 
		[2] => 'CURLE_FAILED_INIT', 
		[3] => 'CURLE_URL_MALFORMAT', 
		[4] => 'CURLE_URL_MALFORMAT_USER', 
		[5] => 'CURLE_COULDNT_RESOLVE_PROXY', 
		[6] => 'CURLE_COULDNT_RESOLVE_HOST', 
		[7] => 'CURLE_COULDNT_CONNECT', 
		[8] => 'CURLE_FTP_WEIRD_SERVER_REPLY',
		[9] => 'CURLE_REMOTE_ACCESS_DENIED',
		[11] => 'CURLE_FTP_WEIRD_PASS_REPLY',
		[13] => 'CURLE_FTP_WEIRD_PASV_REPLY',
		[14]=>'CURLE_FTP_WEIRD_227_FORMAT',
		[15] => 'CURLE_FTP_CANT_GET_HOST',
		[17] => 'CURLE_FTP_COULDNT_SET_TYPE',
		[18] => 'CURLE_PARTIAL_FILE',
		[19] => 'CURLE_FTP_COULDNT_RETR_FILE',
		[21] => 'CURLE_QUOTE_ERROR',
		[22] => 'CURLE_HTTP_RETURNED_ERROR',
		[23] => 'CURLE_WRITE_ERROR',
		[25] => 'CURLE_UPLOAD_FAILED',
		[26] => 'CURLE_READ_ERROR',
		[27] => 'CURLE_OUT_OF_MEMORY',
		[28] => 'CURLE_OPERATION_TIMEDOUT',
		[30] => 'CURLE_FTP_PORT_FAILED',
		[31] => 'CURLE_FTP_COULDNT_USE_REST',
		[33] => 'CURLE_RANGE_ERROR',
		[34] => 'CURLE_HTTP_POST_ERROR',
		[35] => 'CURLE_SSL_CONNECT_ERROR',
		[36] => 'CURLE_BAD_DOWNLOAD_RESUME',
		[37] => 'CURLE_FILE_COULDNT_READ_FILE',
		[38] => 'CURLE_LDAP_CANNOT_BIND',
		[39] => 'CURLE_LDAP_SEARCH_FAILED',
		[41] => 'CURLE_FUNCTION_NOT_FOUND',
		[42] => 'CURLE_ABORTED_BY_CALLBACK',
		[43] => 'CURLE_BAD_FUNCTION_ARGUMENT',
		[45] => 'CURLE_INTERFACE_FAILED',
		[47] => 'CURLE_TOO_MANY_REDIRECTS',
		[48] => 'CURLE_UNKNOWN_TELNET_OPTION',
		[49] => 'CURLE_TELNET_OPTION_SYNTAX',
		[51] => 'CURLE_PEER_FAILED_VERIFICATION',
		[52] => 'CURLE_GOT_NOTHING',
		[53] => 'CURLE_SSL_ENGINE_NOTFOUND',
		[54] => 'CURLE_SSL_ENGINE_SETFAILED',
		[55] => 'CURLE_SEND_ERROR',
		[56] => 'CURLE_RECV_ERROR',
		[58] => 'CURLE_SSL_CERTPROBLEM',
		[59] => 'CURLE_SSL_CIPHER',
		[60] => 'CURLE_SSL_CACERT',
		[61] => 'CURLE_BAD_CONTENT_ENCODING',
		[62] => 'CURLE_LDAP_INVALID_URL',
		[63] => 'CURLE_FILESIZE_EXCEEDED',
		[64] => 'CURLE_USE_SSL_FAILED',
		[65] => 'CURLE_SEND_FAIL_REWIND',
		[66] => 'CURLE_SSL_ENGINE_INITFAILED',
		[67] => 'CURLE_LOGIN_DENIED',
		[68] => 'CURLE_TFTP_NOTFOUND',
		[69] => 'CURLE_TFTP_PERM',
		[70] => 'CURLE_REMOTE_DISK_FULL',
		[71] => 'CURLE_TFTP_ILLEGAL',
		[72] => 'CURLE_TFTP_UNKNOWNID',
		[73] => 'CURLE_REMOTE_FILE_EXISTS',
		[74] => 'CURLE_TFTP_NOSUCHUSER',
		[75] => 'CURLE_CONV_FAILED',
		[76] => 'CURLE_CONV_REQD',
		[77] => 'CURLE_SSL_CACERT_BADFILE',
		[78] => 'CURLE_REMOTE_FILE_NOT_FOUND',
		[79] => 'CURLE_SSH',
		[80] => 'CURLE_SSL_SHUTDOWN_FAILED',
		[81] => 'CURLE_AGAIN',
		[82] => 'CURLE_SSL_CRL_BADFILE',
		[83] => 'CURLE_SSL_ISSUER_ERROR',
		[84] => 'CURLE_FTP_PRET_FAILED',
		[84] => 'CURLE_FTP_PRET_FAILED',
		[85] => 'CURLE_RTSP_CSEQ_ERROR',
		[86] => 'CURLE_RTSP_SESSION_ERROR',
		[87] => 'CURLE_FTP_BAD_FILE_LIST',
		[88] => 'CURLE_CHUNK_FAILED');*/
		
?>
