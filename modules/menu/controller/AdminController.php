<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/16/12
 * Time: 9:01 PM
 * To change this template use File | Settings | File Templates.
 */

class AdminController extends NController
{
    protected $moduleName = 'menu';

    private $menuMapper;
    private $userMapper;
    private $articleMapper;

    public function __construct(Session $s, MenuMapper $mm, UserMapper $um, ArticleMapper $am)
    {
        $this->session          = $s;
        $this->menuMapper       = $mm;
        $this->userMapper       = $um;
        $this->articleMapper    = $am;
    }

    public function display()
    {
        $action = (isset($_GET['act'])) ? $_GET['act'] : '';

        switch($action)
        {
            case 'view':
                //$this->viewMenu();
                break;

            case 'delete':
                $this->deleteMenu();
                break;

            case 'add':
                $this->addMenu();
                break;

            case 'edit':
                $this->editMenu();
                break;

            case 'deleteChild':
                $this->deleteChildMenu();
                break;

            case 'moveMenu':
                $this->moveMenu();
                break;

            default:
                $this->listMenus();
                break;

        }
    }

    public function quickActions()
    {

    }


    public function addMenu()
    {
        if (isset($_POST['submit']))
        {
            $label = (isset($_POST['label'])) ? $_POST['label'] : '';
            $link = (isset($_POST['link'])) ? $_POST['link'] : '0';

            $validator = new Validator();
            $validator->addField('label', array(Validator::REQUIRED));

            if (isset($_GET['type']) && $_GET['type'] == 'internal')
            {
                $article_id = $link;
                $article = $this->articleMapper->findById($article_id);
                if (!$article instanceof Article )
                {
                    $validator->setError('link', 'Field, link - article does not exist');
                }
                else
                {
                    $link = '?m=articles&act=view&artID='.$link;
                }
            }
            elseif (isset($_GET['type']) && $_GET['type'] == 'external')
            {
                $validator->addField('link', array(Validator::REQUIRED));
            }

            $validator->validate();

            if ($validator->hasErrors())
            {
                $data['errors'] = $validator->getErrors();
                $data['parents'] = $this->menuMapper->findAll(array('parent_id' => 0));
                $this->loadView('admin/addMenu', $data);
            }
            else
            {
                $menuItem = new MenuItem(0, $label, $link, $_POST['parent'], 0);
                if ($this->menuMapper->insert($menuItem) > 0)
                {
                    header('Location: ?m=menu');
                }
            }
        }
        else
        {
            $data['parents'] = $this->menuMapper->findAll(array('parent_id' => 0));
            $data['articles'] = $this->articleMapper->findAll();
            $this->loadView('admin/addMenu', $data);
        }
    }

    public function editMenu()
    {
        $menu_id = (isset($_GET['mID']) ? $_GET['mID'] : 0);
        $data['menuItem'] = $this->menuMapper->findById($menu_id);

        if (isset($_POST['submit']))
        {
            $validator = new Validator();
            $validator->addField('label', array(Validator::REQUIRED));
            $validator->addField('link', array(Validator::REQUIRED));
            $validator->validate();

            if ($validator->hasErrors())
            {
                $data['errors'] = $validator->getErrors();
                $this->loadView('admin/addMenu', $data);
            }
            else
            {
                $menuItem = new MenuItem($menu_id, $_POST['label'], $_POST['link'], $_POST['parent'], $data['menuItem']->getOrder());
                if ($this->menuMapper->update($menuItem) >= 0)
                {
                    header('Location: ?m=menu');
                    //header('Location: ?m=menu&act=edit&mID='.$_GET['mID']);
                }
            }
        }
        $this->loadView('admin/editMenu', $data);
    }

    public function deleteMenu()
    {
        $menu_id = (isset($_GET['mID']) ? $_GET['mID'] : 0);
        $menu = $this->menuMapper->findById($menu_id);

        if ($menu->hasChildren())
        {
            if ($this->menuMapper->deleteChildren($menu_id) == 0)
            {
                echo 'Something went wrong with deleting menu children';
            }
        }
        if ($this->menuMapper->deletePK($menu_id) != 0)
        {
            header('Location: ?m=menu');
        }
        else
        {
            echo 'Not able to delete menu';
        }
    }

    public function addChildMenu()
    {

    }

    public function editChildMenu()
    {

    }

    public function deleteChildMenu()
    {
        $menu_id = (isset($_GET['cID']) ? $_GET['cID'] : 0);
        $menu = $this->menuMapper->findById($menu_id);

        if ($menu->hasChildren())
        {
            if ($this->menuMapper->deleteChildren($menu_id) == 0)
            {
                echo 'Something went wrong with deleting menu children';
            }
        }
        if ($this->menuMapper->deletePK($menu_id) != 0)
        {
            header('Location: ?m=menu&act=edit&mID='.$_GET['mID']);
        }
        else
        {
            echo 'Not able to delete menu';
        }
    }

    public function listMenus()
    {
        $data['menu'] = $this->menuMapper->getMenu();
        $this->loadView('admin/list', $data);
    }

    public function moveMenu()
    {
        $menu_id = (isset($_GET['mID'])) ? $_GET['mID'] : 0;
        $up = (isset($_GET['up']) && $_GET['up'] == 1) ? true : false;
        $clickedMenu = $this->menuMapper->findById($menu_id);
        $parent_id = $clickedMenu->getParentId();
        $clickedMenuOrder = $clickedMenu->getOrder();
        if ($up)
        {
            $otherMenuOrder = $clickedMenuOrder - 1;
        }
        else
        {
            $otherMenuOrder = $clickedMenuOrder + 1;
        }
        $otherMenu = $this->menuMapper->findAll(array('parent_id' => $parent_id, 'sort' => $otherMenuOrder));
        $otherMenu = $otherMenu[0];

        if ($otherMenu instanceof MenuItem)
        {
            $clickedMenu->setOrder($otherMenuOrder);
            $otherMenu->setOrder($clickedMenuOrder);

            $this->menuMapper->update($clickedMenu);
            $this->menuMapper->update($otherMenu);
        }
        header('Location: ?m=menu');
    }

}
