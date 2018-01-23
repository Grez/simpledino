<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Database\Context;
use Nette\Utils\ArrayHash;



class BasePresenter extends Nette\Application\UI\Presenter
{

    /**
     * @inject
     * @var Context
     */
    public $database;

}
