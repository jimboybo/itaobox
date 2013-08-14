<?php
class Utils{
	/**
	 * 去除划线
	 * @param string $input
	 * @param string $split
	 * @param bool $lower
	 */
	public static function camelize($input,$split='_', $lower = false){
		$result    = '';
		$words     = explode($split, $input);
		$wordCount = count($words);
		for ($i = 0; $i < $wordCount; $i++) {
			$word = $words[$i];
			if (!($i === 0 && $lower === false)) {
				$word = ucfirst($word);
			} else {
				$word = strtolower($word);
			}
			$result .= $word;
		}
		return $result;
	}
	/**
	 * 读取Cache文件
	 * @param Cache_Lite $oCache
	 * @param string $id
	 * @param string $group
	 */
	public static function getCache($oCache,$id,$group){
		if (extension_loaded('zlib')) {
			if($result = $oCache->get($id,$group,true)){
				return unserialize(gzuncompress($result));
			}
		}
		return false;
	}
	/**
	 * 保存Cache文件
	 * @param Cache_Lite $oCache
	 * @param string $id
	 * @param string $group
	 * @param array $data
	 * @param string $cachePath
	 */
	public static function saveCache($oCache,$id,$group,$data,$cachePath){
		if (is_writable($cachePath) && extension_loaded('zlib')) {
			$data = gzcompress(serialize($data), 9);
			return $oCache->save($data,$id,$group);
		}
		return false;
	}
	/**
	 * 删除Cache文件
	 * @param Cache_Lite $oCache
	 * @param string $id
	 * @param string $group
	 */
	public static function removeCache($oCache,$id,$group){
		return $oCache->remove($id, $group);
	}
}