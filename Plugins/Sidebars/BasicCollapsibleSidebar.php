<?php

namespace Plugins\Sidebars;

use Engine\Core\HTML;

class BasicCollapsibleSidebar extends \Engine\Core\HTML
{   

    private $aSideBarHead;
    private $aSideBarHeadImg;
    private $aSideBarHeadSpan;

    private $ul_1;
    private $li_1;
    private $li_1_button;
    private $div_1_collapse;

    private $ul_1_1;
    private $li_1_1;
    private $li_1_1_a;

    private $li_1_2;
    private $li_1_2_a;

    private $li_1_3;
    private $li_1_3_a;

    public function __construct()
    {
        parent::__construct("div");
        $this->prepare();
        $this->createObjects();
        $this->compile();
    }

    public function prepare()
    {
        $this->setId("sidebar");
        $this->setClass("flex-shrink-0");
        $this->setClass("p-3");
        $this->setClass("bg-white");
        $this->setAttribute("style", "width: 280px;");
    }

    public function createObjects()
    {
        $this->aSideBarHead = new HTML("a");
        $this->aSideBarHead->setClass("d-flex");
        $this->aSideBarHead->setClass("align-items-center");
        $this->aSideBarHead->setClass("pb-3");
        $this->aSideBarHead->setClass("mb-3");
        $this->aSideBarHead->setClass("link-dark");
        $this->aSideBarHead->setClass("text-decoration-none");
        $this->aSideBarHead->setClass("border-bottom");

        $this->aSideBarHeadImg = new HTML("img");
        $this->aSideBarHeadImg->setClass("material-icons");
        $this->aSideBarHeadImg->setClass("m-2");
        $this->aSideBarHeadImg->setAttribute("width", "27");
        $this->aSideBarHeadImg->setAttribute("height", "27");
        $this->aSideBarHeadImg->setAttribute("src", "https://cdn-icons-png.flaticon.com/512/128/128810.jpg");

        $this->aSideBarHeadSpan = new HTML("span");
        $this->aSideBarHeadSpan->setClass("fs-5");
        $this->aSideBarHeadSpan->setClass("fw-semibold");
        $this->aSideBarHeadSpan->setText("Documentation");
  
        $this->ul_1 = new HTML("ul");
        $this->ul_1->setClass("list-unstyled");
        $this->ul_1->setClass("ps-0");

        $this->li_1 = new HTML("li");
        $this->li_1->setClass("mb-1");

        $this->li_1_button = new HTML("button");
        $this->li_1_button->setClass("btn");
        $this->li_1_button->setClass("btn-toggle");
        $this->li_1_button->setClass("align-items-center");
        $this->li_1_button->setClass("rounded");
        $this->li_1_button->setAttribute("data-bs-toggle", "collapse");
        $this->li_1_button->setAttribute("data-bs-target", "#home-collapse");
        $this->li_1_button->setAttribute("aria-expanded", "true");
        $this->li_1_button->setText("Home");

        $this->div_1_collapse = new HTML("div");
        $this->div_1_collapse->setId("home-collapse");
        $this->div_1_collapse->setClass("collapse");
        $this->div_1_collapse->setClass("show");

        $this->ul_1_1 = new HTML("ul");
        $this->ul_1_1->setClass("btn-toggle-nav");
        $this->ul_1_1->setClass("list-unstyled");
        $this->ul_1_1->setClass("fw-normal");
        $this->ul_1_1->setClass("pb-1");
        $this->ul_1_1->setClass("small");

        $this->li_1_1 = new HTML("li");
        
        $this->li_1_1_a = new HTML("a");
        $this->li_1_1_a->setClass("link-dark");
        $this->li_1_1_a->setAttribute("href", "#");
        $this->li_1_1_a->setText("Overview");

        $this->li_1_2 = new HTML("li");

        $this->li_1_2_a = new HTML("a");
        $this->li_1_2_a->setClass("link-dark");
        $this->li_1_2_a->setAttribute("href", "#");
        $this->li_1_2_a->setText("Updates");

        $this->li_1_3 = new HTML("li");

        $this->li_1_3_a = new HTML("a");
        $this->li_1_3_a->setClass("link-dark");
        $this->li_1_3_a->setAttribute("href", "#");
        $this->li_1_3_a->setText("Getting started");
    }

    public function compile()
    {

        $this->addElement($this->aSideBarHead);
        $this->aSideBarHead->addElement($this->aSideBarHeadImg);
        $this->aSideBarHead->addElement($this->aSideBarHeadSpan);

        $this->addElement($this->ul_1);
        $this->ul_1->addElement($this->li_1);
        $this->li_1->addElement($this->li_1_button);

        $this->ul_1->addElement($this->div_1_collapse);
        $this->div_1_collapse->addElement($this->ul_1_1);
        $this->ul_1_1->addElement($this->li_1_1);
        $this->li_1_1->addElement($this->li_1_1_a);
        $this->ul_1_1->addElement($this->li_1_2);
        $this->li_1_2->addElement($this->li_1_2_a);
        $this->ul_1_1->addElement($this->li_1_3);
        $this->li_1_3->addElement($this->li_1_3_a);
    }

    public function addElement($element)
    {
        $this->div_1_collapse->addElement($element);
    }
}

?>