<?php
namespace MKFramework\View;

use MKFramework;
use MKFramework\Director;

class Helper
{

    protected $_headCssFiles;

    protected $_headJsFiles;

    /**
     * This Helper generate relative path to resource file,
     * eg.
     * css files, scripts or images.
     *
     * At default $addModulePath as TRUE this function
     * adds path to modules/MODULE/ folder.
     *
     * @param string $file
     *            Name of the file, relative to index.php (or to module folder)
     * @param boolean $addModulePath
     *            If FALSE, function do not add module path (so, file is relative to index.php folder)
     *            
     * @return string
     */
    public function resource($file, $addModulePath = true)
    {
        $module = MKFramework\Director::getModuleName();
        $addPath = '';
        if (($module != 'default') && ($addModulePath)) {
            $addPath = 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR;
        }
        return $addPath . $file;
    }
    
    /* CSS FILES SUPPORT */
    public function getHeadCss()
    {
        foreach ($this->_headCssFiles as $file) {
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$file}\">";
        }
    }

    public function addHeadCssFile($file, $addModulePath = true)
    {
        $module = MKFramework\Director::getModuleName();
        $addPath = '';
        if ($module != 'default') {
            if ($addModulePath) {
                $addPath = DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR;
            } else {
                $addPath = DOCUMENT_ROOT . DIRECTORY_SEPARATOR;
            }
        } else {
            $addPath = DOCUMENT_ROOT . DIRECTORY_SEPARATOR;
        }
        
        $this->_headCssFiles[] = $addPath . $file;
    }
    
    /* JavaScript FILES SUPPORT */
    public function getHeadJs()
    {
        foreach ($this->_headJsFiles as $file) {
            echo "<script type=\"text/javascript\" src=\"{$file}\"></script>";
        }
    }

    public function addHeadJsFile($file, $addModulePath = true)
    {
        $module = MKFramework\Director::getModuleName();
        $addPath = '';
        if ($module != 'default') {
            if ($addModulePath) {
                $addPath = DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR;
            } else {
                $addPath = DOCUMENT_ROOT . DIRECTORY_SEPARATOR;
            }
        } else {
            $addPath = DOCUMENT_ROOT . DIRECTORY_SEPARATOR;
        }
        $this->_headJsFiles[] = $addPath . $file;
    }

    /**
     * Create prepared url.
     *
     * @param array $routing
     *            = array('module' => MODULE, 'controller' => CONTROLLER, 'job' => JOB, 'params' => array(PARAMS))
     *            
     */
    public function getUrl($routing)
    {
        $router = MKFramework\Director::getRouter();
        return $router->prepareUrl($routing);
    }
}

?>