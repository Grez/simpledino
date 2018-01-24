<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Database\Context;
use Nette\Utils\ArrayHash;



abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    /**
     * @inject
     * @var Context
     */
    public $database;



    protected function infoFlashMessage(string $message)// : void
    {
        $this->flashMessage($message, 'info');
    }



    protected function warningFlashMessage(string $message)// : void
    {
        $this->flashMessage($message, 'warning');
    }



    protected function successFlashMessage(string $message)// : void
    {
        $this->flashMessage($message, 'success');
    }



    protected function dangerFlashMessage(string $message)// : void
    {
        $this->flashMessage($message, 'danger');
    }



    /**
     * @deprecated use $this->dangerFlashMessage()
     */
    protected function errorFlashMessage(string $message)// : void
    {
        $this->dangerFlashMessage($message);
    }

}
