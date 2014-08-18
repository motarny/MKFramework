<?php
namespace MKFramework\Exception;

class Exception extends \Exception
{

    public function showMessage()
    {
        return '<b>' . $this->getMessage() . '</b>';
    }
}

?>