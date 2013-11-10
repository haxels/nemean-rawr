<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 13.04.12
 * Time: 18:08
 * To change this template use File | Settings | File Templates.
 */
require_once MODULEPATH.'/articles/classes/Article.php';
require_once MODULEPATH.'/articles/classes/ArticleMapper.php';
require_once MODULEPATH.'/articles/classes/PollMapper.php';
require_once MODULEPATH.'users/classes/ParentsMapper.php';
require_once MODULEPATH.'users/classes/RoleMapper.php';
require_once MODULEPATH.'users/classes/UserMapper.php';
require_once SYSPATH.'NController.php';

class ArticleController extends NController implements IMainContent
{
    protected $moduleName = 'articles';

    private $articleMapper;
    private $userMapper;

    public function __construct(Session $s, UserMapper $um, ArticleMapper $am)
    {
        $this->session          = $s;
        $this->userMapper       = $um;
        $this->articleMapper    = $am;
    }

    public function display()
    {
        $action = (isset($_GET['act'])) ? $_GET['act'] : '';
        switch($action)
        {
            case 'add':
                $this->addArticle();
                break;

            case 'edit':
                $this->editArticle();
                break;

            case 'delete':
                $this->deleteArticle();
                break;

            case 'view':
                $this->viewArticle();
                break;

            default:
                $this->listArticles();
                break;
        }
    }

    public function quickActions()
    {

    }

    public function mainContent()
    {
        $action = (isset($_GET['act'])) ? $_GET['act'] : '';
        switch($action)
        {
            case 'view':
                $this->viewArticle();
                break;

            default:
                $this->listArticles();
                break;
        }
    }


    public function addArticle()
    {
        if (isset($_POST['submit']))
        {
            // Validate user input
            $user = $this->userMapper->findById(1);
            $article = new Article(0, null, 0, 0, null, 0, $_POST['title'],
                $_POST['ingress'], $_POST['text'], $user);
            if ($this->articleMapper->insert($article) != 0)
            {
                echo 'Article was inserted!';
            }
            else
            {
                echo 'Something went wrong!';
            }
        }
        else
        {
            $this->loadView('addArticle');
        }
    }

    public function editArticle()
    {

    }

    public function deleteArticle()
    {

    }

    public function viewArticle()
    {
        $art_id = (isset($_GET['artID'])) ? $_GET['artID'] : 0;
        if ($art_id == 0)
        {
            echo 'Article not found!';
            return;
        }
        $article = $this->articleMapper->findById($art_id);
        if ($article instanceof Article)
        {
            $data['article'] = $article;
        }
        else
        {
            echo 'Article not found!';
            return;
        }
        $this->loadView('viewArticle', $data);
    }

    public function listArticles()
    {
        $data['articles'] = $this->articleMapper->getRecent(10);
        $this->loadView('list', $data);
    }


}
?>