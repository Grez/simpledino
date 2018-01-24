<?php

namespace App\Presenters;

use App\Forms\BaseForm;
use App\Model\PostManager;
use App\Model\TopicManager;
use Nette\Application\UI\Form;
use Nette\Database\Table\IRow;
use Nette\Utils\ArrayHash;



class TopicPresenter extends BasePresenter
{

    /**
     * @inject
     * @var PostManager
     */
    public $postManager;

    /**
     * @inject
     * @var TopicManager
     */
    public $topicManager;



    public function renderDetail(int $id)
    {
        $this->template->topic = $this->getTopic();
    }



    protected function createComponentAddPostForm()
    {
        $form = new BaseForm();
        $form->enableAjax();
        $form->addProtection();

        $form->addText('author', 'Autor')
            ->setRequired();

        $form->addTextArea('body', 'Příspěvek')
            ->setRequired();

        $form->addSubmit('send', 'Uložit');

        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            $this->postManager->createPost($this->getTopic()->id, $values->author, $values->body);
            $this->successFlashMessage('Příspěvek přidán');

            if ($this->isAjax()) {
                $form->reset();
                $this->redrawControl();
            } else {
                $this->redirect('this');
            }
        };

        return $form;
    }



    private function getTopic(): IRow
    {
        $topic = $this->topicManager->getTopicById($this->getParameter('id'));

        if ($topic === NULL) {
            $this->dangerFlashMessage('Toto téma neexistuje');
            $this->redirect('Homepage:default');
        }

        return $topic;
    }

}
