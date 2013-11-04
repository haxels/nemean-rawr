<?php
/**
 * User: Ragnar
 * Date: 4/5/12
 * Time: 5:01 PM
 */
require_once MODULEPATH.'/articles/classes/Article.php';
require_once MODULEPATH.'/articles/classes/PollMapper.php';

class ArticleMapper extends DataMapper
{
    protected $entityTable = 'art_articles';
    protected $primaryKey  = 'article_id';

    private $pollMapper;
    private $userMapper;

    public function __construct(IDatabaseAdapter $adapter, PollMapper $pm, UserMapper $um)
    {
        parent::__construct($adapter);
        $this->pollMapper = $pm;
        $this->userMapper = $um;
    }

    public function insert(Article $a)
    {
        return $this->adapter->insert($this->entityTable, array('poll_id' => $a->getPoll_id(),
                                                         'approved' => 0,
                                                         'approved_by' => 0,
                                                         'title' => $a->getTitle(),
                                                         'ingress' => $a->getIngress(),
                                                         'text' => $a->getText(),
                                                         'user_id' => $a->getAuthorId(),
                                                         'publish_date' => $a->getPublish_date(),
                                                         'category_id' => $a->getCategoryID(),
                                                         'picture' => $a->getPicture()));
    }

    public function update(Article $a)
    {
        return $this->adapter->update($this->entityTable, array('poll_id' => $a->getPoll_id(),
                                                                'approved' => 0,
                                                                'approved_by' => 0,
                                                                'title' => $a->getTitle(),
                                                                'ingress' => $a->getIngress(),
                                                                'text' => $a->getText(),
                                                                'user_id' => $a->getAuthorId(),
                                                                'publish_date' => $a->getPublish_date(),
                                                                'category_id' => $a->getCategoryID(),
                                                                'picture' => $a->getPicture()),
                                      $this->primaryKey.' = '.$a->getArticle_id());
    }

    public function publish(Article $a)
    {
        return $this->adapter->update($this->entityTable, array('publish_date' => $a->getPublish_date()),
                                      $this->primaryKey.' = '.$a->getArticle_id());
    }

    public function getCategories()
    {
        $sql = 'SELECT * FROM art_categories';
        $this->adapter->prepare($sql)->execute();
        return $this->adapter->fetchAll();
    }

    protected function createEntity(array $row)
    {
        $poll = $this->pollMapper->findById($row['poll_id']);
        $user = $this->userMapper->findById($row['user_id']);
        $approbedBy = $this->userMapper->findById($row['approved_by']);
        return new Article( $row['article_id'],
                            $poll,
                            $row['date_created'],
                            $row['approved'],
                            $approbedBy,
                            $row['publish_date'],
                            $row['title'],
                            $row['ingress'],
                            $row['text'],
                            $user,
                            $row['category_id'],
                            $row['picture']);
    }

    public function getRecent($limit)
    {
        $sql = "SELECT * FROM art_articles WHERE publish_date BETWEEN '0000-00-00 00:00:01' AND NOW() ORDER BY publish_date DESC LIMIT $limit";
        $this->adapter->prepare($sql)->execute();
        $articles = $this->adapter->fetchAll();
        $retVal = array();
        foreach ($articles as $article)
        {
            $retVal[] = $this->createEntity($article);
        }
        return $retVal;
    }
}
