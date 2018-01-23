<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Database\Context;
use Nette\Utils\ArrayHash;



class HomepagePresenter extends BasePresenter
{

    public function renderDefault()
    {
        $this->template->topics = $this->database->table('topics')
            ->order('name')
            ->fetchAll();
    }



    protected function createComponentAddTopicForm()
    {
        $form = new Form();
        $form->addProtection();

        $form->addText('name', 'Téma')
            ->setRequired();

        $form->addTextArea('description', 'Popisek')
            ->setRequired()
            ->addRule($form::MAX_LENGTH, 'Maximální délka popisu je %d znaků', 255);

        $form->addSubmit('send', 'Vytvořit');

        $form->onSubmit[] = function (Form $form, ArrayHash $values) {
            $topic = $this->database->table('topics')
                ->where('name', $values->name)
                ->fetch();

            if ($topic === FALSE) {
                $this->flashMessage('Téma už existuje', 'danger');
                $this->redirect('this');
            }
        };

        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            $topic = $this->database->table('topics')->insert([
                'name' => $values->name,
                'description' => $values->description,
            ]);

            $this->flashMessage('Příspěvek přidán', 'sucess');
            $this->redirect('Topics:detail', ['id' => $topic->id]);
        };

        return $form;
    }

}
