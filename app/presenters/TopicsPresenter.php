<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\Utils\ArrayHash;



class TopicsPresenter extends Nette\Application\UI\Presenter
{

    /**
     * @inject
     * @var Context
     */
    public $database;



    public function renderDetail(int $id)
    {
        $topic = $this->database->table('topics')
            ->where('id', $id)
            ->fetch();

        if ($topic === FALSE) {
            $this->flashMessage('Toto téma neexistuje', 'danger');
            $this->redirect('Homepage:default');
        }

        $this->template->topic = $topic;
    }



    protected function createComponentAddPostForm()
    {
        $form = new Form();
        $form->addProtection();

        $form->addText('author', 'Autor')
            ->setRequired();

        $form->addTextArea('body', 'Příspěvek')
            ->setRequired();

        $form->addSubmit('send', 'Uložit');

        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            $postId = $this->database->table('posts')->insert([
                'topic_id' => $this->getTopic()->id,
                'author' => $values->author,
                'body' => $values->body,
            ]);

            $this->flashMessage('Příspěvek přidán', 'success');
            $this->redirect('this');
        };

        return $form;
    }



    private function getTopic(): IRow
    {
        $topic = $this->database->table('topics')
            ->where('id', $this->getParameter('id'))
            ->fetch();

        if ($topic === FALSE) {
            $this->flashMessage('Toto téma neexistuje', 'danger');
            $this->redirect('Homepage:default');
        }

        return $topic;
    }

}
