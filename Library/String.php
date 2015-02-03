<?php
/**
 * 字符串操作
 *
 * Created		: 2012-06-21
 * Modified		: 2013-04-02
 * @link		: http://www.59c.net
 * @copyright	: (C) 2012 - 2014 59C.NET
 * @version		: 1.0.0
 * @author		: Joseph Chen (chenliq@gmail.com)
 */
class String
{
	const RAND_INT		= 1;
	const RAND_LOWER	= 2;
	const RAND_UPPER	= 4;
	const RAND_SYMBOL	= 8;
	/**
	 * 用于ID加密密钥
	 * @var string
	 */
	public static $_id_crypt_key = 'N4Q1baT4Fw02sL';
	
	/**
	 * 计算含多字节字符串的长度（半角字符半个长度，全角字符一个长度）
	 * @param string $str
	 * @return number
	 */
	public static function strlen($str)
	{
		$mblen = mb_strlen($str);
		$len = $mblen;
		for ($i=0; $i<$mblen; $i++)
		{
			$char = mb_substr($str, $i, 1);
			if (strlen($char) == 1)
			{
				$len -= 0.5;
			}
		}
		return $len;
	}

	/**
	 * 判断字符串是否含列表中指定的任意一个子字符串，strpos
	 * @param string $haystack
	 * @param array $needle
	 * @param boolean $case
	 */
	public static function pos($haystack, $needle, $case=false)
	{
		foreach ($needle as $str)
		{
			if ($case)
			{
				$pos = strpos($haystack, $str);
				if (false !== $pos)
				{
					return $pos;
				}
			} else {
				$pos = stripos($haystack, $str);
				if (false !== $pos)
				{
					return $pos;
				}
			}
		}
		return false;
	}
	
	/**
	 * 多字节字符串的截取（半角字符半个长度，全角字符一个长度）
	 * @param string $str
	 * @return number
	 */
	public static function strcut($str, $len)
	{
		$mblen = mb_strlen($str);
		$cut = '';
		$cutLen = 0;
		for ($i=0; $i<$mblen; $i++)
		{
			$char = mb_substr($str, $i, 1);
			if (strlen($char) == 1)
			{
				$cutLen += 0.5;
			} else {
				$cutLen += 1;
			}
			if ($cutLen > $len)
			{
				break;
			}
			$cut .= $char;
		}
		return $len;
	}

	/**
	 * 判断一个变量是否是纯数字
	 * @param string|int $s
	 * @return boolean
	 */
	public static function isDigit($s)
	{
		return (is_int($s) || ctype_digit($s));
	}
	
	/**
	 * 判断变量是否纯数字ID的组合字符串(数字字符串用","分隔)
	 * @param int | string $s
	 * @return Boolean
	 */
	public static function digitSepBunch($s)
	{
		return (preg_match('/^(?:[\d]+\,{0,1})+[\d]+$/', $s));
	}
	
	/**
	 * 将逗号分隔字符串各段加上引号
	 * @param string $str
	 * @return string
	 */
	public static function quoteCommaSplitStr($str)
	{
		$str = addslashes($str);
		return "'".str_replace(',', "','", $str)."'";
	}

	/**
	 * 随机一个字符串
	 * @param int $len
	 * @param int $type
	 * @param string $exceptChars 需要排除的字符
	 */
	public static function rand($len=8, $type=7, $exceptChars='01iIlLoO')
	{
		$numeric = '0123456789';
		$lower	= 'abcdefghijklmnopqrstuvwxyz';
		$upper	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$symbol  = '`~!@#$%^&*()-_=+[{]}/\\|;:\'",<.>/?';
		$ret = $str = '';
		($type & self::RAND_INT) && $str .= $numeric;
		($type & self::RAND_LOWER) && $str .= $lower;
		($type & self::RAND_UPPER) && $str .= $upper;
		($type & self::RAND_SYMBOL) && $str .= $symbol;
		for($i=0; $i<$len; $i++)
		{
			$rnd = mt_rand(0, strlen($str)-1);
			$char = $str[$rnd];
			if (false !== strpos($exceptChars, $char))
			{
				$i--;
				continue;
			}
			$ret .= $char;
		}
		return $ret;
	}

	/**
	 * 获取ID基数的路径
	 * @param number $id
	 * @param number $lvl
	 */
	public static function getIdRadixPath($id, $radix=1000, $lvl=3)
	{
		$str = '';
		for ($i=0; $i<$lvl; $i++)
		{
			$str .= floor($id/$radix).'/';
		}
		return $str;
	}

	/**
	 * 将一个ID编码
	 * @param int $id
	 */
	public static function idEncode($id)
	{
		$idLen = strlen($id);
		$_len = $idLen;
		$str = $id;
		$minLen = $GLOBALS['_id_encode_minlen'];
		while(true)
		{
			if ($_len>=$minLen) break;
			$str .= substr($GLOBALS['_id_encode_salt_digit'], 0, $minLen-$_len);
			$_len += $idLen;
		}
		$str = UMath::dec2any($str);
		return substr($str, -3).UMath::dec2any($idLen+20).substr($str, 0, -3);
	}

	/**
	 * 解码一个字符串为ID值
	 * @param string $str
	 */
	public static function idDecode($str)
	{
		$idLen = UMath::any2dec(substr($str, 3, 1))-20;
		$str = substr($str, 4).substr($str, 0, 3);
		$value = UMath::any2dec($str);
		return substr($value, 0, $idLen);
	}

	/**
	 * 将一个ID加密并base64编码
	 * @param int $id
	 * @return string $str
	 */
	public static function idEncode64($id)
	{
		$key = self::idCryptKey();
		$salt = strrev($key);
		$id = (string)$id;
		$str = '';
		$pos = 0;
		$len = strlen($id);
		$keyLen = strlen($key);
		if ($len < $keyLen)
		{
			$id .= '|'.substr($salt, 0, $keyLen-$len);
			$len = strlen($id);
		}
		for ($i=0; $i<$len; $i++)
		{
			if (isset($key[$i]))
			{
				$char = $key[$i];
				$pos++;
			} else {
				$pos = 0;
				$char = $key[0];
			}
			$c = $id[$i] ^ $char;
			$str .= $c;
		}
		$str = base64_encode($str);
		return $str;
	}

	/**
	 * 解密并base64编码一个字符串为ID值
	 * @param string $str
	 * @return int $id
	 */
	public static function idDecode64($str)
	{
		$key = self::idCryptKey();
		$id = '';
		$pos = 0;
		$str = base64_decode($str);
		$len = strlen($str);
		for ($i=0; $i<$len; $i++)
		{
			if (isset($key[$i]))
			{
				$char = $key[$i];
				$pos++;
			} else {
				$pos = 0;
				$char = $key[0];
			}
			$c = $str[$i] ^ $char;
			if ($c == '|')
			{
				break;
			}
			$id .= $c;
		}
		return $id;
	}

	/**
	 * 加密ID数字为一个字符串
	 * @param int $id
	 * @return string
	 */
	public static function idCrypt($id)
	{
		$len = strlen($id);
		$key = self::idCryptKey($len);
		$salt = strrev($key);
		$char = substr($salt, 0, 1);
		// 强制salt首字符为字母
		if (ctype_digit($char))
		{
			$char += 10;
			$salt = base_convert($char, 10, 36).substr($salt, 1);
		}

		$lenChar = UMath::dec2any($len);
		$str = '';
		$keyLen = strlen($key);
		if ($len < $keyLen)
		{
			$id .= substr($salt, 0, $keyLen-$len);
		} else if ($len >= $keyLen) {
			$key .= substr($key, 0, $len-$keyLen+1);
			$keyLen = strlen($key);
			// $id 后一定要有附加串，避免最后一位为0且长度大于key时无法识别
			$id .= $char;
		}
		for ($i=0; $i<$keyLen; $i++)
		{
			if ($i <= $len)
			{
				$val = $id[$i];
			} else {
				$val = UMath::any2dec($id[$i]);
			}
				
			$sum = $val + UMath::any2dec($key[$i]);
			$tmp = UMath::dec2any($sum);
			$str .= $tmp;
		}
		
		$pos = floor(strlen($str)/2);
		$str = substr($str, 0, $pos).$lenChar.substr($str, $pos);

		return $str;
	}

	/**
	 * 解密一个字符串为ID数字
	 * @param string $str
	 * @return string
	 */
	public static function idDeCrypt($str)
	{
		$pos = floor((strlen($str)-1)/2);
		$idLen = UMath::any2dec(substr($str, $pos, 1));
		$key = self::idCryptKey($idLen);
		$keyLen = strlen($key);
		$id = '';
		$strLen = strlen($str);
		if ($keyLen < $strLen)
		{
			$key .= substr($key, 0, $strLen-$keyLen+1);
		}
		$ki = 0;
		$str = substr($str, 0, $pos).substr($str, $pos+1);
		for ($i=0; $i<$strLen; $i++,$ki++)
		{
			$val = UMath::any2dec($str[$i]);
			$kVal = UMath::any2dec($key[$ki]);
			if ($val < $kVal)
			{

				if (isset($str[$i+1]))
				{
					$val = UMath::any2dec($str[$i].$str[$i+1]);
				} else {
					$val = UMath::any2dec($str[$i]);
				}
				$i++;
			}
			$tmp = $val - $kVal;
			if (strlen($id) == $idLen)
			{
				break;
			}
			$id .= $tmp;
		}

		return $id;
	}

	/**
	 * 设置/获取ID加密密钥
	 * @param string $key
	 * @return string
	 */
	public static function idCryptKey($len=6)
	{
		if ($len<5)
		{
			$len = 5;
		}
		return substr(self::$_id_crypt_key, 0, $len);
	}

}