<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 13.04.12
 * Time: 18:08
 * To change this template use File | Settings | File Templates.
 */


class AdminController extends NController
{
    protected $moduleName = 'articles';

    private $articleMapper;
    private $userMapper;
    private $settingsMapper;

    public function __construct(Session $s, ArticleMapper $am, UserMapper $um, SettingsMapper $sm)
    {
        $this->session          = $s;
        $this->userMapper       = $um;
        $this->articleMapper    = $am;
        $this->settingsMapper   = $sm;
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

            case 'publish':
                $this->publishArticle();
                break;

            case 'settings':
                $this->viewSettings();
                break;

            default:
                $this->listArticles();
                break;
        }
    }

    public function quickActions()
    {
        $action = (isset($_GET['qAct'])) ? $_GET['qAct'] : '';
        switch($action)
        {
            case 'upload':
                $this->upload();
                break;
        }
    }

    private function getCategoriIDs(array $categories = array())
    {
        $retVal = array();
        foreach ($categories as $category)
        {
            $retVal[] = $category['category_id'];
        }
        return $retVal;
    }

    public function addArticle()
    {
        if (!$this->session->isAuthorized(array('Developer', 'Writer')))
        {
             echo 'You\'re not authorized';
            return;
        }

        $data['user'] = $this->session->getUser();
        $data['categories'] = $this->articleMapper->getCategories();

        if (isset($_POST['submit']))
        {
            $title              = (isset($_POST['title'])) ? trim($_POST['title']) : '';
            $ingress            = (isset($_POST['ingress'])) ? trim($_POST['ingress']) : '';
            $text               = (isset($_POST['text'])) ? trim($_POST['text']) : '';
            $pDate              = (isset($_POST['publish'])) ? trim($_POST['publish']) : '';
            $time               = (isset($_POST['time'])) ? trim($_POST['time']) : '';
            $category           = (isset($_POST['category'])) ? $_POST['category'] : 0;
            $validCategories    = $this->getCategoriIDs($data['categories']);
            $image              = (isset($_POST['image'])) ? $_POST['image'] : '';

            $validator = new Validator();
            $validator->addField('title',array(Validator::REQUIRED), array('min' => 5));
            $validator->addField('ingress',  array(Validator::REQUIRED, array('max' => 255)));
            $validator->addField('text',  array(Validator::REQUIRED));
            $validator->addField('category',  array(Validator::REQUIRED), array('whitelist' => $validCategories));

            $file = ($image != '') ? 'resources/img/articles/' . $image : 'resources/img/articles' ;
            if ($image != 'resources/img/articles' && !is_file($file))
            {
                $validator->setError('image', 'Filen finnes ikke.');
            }

            if ($pDate != '')
            {
                $validator->addField('publish', array(Validator::DATE));
            }

            if ($time != '')
            {
                $validator->addField('time', array(Validator::TIME));
            }

            $validator->validate();

            if ($validator->hasErrors())
            {
                $data['errors'] = $validator->getErrors();
                $this->loadView('admin/addArticle', $data);
            }
            else
            {
                if ($pDate != '')
                {
                    list ($day, $month, $year) = explode('/', $pDate);
                    list ($hour, $minute) = explode(':', $time);
                    $pDate = mktime($hour, $minute, 0, $month, $day, $year);
                    $pDate = date('Y-m-d H:i:s', $pDate);
                }
                $article = new Article(0, null, 0, 0, null, $pDate, $_POST['title'], $_POST['ingress'], $_POST['text'], $this->userMapper->findById($this->session->getID()), $category, $image);
                if ($this->articleMapper->insert($article) != 0)
                {
                    echo 'Article was inserted!';
                }
                else
                {
                    echo 'Something went wrong, article was not inserted!';
                }
            }
        }
        else
        {
            $this->loadView('admin/addArticle', $data);
        }
    }

    public function editArticle()
    {
        $article_id = (isset($_GET['artID'])) ? $_GET['artID'] : 0;
        if ($article_id == 0)
        {
            echo 'No article found, something went wrong!';
            return;
        }

        $article = $this->articleMapper->findById($article_id);
        $author_id = $article->getAuthorId();

        if ( (!$article->isOwnerOfArticle($this->session->getID()) && !$this->session->isAuthorized(array('Publisher'))) )
        {
            echo 'You\'re not authorized to do this';
            return;
        }

        $data['user'] = $this->session->getUser();
        $data['categories'] = $this->articleMapper->getCategories();

        if (isset($_POST['submit']))
        {
            $title   = (isset($_POST['title'])) ? trim($_POST['title']) : '';
            $ingress = (isset($_POST['ingress'])) ? trim($_POST['ingress']) : '';
            $text    = (isset($_POST['text'])) ? trim($_POST['text']) : '';
            $pDate = (isset($_POST['publish'])) ? trim($_POST['publish']) : '';
            $time = (isset($_POST['time'])) ? trim($_POST['time']) : '';
            $category = (isset($_POST['category'])) ? $_POST['category'] : 0;
            $validCategories = $this->getCategoriIDs($data['categories']);
            $validator = new Validator();
            $validator->addField('title', array(Validator::REQUIRED), array('min' => 5));
            $validator->addField('ingress',  array(Validator::REQUIRED, array('max' => 255)));
            $validator->addField('text', array(Validator::REQUIRED));
            $validator->addField('category',  array(Validator::REQUIRED), array('whitelist' => $validCategories));

            if ($pDate != '')
            {
                $validator->addField('publish',  array(Validator::DATE));
            }

            if ($time != '')
            {
                $validator->addField('time', array(Validator::TIME));
            }

            $validator->validate();

            if ($validator->hasErrors())
            {
                $data['errors'] = $validator->getErrors();
                $this->loadView('admin/addArticle', $data);
            }
            else
            {
                if ($pDate != '')
                {
                    list ($day, $month, $year) = explode('/', $pDate);
                    list ($hour, $minute) = explode(':', $time);
                    $pDate = mktime($hour, $minute, 0, $month, $day, $year);
                    $pDate = date('Y-m-d H:i:s', $pDate);
                }
                $user = $this->userMapper->findById($author_id);
                $article = new Article($article_id, null, 0, 0, null, $pDate, $_POST['title'], $_POST['ingress'], $_POST['text'], $user, $category, '');

                if ($this->articleMapper->update($article) != 0)
                {
                    header('Location: admin.php?m=articles');
                    //echo 'Article was updated!';

                }
                else
                {
                    echo 'No changes were made!';
                }
            }
        }
        else
        {
            $data['article'] = $this->articleMapper->findById($article_id);
            if ($data['article'] == null)
            {
                echo 'No article found, something went wrong!';
                return;
            }
            $this->loadView('admin/editArticle', $data);
        }
    }

    public function deleteArticle()
    {
        $article_id = (isset($_GET['artID'])) ? $_GET['artID'] : 0;
        $article = $this->articleMapper->findById($article_id);

        if ($this->session->isAuthorized(array('Publisher')) || $article->isOwnerOfArticle($this->session->getID()))
        {
            if ($this->articleMapper->deletePK($article->getArticle_id()) != 0)
            {
                header('Location: ?m=articles');
            }
            else
            {
                echo 'Article was not deleted';
            }
        }
        else
        {
            echo 'Oh, darn! You do not have permission to do this.';
        }
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
        $this->loadView('admin/viewArticle', $data);
    }

    public function listArticles()
    {
        $data['articles'] = $this->articleMapper->findAll();
        $this->loadView('admin/list', $data);
    }

    public function publishArticle()
    {
        if ($this->session->isAuthorized(array('Publisher')))
        {
            $article_id = (isset($_GET['artID'])) ? $_GET['artID'] : 0;
            $article = $this->articleMapper->findById($article_id);
            if ($article instanceof Article)
            {
                if ($article->isPublished())
                {
                    $article->setPublish_date('0000-00-00 00:00:00');
                }
                else
                {
                    $article->setPublish_date(date('Y-m-d H:i:s', time()));
                }
                $this->articleMapper->publish($article);
                header('Location: ?m=articles');
            }
        }
        else
        {
            echo 'You don\'t have permission to do this';
        }
    }


    public function viewSettings()
    {
        $data['settings'] = $this->settingsMapper->findAll(array('module_id' => 1));
        $this->loadView('admin/settings', $data);
    }

    public function upload()
    {
        $data = array();
        if (isset($_POST['submit']))
        {
            $files = array(new File($_FILES['upl1']['name'], $_FILES['upl1']['tmp_name']));
            $uploader = new Uploader('resources/img/articles/', $files, 1000000, array('png', 'jpg'));
            $uploader->doValidateLength();
            $uploader->setValidImgLengths(540, 500);
            $uploader->upload();

            if ($uploader->hasErrors())
            {
                foreach($uploader->getErrors() as $error)
                {
                    echo $error . '<br />';
                }
            }
            else
            {
                echo 'Image was uploaded!';
            }
        }
        $this->loadView('admin/upload', $data);
        exit();
    }
}
?>