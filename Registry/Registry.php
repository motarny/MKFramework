<?php
namespace MKFramework\Registry;

use MKFramework;
use MKFramework\Exception\Exception;

class Registry
{

    protected static $_registry;

    function __construct()
    {}

    static public function init()
    {
        if (empty(self::$_registry)) {
            self::$_registry = new self();
            self::$_registry->_registryValues = array();
            self::$_registry->_namespace = REGISTRY_DEFAULT_NAMESPACE;
        }
    }

    static public function set($registryName, $value, $namespace = null)
    {
        
        // self::checkValidNamespaceName($namespace);
        if ($value instanceof MKFramework\NessunAbstract) {
            $namespace = REGISTRY_CORE_NAMESPACE;
            $registryName = get_class($value);
        } elseif ($value instanceof MKFramework\Config\Config) {
            if ($namespace == REGISTRY_CORE_NAMESPACE) {
                
                $registryName = REGISTRY_APP_CONFIGURATION;
            }
        } else {
            if ($namespace == null)
                $namespace = self::getCurrentNamespace();
        }
        self::init();
        self::$_registry->_registryValues[$namespace][$registryName] = $value;
    }

    static public function get($registryName, $namespace = null)
    {
        if ($namespace == null)
            $namespace = self::getCurrentNamespace();
        return self::$_registry->_registryValues[$namespace][$registryName];
    }

    static public function clearRegistry($namespace = null)
    {
        self::checkValidNamespaceName($namespace);
        if ($namespace != null) {
            unset(self::$_registry->_registryValues[$namespace]);
        } else {
            $saveCore = self::$_registry->_registryValues[REGISTRY_CORE_NAMESPACE];
            unset(self::$_registry->_registryValues);
            self::$_registry->_registryValues[REGISTRY_CORE_NAMESPACE] = $saveCore;
        }
    }

    static public function getAll($namespace = null)
    {
        return self::$_registry->_registryValues;
    }

    static function checkValidNamespaceName($namespace)
    {
        if ($namespace == REGISTRY_CORE_NAMESPACE) {
            throw new Exception('Nieprawidlowa nazwa dla namespace - "' . REGISTRY_CORE_NAMESPACE . '"', $code, $previous);
        }
    }

    /**
     * Pobiera bierz�cy namespace rejestru
     */
    static public function getCurrentNamespace()
    {
        return self::$_registry->_namespace;
    }

    /**
     * Ustawia bierz�cy namespace dla rejestru
     *
     * @param string $namespace            
     */
    static public function setNamespace($namespace = REGISTRY_DEFAULT_NAMESPACE)
    {
        self::checkValidNamespaceName($namespace);
        self::$_registry->_namespace = $namespace;
    }
}

?>