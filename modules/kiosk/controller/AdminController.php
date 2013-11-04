<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.10.12
 * Time: 09:10
 * To change this template use File | Settings | File Templates.
 */
class AdminController extends NController
{
    protected $moduleName = 'kiosk';

    private $productMapper;
    private $orderMapper;
    private $settings;

    public function __construct(Session $s, ProductMapper $pm, OrderMapper $om, array $settings)
    {
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
        $action = (isset($_GET['act'])) ? $_GET['act'] : '';

        switch ($action)
        {
            case 'listDelivered':
                $this->listDeliveredOrders();
                break;

            default:
                $this->listOrders();
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
        $action = (isset($_GET['qAct'])) ? $_GET['qAct'] : '';

        switch ($action)
        {
            case 'delete':
                $this->deleteOrder();
                break;

            case 'deliver':
                $this->deliverOrder();
                break;

            case 'undeliver':
                $this->undeliverOrder();
                break;

            case 'close':
                $this->close();
                break;

            case 'open':
                $this->open();
                break;
        }
    }

    private function listOrders()
    {
        $data['title'] = 'Ordrer';
        $data['open'] = $this->settings['kiosk_open']->getValue();
        $data['orders'] = $this->orderMapper->fetchRelate('ASC', 0);

        foreach ($data['orders'] as $order)
        {
            //echo $order->getOrderId();
            $products = $this->orderMapper->fetchRelate2($order->getOrderId());
            //var_dump($products);
            $order->setProducts($products);
        }
         //var_dump($data['orders']);
       $this->loadView('admin/list', $data);
    }

    private function listDeliveredOrders()
    {
        $data['title'] = 'Leverte ordrer';
        $data['open'] = $this->settings['kiosk_open']->getValue();
        $data['orders'] = $this->orderMapper->fetchRelate('DESC', 1);

        foreach ($data['orders'] as $order)
        {
            //echo $order->getOrderId();
            $products = $this->orderMapper->fetchRelate2($order->getOrderId());
            //var_dump($products);
            $order->setProducts($products);
        }
        //var_dump($data['orders']);
        $this->loadView('admin/list', $data);
    }

    private function deleteOrder()
    {
        $order_id = (isset($_GET['order_id'])) ? $_GET['order_id'] : '';
        $this->orderMapper->deletePK($order_id);
    }


    private function deliverOrder()
    {
        $order_id = (isset($_GET['order_id'])) ? $_GET['order_id'] : '';
        $this->orderMapper->deliverOrder($order_id);
    }

    private function undeliverOrder()
    {
        $order_id = (isset($_GET['order_id'])) ? $_GET['order_id'] : '';
        $this->orderMapper->undeliverOrder($order_id);
    }

    private function close()
    {
        $this->orderMapper->close();
        header('Location: ?m=kiosk');
    }

    private function open()
    {
        $this->orderMapper->open();
        header('Location: ?m=kiosk');
    }


}
