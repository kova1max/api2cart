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
  $result = 0;

function api_query($mth, $prms) {
  global $params;

  $i = file_get_contents('https://api.api2cart.com/v1.0/'.$mth.'.json?api_key='.$params['api'].'&cart_id='.$params['id'].'&store_url='.$params['store_url'].'&verify=false&store_key='.$params['store_key'].'&validate_version=True'.$prms);

  return $i;
}

function getElements($t) {
    if ($t == "customer") {
      $temp = api_query('customer.list', '&params=email,created_time,phone,first_name,last_name');
    }
    if ($t == "product") {
      $temp = api_query('product.list', '&params=name,description,images,u_brand,quantity,price');
    }
    if ($t == "order") {
      $temp = api_query('order.list', '&params=force_all');
    }

    return $temp;
}

if((isset($_GET['action'])) && ($_GET['action'] != "")){
  global $result;
  $result = getElements($_GET['action']);
}
?>





  <pre>
    <?
    print_r($result);
    ?>
  </pre>




