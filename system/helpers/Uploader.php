<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 10.08.12
 * Time: 17:31
 * To change this template use File | Settings | File Templates.
 */
require_once 'File.php';

class Uploader
{
    private $path;
    private $files;

    private $maxFilesize;
    private $extensions;
    private $errors;
    private $imgExtensions = array('png', 'jpg', 'jpeg');
    private $validateLength = false;
    private $validImgWidth;
    private $validImgHeight;

    public function __construct($path = '', array $files = array(), $filesize = 10000, array $extensions = array())
    {
        $this->path         = $path;
        $this->files        = $files;
        $this->maxFilesize  = $filesize;
        $this->extensions   = $extensions;
        $this->errors       = array();
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function addFile(File $file)
    {
        $this->files[] = $file;
    }

    public function setMaxFilesize($size = 10000)
    {
        $this->maxFilesize = $size;
    }

    public function setValidExtensions(array $extensions = array())
    {
        $this->extensions = $extensions;
    }

    public function setValidImgLengths($width, $height)
    {
        $this->validImgWidth    = $width;
        $this->validImgHeight   = $height;
    }

    public function doValidateLength()
    {
        $this->validateLength = true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return (count($this->errors) > 0);
    }

    public function upload()
    {
        $this->validateFiles();
        $this->checkPath();

        if ($this->hasErrors())
        {
            return;
        }

        foreach ($this->files as $file)
        {
            if (is_uploaded_file($file->getTmpName()))
            {
                move_uploaded_file($file->getTmpName(), $this->path . $file->getName());
            }
        }
        return true;
    }

    private function checkPath()
    {
        if (!is_dir($this->path))
        {
            $this->errors[] = 'Path doesn\'t exist.';
        }
        elseif (!is_writeable($this->path))
        {
            $this->errors[] = 'Path is not writable.';
        }
    }

    private function checkFilesize($size)
    {
        return ($size <= $this->maxFilesize);
    }

    private function checkExtension($extension)
    {
        return (in_array($extension, $this->extensions));
    }

    private function validateFiles()
    {
        foreach ($this->files as $file)
        {
            if (!$this->checkExtension($file->getExtension()))
            {
                $this->errors[$file->getName()] = 'Invalid extension. '.$file->getName();
            }
            elseif (!$this->checkFilesize($file->getSize()))
            {
                $this->errors[$file->getName()] = 'File to large. '.$file->getName();
            }
            /*
            elseif ($this->validateLength && $this->isImage($file) && !$this->validateImgLengths($file))
            {
                //$this->errors[$file->getName()] = 'Image width or height not valid.';
            }
            */
        }
    }

    private function validateImgLengths(File $file)
    {
        list($width, $height) = getimagesize($file->getTmpName());
        return ( ($width == $this->validImgWidth) && ($height == $this->validImgHeight) );
    }

    private function isImage($file)
    {
        return (in_array($file->getExtension(), $this->imgExtensions));
    }
}
