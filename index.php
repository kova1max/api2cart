<?php
  $params = array(
    'store_name' => 'kova1store',
    'method' => 'product.list',
    'params' => '&id=4794466762883&params=name,description,images,u_brand,quantity',
    'store_url' => 'https://kova1store.myshopify.com',
    'store_key' => 'ed45af71da1cf9508b31ef3913ae45ba',
    'id' => 'Shopify',
    'api' => '2a04118c23a25a143a9555b4243a826c'
);

function api_query($mth, $prms) {
  global $params;

  $i = file_get_contents('https://api.api2cart.com/v1.0/'.$mth.'.json?api_key='.$params['api'].'&cart_id='.$params['id'].'&store_url='.$params['store_url'].'&verify=false&store_key='.$params['store_key'].'&validate_version=True'.$prms);
  $result = json_decode($i, true);

  return $result;
}


  class Product {
    public $name, $store, $description, $photo, $price, $amount;

    public function __construct($a) {

      $tem = api_query('product.list', '&params=name,description,images,u_brand,quantity,price'); //name,description,images,u_brand,quantity

      $this->name = $tem['result']['product'][$a]['name'];
      $this->description = $tem['result']['product'][$a]['description'];
      $this->price = $tem['result']['product'][$a]['price'];
      $this->store = $tem['result']['product'][$a]['u_brand'];
      $this->photo = $tem['result']['product'][$a]['images'][$a]['item'][$a]['http_path'];
      $this->amount = $tem['result']['product'][$a]['quantity'];
    }
  }

  class Customer {
    public $fullname, $email, $phone, $register_date;

    public function __construct($a) {

      $tem = api_query('customer.list', '&params=email,created_time,phone,first_name,last_name');

      $this->fullname = $tem['result']['customer'][$a]['first_name'] . " " . $tem['result']['customer'][$a]['last_name'];
      $this->email = $tem['result']['customer'][$a]['email'];
      $this->phone = $tem['result']['customer'][$a]['phone'];
      $this->register_date = $tem['result']['customer'][$a]['created_time'];
    }
  }

  class Order {
    public $number, $store, $amount, $delivery_type;

    public function __construct($a) {

      $tem = api_query('order.list', '&params=force_all'); // Додати параметри

      // $this->number = $tem['result']; Змінити шлях
      // $this->store = $tem['result']; Змінити шлях
      // $this->amount = $tem['result']; Змінити шлях
      // $this->delivery_type = $tem['result']; Змінити шлях

    }
  }

  $order1 = new Order(0);
  $customer1 = new Customer(0);
  $product1 = new Product(0);

  ?>

  <pre>
  <?

print_r('<b>DEBUG -></b><br>');

print_r($order1->number); // Немає замовлень
print_r('Повне ім\'я замовника: ' . $customer1->fullname . '<br>'); 
print_r('Ціна продукту: ' . $product1->price . ' грн.');

  ?>
  
  </pre>

