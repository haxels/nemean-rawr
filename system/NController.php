<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/2/12
 * Time: 5:08 PM
 * To change this template use File | Settings | File Templates.
 */
abstract class NController
{
    protected $session;
    protected $moduleName;

    /**
     * Used for methods that uses views
     *
     * @abstract
     * @return mixed
     */
    public abstract function display();

    /**
     * Used for methods that do not use views
     *
     * @abstract
     * @return mixed
     */
    public abstract function quickActions();

    /**
     * Method for loading a view (include the view file)
     *
     * @param $view
     * @param array $data
     * @throws Exception
     */
    protected function loadView($view, array $data = array())
    {
        $filePath = MODULEPATH.$this->moduleName.'/views/'.$view.'.php';

        if (!file_exists($filePath))
        {
            throw new Exception('View not found');
        }
        require_once $filePath;
    }
}
