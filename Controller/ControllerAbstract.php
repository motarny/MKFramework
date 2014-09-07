<?php
namespace MKFramework\Controller;

use MKFramework\Director;
use MKFramework\View\View;
use MKFramework\View\Layout;
use MKFramework\Router\RouterAbstract;

/**
 * Klasa abstrakcyjna dla kontrolerów w aplikacji.
 *
 * @author Marcin
 *        
 */
abstract class ControllerAbstract
{

    /**
     * @var Director
     */
    protected $_director;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var Layout
     */
    protected $layout;

    /**
     * @var RouterAbstract
     */
    protected $_router;

    
    /**
     * Konstruktor kontrolera.
     */
    function __construct()
    {
        $this->_director = Director::getInstance();
        $this->view = Director::getView();
        $this->layout = Director::getLayout();
        $this->_router = Director::getRouter();
    }

    /**
     * Metoda pomocnicza zwracająca parametr lub wszystkie parametry z URL
     * za pomocą instancji Routera.
     * 
     * @param string $param nazwa parametru w URL
     * @return mixed
     */
    protected function getParams($param)
    {
        // Deleguje do obiektu Router
        return $this->_router->getParams($param);
    }

    /**
     * Metoda pomocnicza zwracająca wartość z formularza.
     * 
     * @param string $formFieldName
     * @return mixed
     */
    protected function getFormData($formFieldName)
    {
        // Deleguje do obiektu Router
        return $this->_router->getFormData($formFieldName);
    }

    /**
     * Metoda sprawdzająca, czy dany http request jest POST
     *  
     * @return boolean
     */
    protected function isPostRequest()
    {
        return $this->_router->isPostRequest();
    }

    /**
     * Metoda wykonywana przed wybranym Job
     */
    protected function preLauncher()
    {}

    /**
     * Metoda wykonywana po Job
     */
    protected function postLauncher()
    {}

    
    /**
     * Metoda wywołująca wykonanie konrektnego Job w danym kontrolerze.
     * 
     * @param string $jobMethodName nazwa Job'a (akcji)
     * @return string
     */
    public function getJobContent($jobMethodName)
    {
        // wykonaj działania przed uruchomieniem akcji
        $this->preLauncher();
        
        // uruchom Job
        $this->$jobMethodName();
        
        // ustaw plik widoku
        $checkView = $this->view->getViewFile();
        // Ten warunek jest po to, aby nie nadpisywać ustawienia, jeśli w Jobie kontrollera już ustawiono jakiś plik widoku.
        // Jeśli nie ma ustawionego żadnego pliku widoku, to załaduj zgodnie z defaultowymi ustawieniami
        if (empty($checkView)) {
            $this->view->setView($this->_director->getControllerName(), $this->_director->getJobName());
        }
        
        // wyrenderuj zawartosc widoku
        $viewOutput = $this->view->render();
        
        // uruchom działania po renderingu
        $this->postLauncher();
        
        return $viewOutput;
    }

    
    /**
     * Metoda magiczna wywoływana gdy nie znaleziono odpowiedniego Job w kontrolerze.
     * @param string $jobName
     * @param unknown $sec
     */
    public function __call($jobName, $sec)
    {
        // TODO rzuc wyjatek jesli wywolano nieistniejaca akcje
        echo 'nie znaleziono podanego Job w tym kontrolerze <br><br><br>';
        
        echo 'module: ' . $this->_director->getModuleName() . '<br>';
        echo 'controller: ' . $this->_director->getControllerName() . '<br>';
        echo 'job: ' . $this->_director->getJobName() . '<br>';
        
        // throw new \MKFramework\Exception\Exception("nie ma Job <b>{$jobName}</b> w tym kontrolerze");
    }
}
