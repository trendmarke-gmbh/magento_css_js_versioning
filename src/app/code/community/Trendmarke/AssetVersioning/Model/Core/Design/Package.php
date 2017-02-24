<?php
class Trendmarke_AssetVersioning_Model_Core_Design_Package extends Mage_Core_Model_Design_Package
{
	
	/**
	 * Checks file creation dates for newest one and returns it as timestamp
	 * thx to https://gist.github.com/smithweb/4746695
     * @param $files
     * @return timestamp
     */
    protected function getNewestFileTimestamp($srcFiles) {
        $timeStamp = null;
        foreach ($srcFiles as $file) {
            if(is_null($timeStamp)) {
                $timeStamp = filemtime($file);
            } else {
                $timeStamp = max($timeStamp, filemtime($file));
            }
        }
        return $timeStamp;
    }

    /**
     * Transforms merged css url and adds timestamp before extension
     * @overwrite
     * @param $files
     * @return string
     */
    public function getMergedCssUrl($files)
    {
        $_url = Parent::getMergedCssUrl($files);
        return str_replace (".css","",$_url).".".$this->getNewestFileTimestamp($files).".css";
    }

    /**
     * Transforms merged js url and adds timestamp before extension
     * @overwrite
     * @param $files
     * @return string
     */
    public function getMergedJsUrl($files)
    {
        $_url = Parent::getMergedJsUrl($files);
        return str_replace (".js","",$_url).".".$this->getNewestFileTimestamp($files).".js";
    }


    /**
     * additional fix for inline contents in mergend css files
     * thx to https://github.com/just-better/magento1-css-merge-data-uri-fix
     * @param string $file
     * @param string $contents
     * @return mixed|string
     */
    public function beforeMergeCss($file, $contents)
    {
        $this->_setCallbackFileDir($file);

        $cssImport = '/@import\\s+([\'"])(.*?)[\'"]/';
        $contents = preg_replace_callback($cssImport, array($this, '_cssMergerImportCallback'), $contents);

        $cssUrl = '/url\\(\\s*(?![\\\'\\"]?data:)([^\\)\\s]+)\\s*\\)?/';
        $contents = preg_replace_callback($cssUrl, array($this, '_cssMergerUrlCallback'), $contents);

        return $contents;
    }

}
		