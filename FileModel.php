<?php
/**
 * Created by PhpStorm.
 * User: Denis Rudenko
 */
namespace ifonetwork\imagedownloader;

class FileModel
{

    /**
     * @var string name of file
     */
    protected $_name;

    /**
     * @var string original file url
     */
    protected $_original_url;



    /**
     * FileModel constructor.
     * @param string $_name
     * @param string $_original_url
     * @param string $_file_size
     */
    public function __construct($_name, $_original_url)
    {
        $this->_name = $_name;
        $this->_original_url = $_original_url;

    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getOriginalUrl()
    {
        return $this->_original_url;
    }


}