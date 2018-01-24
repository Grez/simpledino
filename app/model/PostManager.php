<?php

namespace App\Model;

use Nette;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\Database\Table\Selection;
use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Controls\TextInput;



class PostManager
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



    public function createPost(int $topicId, string $author, string $body): IRow
    {
        $post = $this->database->table('posts')->insert([
            'topic_id' => $topicId,
            'author' => $author,
            'body' => $body,
        ]);

        return $post;
    }

}
