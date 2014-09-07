<?php
namespace MKFramework\Navigation;

// TODO Dokumentacja

/**
 * Klasa generująca kod HTML nawigacji z użyciem tagów UL i LI
 * 
 * @author Marcin
 *        
 */
class UlNavigation extends NavigationAbstract
{

    protected $_navigationElements;

    protected $_cssClasses = array(
        'levelPrefix' => 'level_',
        'ul' => 'ulclass',
        'rootUl' => 'root',
        'liLink' => 'link',
        'liNoLink' => 'noLink',
        'separator' => 'separator'
    );


    public function renderNavigation()
    {
        $cssDef = $this->_cssClasses;
        
        $startTag = "<ul class=\"{$cssDef['rootUl']}\">";
        $endTag = "</ul>";
        
        $nav = $this->_navigationElements;
        
        $renderedElements = '';
        
        $level = 1;
        foreach ($nav as $element) {
            $renderedElements .= $this->tool_renderLiElement($element, $level);
        }
        
        return $startTag . $renderedElements . $endTag;
    }

    private function tool_renderUlContent($nav, $level)
    {
        $cssDef = $this->_cssClasses;
        $levelClass = $cssDef['levelPrefix'] . $level;
        
        $startTag = "<ul class=\"{$cssDef['ul']} {$levelClass}\">";
        $endTag = "</ul>";
        
        $renderedElements = '';
        
        foreach ($nav as $element) {
            $renderedElements .= $this->tool_renderLiElement($element, $level);
        }
        
        return $startTag . $renderedElements . $endTag;
    }

    private function tool_renderLiElement($element, $level)
    {
        $cssDef = $this->_cssClasses;
        
        if ($element['special'] == 'separator') return "<li class=\"separator\"/>";
        
        $getHtmlElement = '';
        $liClass = empty($element['link']) ? $cssDef['liNoLink'] : $cssDef['liLink'];
        
        $link = $this->tool_renderLink($element);
        
        $levelClass = $cssDef['levelPrefix'] . $level;

        if (is_array($element['content'])) {
            $subUlContent = '';
            $subUlContent = $this->tool_renderUlContent($element['content'], ++ $level);
        }        
        
        $getHtmlElement = "<li class=\"{$levelClass} {$liClass} {$element['cssClass']}\">{$link}{$subUlContent}</li>";
        
        return $getHtmlElement;
    }

    private function tool_renderLink($element)
    {
        $cssDef = $this->_cssClasses;
        
        if (empty($element['link']))
            return $this->translate($element['label']);
        
        $title = $this->translate($element['title']);
        $label = $this->translate($element['label']);
        
        return "<a href=\"{$element['link']}\" title=\"{$title}\" target=\"{$element['target']}\">{$label}</a>";
    }

    private function generateUlCell($ulCell)
    {
        //
    }
}
    