<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 10.08.12
 * Time: 20:28
 * To change this template use File | Settings | File Templates.
 */
class FileBrowser
{
    private $path;
    private $files;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function view()
    {
        if (!is_dir($this->path))
        {
            // No such directory
            return;
        }

        if ($handle = opendir($this->path))
        {
            $files = array();
            while (false !== ($entry = readdir($handle)))
            {
                if (is_file($this->path . $entry))
                {
                    $files[] = $entry;
                }
            }
            closedir($handle);

            rsort($files);
            foreach($files as $file)
            {
                if ($file != '.' || $file != '..')
                {
                    echo '<a id="'.$file.'" class="listed_file">'.$file . '</a><br />';
                }
            }
        }
    }
}
