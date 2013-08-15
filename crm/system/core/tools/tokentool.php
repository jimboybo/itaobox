<?php
class TokenTool{
	/**
	 * 生成令牌
	 * @param len 用于规定令牌的长度
	 * @param md5 是个布尔值，用于选择是否使用md5
	 */
	function genToken( $len = 32, $md5 = true ) {
        # Seed random number generator
        # Only needed for PHP versions prior to 4.2
        mt_srand( (double)microtime()*1000000 );
        # Array of characters, adjust as desired
        $chars = array(
            'Q', '@', '8', 'y', '%', '^', '5', 'Z', '(', 'G', '_', 'O', '`',
            'S', '-', 'N', '<', 'D', '{', '}', '[', ']', 'h', ';', 'W', '.',
            '/', '|', ':', '1', 'E', 'L', '4', '&', '6', '7', '#', '9', 'a',
            'A', 'b', 'B', '~', 'C', 'd', '>', 'e', '2', 'f', 'P', 'g', ')',
            '?', 'H', 'i', 'X', 'U', 'J', 'k', 'r', 'l', '3', 't', 'M', 'n',
            '=', 'o', '+', 'p', 'F', 'q', '!', 'K', 'R', 's', 'c', 'm', 'T',
            'v', 'j', 'u', 'V', 'w', ',', 'x', 'I', '$', 'Y', 'z', '*'
        );
        # Array indice friendly number of chars;
        $numChars = count($chars) - 1; $token = '';
        # Create random token at the specified length
        for ( $i=0; $i<$len; $i++ )
            $token .= $chars[ mt_rand(0, $numChars) ];
			# Should token be run through md5?
        if ( $md5 ) {
            # Number of 32 char chunks
            $chunks = ceil( strlen($token) / 32 ); $md5token = '';
            # Run each chunk through md5
            for ( $i=1; $i<=$chunks; $i++ )
                $md5token .= md5( substr($token, $i * 32 - 32, 32) );
			# Trim the token
			$token = substr($md5token, 0, $len);
        }
		return $token;
    }
	
	/**
	 * 生成随机密码
	 * @param len 是密码长度
	 * @param special 让你决定是否在密码中包含特殊字符
	 */
	function genPasswd( $len = 8, $special = true ) {
        # Seed random number generator
        
		# Only needed for PHP versions prior to 4.2
        mt_srand( (double)microtime()*1000000 );
 
        # Array of digits, lower and upper characters; empty passwd string
        $passwd = '';
        $chars = array(
			'digits' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
            'lower' => array(
                  'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
                  'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
            ),
            'upper' => array(
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
                'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
            )
        );
        # Add special chars to array, if permitted; adjust as desired
        if ( $special ) $chars['special'] = array(
            '!', '@', '#', '$', '%', '^', '&', '*', '_', '+'
        );
        # Array indices (ei- digits, lower, upper)
        $charTypes = array_keys($chars);
        # Array indice friendly number of char types
        $numTypes = count($charTypes) - 1;
          
        # Create random password
        for ( $i=0; $i<$len; $i++ ) {
            # Random char type
            $charType = $charTypes[ mt_rand(0, $numTypes) ];
            # Append random char to $passwd
            $passwd .= $chars[$charType][
                mt_rand(0, count( $chars[$charType] ) - 1 )
            ];
        }
		return $passwd;
    }
}
?>