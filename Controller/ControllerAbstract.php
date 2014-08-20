<?php
namespace MKFramework\Controller;

use MKFramework\Director;

abstract class ControllerAbstract
{

    protected $_director;

    protected $view;

    protected $layout;

    function __construct()
    {
        $this->_director = Director::getInstance();
        $this->view = Director::getView();
        $this->layout = Director::getLayout();
    }

    protected function preLauncher()
    {}

    protected function postLauncher()
    {}

    public function getJobContent($jobMethodName)
    {
        // wykonaj działania przed uruchomieniem akcji
        $this->preLauncher();
        
        // uruchom Job
        $this->$jobMethodName();
        
        // ustaw plik widoku
        $this->view->setView($this->_director->getControllerName(), $this->_director->getJobName());
        
        // wyrenderuj zawartosc widoku
        $viewOutput = $this->view->render();
        
        // uruchom dzia�ania po renderingu
        $this->postLauncher();
        
        // wy�wietl wyrenderowany widok
        // TODO docelowo tu ma tego nie by�
        // TODO $this->view->show() // lub cos podobnego
        
        return $viewOutput;
    }

    public function __call($actionName, $sec)
    {
        // TODO rzuc wyjatek jesli wywolano nieistniejaca akcje
        echo 'nie znaleziono akcji w tym kontrolerze <br><br><br>';
        
        echo 'module: ' . $this->_director->getModuleName() . '<br>';
        echo 'controller: ' . $this->_director->getControllerName() . '<br>';
        echo 'job: ' . $this->_director->getJobName() . '<br>';
        
        // throw new \MKFramework\Exception\Exception("nie ma akcji <b>{$actionName}</b> w tym kontrolerze");
    }
}
