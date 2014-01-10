<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 14.04.12
 * Time: 00:59
 * To change this template use File | Settings | File Templates.
 */
class Page
{
    private $mainContent;
    private $leftContent;
    private $rightContent;

    private $css;
    private $headerFile;
    private $footerFile;
    private $contentFile;

    private $settings;
    private $session;

    private $menu;

    public function __construct(Session $s, NController $mc = null,
                                ILeftContent $lc = null,
                                IRightContent $rc = null, array $css = array(),
                                array $settings = array(), MenuController $menu)
    {
        $this->session      = $s;
        $this->mainContent  = $mc;
        $this->leftContent  = $lc;
        $this->rightContent = $rc;
        $this->css          = $css;
        $this->settings     = $settings;
        $this->menu         = $menu;
    }

    public function addHeader($file = '')
    {
        $this->headerFile = $file;
    }

    public function addFooter($file = '')
    {
        $this->footerFile = $file;
    }

    public function addContent($file = '')
    {
        $this->contentFile = $file;
    }

    public function buildPage()
    {
        if ( $this->settings['site_closed']->getValue()
            && !$this->session->isAuthenticated() )
        {
            $error = $this->session->getError();
            require_once '/site/closed.php';
        }
        else
        {
            /** Header */
            $data['css'] = $this->css;
            $data['menu'] = $this->menu;
            $data['name'] = $this->session->getUser()->getName();
            $data['session'] = $this->session;
            $data['error'] = $this->session->getError();
            $data['settings'] = $this->settings;
            require_once 'site/' . $this->headerFile . '.php';

            /** Left content */
            // Må på sikt flyttes inn i de repektive html taggene
            $data['left'] = null;
            if ($this->leftContent != null)
            {
                $data['left'] = $this->leftContent;
            }

            /** Right content */
            // Må på sikt flyttes inn i de repektive html taggene
            if ($this->rightContent != null)
            {
                $this->rightContent->rightContent();
            }

            /** Main content */
            $data['content'] = null;
            if ($this->mainContent != null)
            {
                $data['content'] = $this->mainContent;
            }

            require_once 'site/' . $this->contentFile . '.php';

            /** Footer */
            require_once 'site/' . $this->footerFile . '.php';
        }
    }
}
