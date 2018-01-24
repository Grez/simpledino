<?php

namespace App\Model;

use Nette;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\Database\Table\Selection;
use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Controls\TextInput;



class TopicManager
{

    use Nette\SmartObject;

    /**
     * @var Context
     */
    private $database;



    public function __construct(Context $database)
    {
        $this->database = $database;
    }



    public function getTopics(): Selection
    {
        return $this->database->table('topics')
            ->order('name');
    }



    public function getTopicById(int $id): ?IRow
    {
        $topic = $this->database->table('topics')
            ->where('id', $id)
            ->fetch();

        if ($topic === FALSE) {
            return NULL;
        }

        return $topic;
    }



    public function createTopic(string $name, string $description): IRow
    {
        $topic = $this->database->table('topics')->insert([
            'name' => $name,
            'description' => $description,
        ]);

        return $topic;
    }



    public function validateTopicName(TextInput $control): bool
    {
        $name = $control->getValue();
        $topic = $this->database->table('topics')
            ->where('name', $name)
            ->fetch();

        return $topic === FALSE;
    }

}
