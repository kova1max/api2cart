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

  function query($mth, $prms) {
    global $params;

    return file_get_contents('https://api.api2cart.com/v1.0/'.$mth.'.json?api_key='.$params['api'].'&cart_id='.$params['id'].'&store_url='.$params['store_url'].'&verify=false&store_key='.$params['store_key'].'&validate_version=True'.http_build_query(['params': $prms ?: 'force_all']));
  }

  $items = [
    'customer': ['email', 'created_time', 'phone', 'first_name', 'last_name'],
    'product': ['name', 'description', 'images', 'u_brand', 'quantity', 'price'],
    'order': []
  ]

  function getElements($t) {
    if(!in_array($t, ['customer', 'product', 'order']))
      return false;

    return query($t.'.list', $items[$t]);
  }

  if(isset($_GET['action']) && $_GET['action'] != ""){
    global $result;
    
    $result = getElements($_GET['action']);
  }
?>
