<?php
/**
 * User: Ragnar
 * Date: 4/5/12
 * Time: 6:41 PM
 */
class ArticleController extends NController
{
    private $user;
    private $articleMapper;

    public function __construct(User $u, ArticleMapper $am)
    {
        $this->user = $u;
        $this->articleMapper = $am;
    }

    public function display()
    {

    }


    public function edit()
    {
        $data['article'] = $article = $this->articleMapper->findById(1);

        if ($this->user->isInRole(array('publisher', 'developer')) OR ($this->user->getUserId() == $article->getAuthorId()))
        {
            $this->loadView('editArticle', $data);
        }

        // Unauthorized access
    }
}
