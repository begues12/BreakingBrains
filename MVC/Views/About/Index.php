<?php

namespace MVC\Views\About;

use Engine\Core\IView;
use Engine\Core\HTML;

class Index extends IView{

    private $h2Title;

    private $divExplain;
    private $pExplain;
    private $img1;

    private $divExplain2;
    private $pExplain2;
    private $img2;

    public function prepare()
    {
    }

    public function createObjects()
    {

        $this->h2Title = new HTML('h2');
        $this->h2Title->setText('About');
        $this->h2Title->setClasses(['text-dark','mt-3']);

        $this->divExplain = new HTML('div');
        $this->divExplain->setClasses([
            'container',
            'd-flex',
            'justify-content-center',
            'mb-5'
        ]);

        $this->pExplain = new HTML('p');
        $this->pExplain->setText("Fountain is a versatile framework specifically created to facilitate your understanding of how an MVC (Model-View-Controller) system functions. It offers complete customization and is available for free. If you're already comfortable with HTML, CSS, JavaScript, and PHP, you'll quickly adapt to using Fountain. It's designed with a beginner-friendly approach, allowing you to swiftly grasp essential concepts and take your first steps into the world of frameworks.");
        $this->pExplain->setClasses([
            'text-right',
            'd-inline-block',
            'align-top',
            'm-4'
        ]);
    
        $this->img1 = new HTML('img');
        $this->img1->setClasses(['img-fluid', 'img-300']);
        $this->img1->setAttributes([
            'src'   => 'https://cdn-icons-png.flaticon.com/512/128/128810.jpg',
            'alt'   => 'placeholder'
        ]);
        
        $this->divExplain2 = new HTML('div');
        $this->divExplain2->setClasses([
            'container',
            'd-flex',
            'justify-content-center',
            'mb-5'
        ]);

        $this->img2 = new HTML('img');
        $this->img2->setAttributes([
            'src'   => 'https://cdn-icons-png.flaticon.com/512/94/94776.jpg',
            'alt'   => 'placeholder'
        ]);
        $this->img2->setClasses(['img-fluid', 'img-300']);

        $this->pExplain2 = new HTML('p');
        $this->pExplain2->setText("By using Fountain, you'll gain practical insights into structuring web applications, managing data (Models), handling user interfaces (Views), and implementing logic (Controllers) effectively. Whether you're a student or a developer looking to expand your skills, Fountain serves as an excellent starting point for building a solid foundation in MVC architecture and framework utilization.");
        $this->pExplain2->setClasses([
            'text-left',
            'd-inline-block',
            'align-top',
            'm-4'
        ]);
    }

    public function compile()
    {
        $this->addBody($this->h2Title);

        $this->addBody($this->divExplain);
        $this->divExplain->addElements([
            $this->pExplain,
            $this->img1
        ]);

        $this->addBody($this->divExplain2);
        $this->divExplain2->addElements([
            $this->img2,
            $this->pExplain2
        ]);

    }

}

?>