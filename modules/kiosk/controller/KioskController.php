<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.10.12
 * Time: 09:10
 * To change this template use File | Settings | File Templates.
 */
class KioskController extends NController
{
    protected $moduleName = 'kiosk';

    private $productMapper;
    private $orderMapper;
    private $settings;

    public function __construct(Session $s, ProductMapper $pm, OrderMapper $om, array $settings)
    {
        $this->session = $s;
        $this->productMapper = $pm;
        $this->orderMapper = $om;
        $this->settings = $settings;
    }

    /**
     * Used for methods that uses views
     *
     * @return mixed
     */
    public function display()
    {
    	$usr = $this->session->getUser()->getUserId();
    	
      if( $usr == 0) {
        
        echo '<section id="main">Du må logge inn for å bestille burger!</section>';
            exit;
            }
        else if (!$this->settings['kiosk_open']->getValue())
        {
            echo '<section id="main">Burgerbestillingen er ikke åpen for øyeblikket!</section>';
            exit;
        }
        

        $action = (isset($_GET['act'])) ? $_GET['act'] : '';
        switch ($action)
        {
            case 'finished':
                $this->finished();
                break;

            default:
                $this->start();
                break;
        }
    }

    /**
     * Used for methods that do not use views
     *
     * @return mixed
     */
    public function quickActions()
    {
        // TODO: Implement quickActions() method.
    }

    public function ajaxActions()
    {
        $action = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';
        switch ($action)
        {
            case 'JSONgetProduct':
                $this->JSONgetProduct();
                break;

            case 'JSONaddToCart':
                $this->JSONaddToCart();
                break;
        }
    }


    private function start()
    {
        $data['products']['burger'] = $this->productMapper->findAll(['type' => 'burger']);
        $data['products']['drikke'] = $this->productMapper->findAll(['type' => 'drikke']);
        $this->loadView('start', $data);
    }

    private function finished()
    {
        $cnt = [];
        $products = [];
        $data = [];

        foreach($_POST as $key=>$value)
        {
            $key=(int)str_replace('_cnt','',$key);

            $value=1;

            $products[]=$key;
            $cnt[$key]=$value;
        }

        $payType = isset($_POST['payType']) ? $_POST['payType'] : '';
        if ($payType == '')
        {
            $data['error'] = "Du må velge betalingsmåte!";
        }
        $data['products'] = [];
        foreach ($products as $id)
        {
            if ($id != 0)
            {
                $data['products'][] = $this->productMapper->findById($id);
            }
        }

        if (empty($data['products']))
        {
            $data['error'] = 'Du må velge minst ett produkt';
        }



        if (!isset($data['error']))
        {
            $total = 0;
            foreach ($data['products'] as $product)
            {
                $total += (int)$product->getPrice();
            }
            $data['total'] = $total;
            $order_id = $this->orderMapper->insert(new Order(0, $_POST['hiddenBrukerID'], time(), 0, $total, $payType, '', []));
            $data['order_id'] = $order_id;
            foreach ($data['products'] as $product)
            {
                $this->orderMapper->insertRelation($order_id, $product->getProductId());
            }

        }

        $this->loadView('end', $data);
    }


    private function JSONgetProduct()
    {
        $img = (isset($_POST['img'])) ? $_POST['img'] : '';

            @$img = end(explode('/', $img));

            //$row=mysql_fetch_assoc(mysql_query("SELECT * FROM internet_shop WHERE img='".$img."'"));
            $product = $this->productMapper->findAll(['img' => $img]);
            $product = $product[0];
            if(!$product instanceof Product) die("Produktet finnes ikke!");

                echo '<strong>'.htmlspecialchars($product->getName()).'</strong>

                <p class="descr">'.htmlspecialchars($product->getDescription()).'</p>

                <strong>Pris: '.$product->getPrice().' Kr</strong>
                <small>Dra det ned i bestillingen for å kjøpe </small>';
    }

    private function JSONaddToCart()
    {

        $img = (isset($_POST['img'])) ? $_POST['img'] : '';

        @$img=end(explode('/',$_POST['img']));
        $product = $this->productMapper->findAll(['img' => $img]);
        $product = $product[0];
        if(!$product instanceof Product) die("Produktet finnes ikke!");

        $arr = ['status' => 1, 'id' => $product->getProductId(), 'price' => $product->getPrice()];
        $arr['txt'] = '<table width="100%" id="table_'.$product->getProductId().'"><tr><td width="60%">'.$product->getName().'</td><td width="10%">'.$product->getPrice().'</td><td width="15%"><select name="'.$product->getProductId().'_cnt" id="'.$product->getProductId().'_cnt" onchange="change('.$product->getProductId().');" style="visibility: hidden;"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td><td width="15%"><a href="#" onclick="remove('.$product->getProductId().');return false;" class="remove">Fjern</a></td></tr></table>';

        echo json_encode($arr);
        /*
        echo '{status:1,id:'.$product->getProductId().',price:'.$product->getPrice().',txt:\'\
        \
        <table width="100%" id="table_'.$product->getProductId().'">\
          <tr>\
            <td width="60%">'.$product->getName().'</td>\
            <td width="10%">'.$product->getPrice().' Kr</td>\
            <td width="15%"><select name="'.$product->getProductId().'_cnt" id="'.$product->getProductId().'_cnt" onchange="change('.$product->getProductId().');" style="visibility: hidden;">\
            <option value="1">1</option>\
            <option value="2">2</option>\
            <option value="3">3</option></select>\
            \
            </td>\
            <td width="15%"><a href="#" onclick="remove('.$product->getProductId().');return false;" class="remove">Fjern</a></td>\
          </tr>\
        </table>\'}';
        */
    }


}
