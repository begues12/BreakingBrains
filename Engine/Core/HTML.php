<?php

namespace Engine\Core;

class HTML {

    private $tag        = "html";
    private $attributes = [];
    private $classes    = [];
    private $styles     = [];
    public $content     = [];
    private $text       = "";
    private $cssFile    = "";
    private $jsFile     = "";

    public function __construct(string $tag,array $attributes = []) {
        $this->tag          = $tag;
        $this->attributes   = $attributes;
        $this->content      = [];
        $this->text         = "";
    }

    /*
    *
    * @param string $tag
    * @param array $attributes
    * @return $this
    */

    public function setTag(string $tag)
    {
        $this->tag = $tag;
    }

    /*
    * Add attribute to tag 
    * @param string $name
    * @param string $value
    * @return $this
    */

    public function setAttribute($name, $value) 
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function setAttributes(array $attributes)
    {
        foreach($attributes as $attribute => $value)
        {
            $this->attributes[$attribute] = $value;
        }
    }

    /*
    * Get attribute from tag
    * @param string $name
    * @return string|null
    */

    public function getAttribute($name) 
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function setCssFile($cssFile)
    {
        $css = new HTML('link');
        $css->setAttribute('rel', 'stylesheet');
        $css->setAttribute('href', $cssFile);
        $this->addElement($css);
    }

    public function setJsFile($jsFile)
    {
        $js = new HTML('script');
        $js->setAttribute('src', $jsFile);
        $this->addElement($js);
    }

    /*
    * Add content to tag
    * @param string $content
    * @return $this
    */

    public function addElement(HTML $element)
    {
        $this->content[] = $element;
    }

    public function addElements(array $elements) : HTML
    {
        foreach($elements as $element)
        {
            if ($element instanceof HTML)
            {
                $this->content[] = $element;
            }
        }

        return $this;
    }

    /*
    * Convert object to string
    * @return string
    */

    public function toString()
    {
        $string = '<' . $this->tag;

        foreach ($this->attributes as $name => $value) {
            $string .= " " . $name . "='" . $value . "'";
        }

        $string .= '>';

        if (!$this->text){
            foreach ($this->content as $element) {
                $string .= $element->toString();
            }
        }else{
            $string .= $this->text;
        }

        $string .= '</' . $this->tag . '>';
        
        return $string;
    }

    /*
    * Convert object to string
    * @param string $id
    * @return $this
    */

    public function setId(string $id)
    {
        $this->setAttribute('id', $id);
        return $this;
    }

    /*
    * Convert object to string
    * @param string $class
    * @return string
    */

    public function setClass(string $class)
    {
        $this->setAttribute('class', $this->getAttribute('class') . ' ' . $class);
        return $this;
    }

    public function setClasses(array $classes)
    {
        foreach($classes as $class){
            $this->setAttribute('class', $this->getAttribute('class') . ' ' . $class);
        }
        return $this;
    }

    /* Set Array into Style tag
    * @param array $style
    * @return $this
    */
    public function setStyle(array $style)
    {
        $attribStyle = '';
        foreach($style as $style => $attribute){
            $attribStyle .= $style . ':' . $attribute . ';';
        }
        $this->setAttribute('style', $attribStyle);
        return $this;
    }

    /* Set Text into tag
    * @param string $text
    * @return $this
    */

    public function setText(string $text)
    {
        $this->text = $text;
        return $this;
    }

    /*
    * Convert object to string and print it into browser
    * @param string $class
    * @return string
    */
    public function render()
    {
        echo $this->toString();
    }

    /*
    * Get a copy of this object
    * @return $this
    */

    public function copy()
    {
        return clone $this;
    }

}   

?>