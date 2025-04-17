<?Php

class IdEnHash
	{
		public static function getHash($vAlgoritmo, $vData, $vKey)
			{
				$vHash = hash_init($vAlgoritmo, HASH_HMAC, $vKey);
				hash_update($vHash, $vData);
				
				return hash_final($vHash);
			}
	}
?>