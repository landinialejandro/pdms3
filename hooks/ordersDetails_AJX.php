<?php

$currDir = dirname(__FILE__);
$base_dir = realpath("{$currDir}/..");  
if(!function_exists('makeSafe')){
    include("$base_dir/lib.php");
}  

if (isset($_POST['action']) && isset($_POST['id'])){
    $cmd   = makeSafe($_POST['action']);
    $id    = makeSafe($_POST['id']);
    $cant  = makeSafe($_POST['cant']);
    $order = makeSafe($_POST['IDorder']);
    
    
    echo processRequest($cmd, $id, $cant, $order);
    return;
}

function processRequest($cmd, $id, $cant, $order){
    $ret="ret - $cmd, $id, $cant, $order";
    
    
    if ($cmd === 'fastAdd'){
        fastAdd($id, $cant, $order);
    }
    if ($cmd === 'totOrder'){
        $parameters = $_POST['parameters'];
        $ret = getTotCol($parameters, $id);
    }
    if ($cmd === 'fastDel'){
        $ret = fastDel($id,$order);
    }
    
    return $ret;
}

function fastAdd($id, $cant, $order){
    //$order = idfrom orders
    $statment="select sellPrice from products where id = '$id'";
    $unitPrice = sqlValue($statment);
    $statment="select kinds.`value` from products left join kinds on kinds.code = products.`tax` where products.id = '$id'";
    $tax = sqlValue($statment);
    
    $imponibile = $cant * $unitPrice;
    $imposta= ($imponibile*$tax)/100;
    $today = date("Y-m-d");
    $val = $imponibile+$imposta;
    $statment = "insert into ordersDetails SET ordersDetails.manufactureDate = '$today', ordersDetails.sellDate = '$today', ordersDetails.order = '$order', productCode = '$id', QuantityReal = '$cant', taxes = '$imposta', UnitPrice = '$unitPrice', Subtotal = '$imponibile', LineTotal = '$val', transaction_type = 'Outgoing' ";
    $ret = sql($statment,$eo);
    
    //update tot order
    setTotalOrder($order);
    return $ret;
}

function setTotalOrder($order){
    $currDir = dirname(__FILE__);
    $parameters['ChildTable'] = 'ordersDetails';
    $parameters['SelectedID'] = $order;
    $parameters['ChildLookupField'] = 'order';
    $tot = floatval(getTotCol($parameters,'LineTotal'));
    sql("UPDATE orders SET OrderTotal = '{$tot}' WHERE id = {$order}",$eo);
    
    if(!function_exists('orders_after_update')){
        include("$currDir/orders.php");
    }
    $res = sql("select * from orders where id = {$order}",$eo);
    $data = db_fetch_assoc($res);
    if ($data){
        $memberInfo = getMemberInfo();
        orders_after_update($data,$memberInfo,$args);
    }
    
    return $tot;
}
        
function fastDel($id, $order){
    $statment="delete from ordersDetails where id = '$id'";
    $res=sql($statment,$eo);
    setTotalOrder($order);
    return $res;
}       