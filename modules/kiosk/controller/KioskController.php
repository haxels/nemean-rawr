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

		public function __construct(Session $s, ProductMapper $pm,
									OrderMapper $om, array $settings)
		{
			$this->session       = $s;
			$this->productMapper = $pm;
			$this->orderMapper   = $om;
			$this->settings      = $settings;
		}

		/**
		 * Used for methods that uses views
		 *
		 * @return mixed
		 */
		public function display()
		{
			$usr = $this->session->getUser()->getUserId();

			if ($usr == 0)
			{

				echo '<section id="main">Du må logge inn for å bestille burger!</section>';
				exit;
			}
			else
			{
				if (!$this->settings['kiosk_open']->getValue())
				{
					echo '<section id="main">Burgerbestillingen er ikke åpen for øyeblikket!</section>';
					exit;
				}
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
		 * Used for loading views dynamically from JSON
		 *
		 * @return mixed
		 */
		public function quickActions()
		{
			$action = (isset($_GET['qAct'])) ? $_GET['qAct'] : '';
			switch ($action)
			{
			}
		}

		public function ajaxActions()
		{
			$action = (isset($_GET['aAct'])) ? $_GET['aAct'] : '';
			switch ($action)
			{
				case 'putOrder':
					$this->putOrder();
					break;

				case 'success':
					$this->displaySuccess();
					break;

				case 'main':
					$this->displayMain();
			}
		}


		private function putOrder()
		{
			$arr['success'] = false;

			$userID   = $_POST['user_id'];
			$products = $_POST['products'];
			$total    = $_POST['total'];
			$payType  = $_POST['payType'];

			// Validate products
			if ($this->validateProducts($_POST['products']))
			{
				// Create order and fetch order id
				/*$order    =
					new Order(0, $userID, time(), 0, $total, $payType, '',
							  []);
				$order_id =
					$this->orderMapper->insert($order);
				foreach ($products as $productID)
				{
					$this->orderMapper->insertRelation($order_id, $productID());
				}*/
				$arr['success'] = true;
			}
			echo json_encode($arr);
		}

		private function validateProducts()
		{
			return true;
		}

		private function displaySuccess()
		{
			$this->loadView('success');
		}

		private function displayMain()
		{
			$products         = $this->productMapper->findAll();
			$data['products'] = $products;
			$this->loadView('main', $data);
		}
	}
