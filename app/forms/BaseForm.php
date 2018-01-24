<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nextras\Forms\Rendering\Bs3FormRenderer;



class BaseForm extends Form
{

    public function __construct(Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs3FormRenderer());
    }



    public function enableAjax()
    {
        $this->form->getElementPrototype()->addClass('ajax');
    }

}
