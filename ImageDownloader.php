<?php
/**
 * Created by PhpStorm.
 * User: Denis Rudenko
 */
namespace ifonetwork\imagedownloader;

use Exception;

class ImageDownloader
{

    /**
     * @var array allowed file extensions
     */
    protected $_extensions = ["jpg", "png", "gif"];

    /**
     * @var string path for saved files
     */
    protected $_path = '';

    /**
     * @var string prefix for saved files
     */
    protected $_prefix = '';

    /**
     * @var array  downloading errors
     */
    protected $_errors = [];

    /*
     * @var array  FileModel saved files
     */
    protected $_files = [];

    /*
     * @var array   file url array
     */
    protected $_urls = [];

    /**
     * Set the basic   url for parsing
     * @param array $url for parsing
     */

    public function __construct($urls)
    {

        $this->_urls = $urls;
    }

    /**
     * Set the basic path for saving files
     * @param string $path for parsing
     */

    public function savePath($path)
    {
        $this->_path = $path;
    }

    /**
     * Set the prefix for saved files
     * @param string $prefix for parsing
     */

    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
    }


    /**
     * Start  download and save files
     * @return boolean  the result of downloading
     */
    public function download()
    {
        if (is_array($this->_urls) === FALSE) {
            $this->addError("Filelist is not array");
            return false;
        }

        foreach ($this->_urls as $url) {
            if (!in_array(end(explode(".", $url)), $this->_extensions)) {
                $this->addError("Wrong file extension");
                continue;
            }


            $this->downloadFile($url);
        }

        return $this->hasErrors() ? false : true;
    }


    /**
     * Returns a value indicating whether there is any error.
     * @return boolean  whether there is any error.
     */
    public function hasErrors()
    {
        return count($this->errors()) > 0 ? true : false;

    }


    /**
     * Add the error to array of errors
     * @param string $error error description
     */
    protected function addError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * Returns the errors  array
     * @return array the errors  array
     */
    public function errors()
    {
        return $this->_errors;
    }


    /**
     * Returns the filelist  models array
     * @return array  the  FileModel  array
     */
    public function filesList()
    {
        return $this->_files;

    }

    /**
     * Download   add  save file
     * @param $url the current file full url
     */
    protected function downloadFile($url)
    {

        $filepath = $this->_path . $this->_prefix . basename($url);
        if (file_exists($filepath)) {
            $filepath = $this->_path . $this->_prefix . date('Y_m_d_H_i_s') . basename($url);

        }
        $filename = basename($filepath);

        try {

            $fp = fopen($filepath, 'w+');
            if (!$fp) {
                throw new Exception('File save failed, check path');
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            $response = curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            if ($response === false) {
                throw new Exception("Error while downloading file " . $url);
            }

        } catch (Exception $e) {
            $this->addError($e->getMessage());
        }

        $this->_files[] = new FileModel($filename, $url);


    }


}