<?php

namespace App\Presenters;

use App\Forms\BaseForm;
use App\Model\TopicManager;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;



class HomepagePresenter extends BasePresenter
{

    /**
     * @inject
     * @var TopicManager
     */
    public $topicManager;



    public function renderDefault()
    {
        $this->template->topics = $this->topicManager->getTopics()
            ->fetchAll();
    }



    protected function createComponentAddTopicForm()
    {
        $form = new BaseForm();
        $form->addProtection();

        $form->addText('name', 'Téma')
            ->setRequired()
            ->addRule([$this->topicManager, 'validateTopicName'], 'Toto téma už existuje');

        $form->addTextArea('description', 'Popisek')
            ->setRequired()
            ->addRule($form::MAX_LENGTH, 'Maximální délka popisu je %d znaků', 255);

        $form->addSubmit('send', 'Vytvořit');

        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            $topic = $this->topicManager->createTopic($values->name, $values->description);
            $this->successFlashMessage('Téma přidáno');
            $this->redirect('Topics:detail', ['id' => $topic->id]);
        };

        return $form;
    }

}
