<!doctype html>
<html>
<head>
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/slider.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
    <style type="text/css">
        .button_margin {
            margin: 8%;
        }
        .banner { position: relative; overflow: auto; text-align: center;}
        .banner li { list-style: none; }
        .banner ul li { float: left; }
    </style>
    <style>
        .flexslider {
            margin: 0px auto 20px;
            position: relative;
            width: 100%;
            height: 482px;
            overflow: hidden;
            zoom: 1;
        }

        .flexslider .slides li {
            width: 100%;
            height: 100%;
        }

        .flex-direction-nav a {
            width: 70px;
            height: 70px;
            line-height: 99em;
            overflow: hidden;
            margin: -35px 0 0;
            display: block;
            background: url(/assets/img/ad_ctr.png) no-repeat;
            position: absolute;
            top: 50%;
            z-index: 10;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            -webkit-transition: all .3s ease;
            border-radius: 35px;
        }

        .flex-direction-nav .flex-next {
            background-position: 0 -70px;
            right: 0;
        }

        .flex-direction-nav .flex-prev {
            left: 0;
        }

        .flexslider:hover .flex-next {
            opacity: 0.8;
            filter: alpha(opacity=25);
        }

        .flexslider:hover .flex-prev {
            opacity: 0.8;
            filter: alpha(opacity=25);
        }

        .flexslider:hover .flex-next:hover,
        .flexslider:hover .flex-prev:hover {
            opacity: 1;
            filter: alpha(opacity=50);
        }

        .flex-control-nav {
            width: 100%;
            position: absolute;
            bottom: 10px;
            text-align: center;
        }

        .flex-control-nav li {
            margin: 0 2px;
            display: inline-block;
            zoom: 1;
            *display: inline;
        }

        .flex-control-paging li a {
            background: url(/assets/img/dot.png) no-repeat 0 -16px;
            display: block;
            height: 16px;
            overflow: hidden;
            text-indent: -99em;
            width: 16px;
            cursor: pointer;
        }

        .flex-control-paging li a.flex-active,
        .flex-control-paging li.active a {
            background-position: 0 0;
        }

        .flexslider .slides a img {
            width: 100%;
            height: 482px;
            display: block;
        }
    </style>
</head>
<body>
<?php  $CI =& get_instance();
$CI->load->library('session');?>
<div style="width: 98%;margin: 10px;">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active">
            <form method="get" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>purchasePayment/query">
                <div class="row">
                    <label for="facilitySel" class="col-sm-2 control-label">仓库:</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="facility_id" id="facilitySel">
                            <?php
                            if ($this->helper->chechActionList(array('purchaseFinanceList')) || $this->helper->chechActionList(array('purchaseManager'))) {
                                echo "<option value=\"\" >全部</option>";
                            }
                            foreach ($facility_list as $facility){
                                if (isset ($facility_id) && $facility['facility_id'] == $facility_id) {
                                    echo "<option value=\"{$facility['facility_id']}\" selected>{$facility['facility_name']}</option>";
                                }else {
                                    echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <label for="product_name" class="col-sm-2 control-label">商品:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control"  style="width: 50%;" name="product_name" id="product_name"
                            <?php if(isset($product_name)) echo "value='{$product_name}'"; ?>  >
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-sm-2 control-label">供应商:</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="supplier" name="supplier" value="<?php if(!empty($supplier)) echo $supplier;?>">
                    </div>
                    <label for="asn_date_start" class="col-sm-2 control-label">ASN开始日期:</label>
                    <div class="col-sm-3">
                        <input class="form-control"  id="asn_date_start" name="asn_date_start" value="<?php if(isset($asn_date_start)) echo $asn_date_start;?>" autocomplete="off"/>
                    </div>
                </div>
                <div class="row">
                    <label for="product_type" class="col-sm-2 control-label">产品类型:</label>
                    <div class="col-sm-3">
                        <select style="width:200px" name="product_type" id="product_type" class="form-control">
                            <?php
                            foreach ($product_type_list as $item) {
                                if (isset ($product_type) && $item['product_type'] == $product_type) {
                                    echo "<option value=\"{$item['product_type']}\" selected='true'>{$item['product_type_name']}</option>";
                                } else {
                                    echo "<option value=\"{$item['product_type']}\">{$item['product_type_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <label for="asn_date_end" class="col-sm-2 control-label">ASN结束日期:</label>
                    <div class="col-sm-3">
                        <input class="form-control"  id="asn_date_end" name="asn_date_end" value="<?php if(isset($asn_date_end)) echo $asn_date_end;?>" autocomplete="off"/>
                    </div>
                </div>
                <div class="row">
                    <label for="asn_item_id" class="col-sm-2 control-label">ASN ITEM ID:</label>
                    <div class="col-sm-3">
                        <input class="form-control"  id="asn_item_id" name="asn_item_id" value="<?php if(isset($asn_item_id)) echo $asn_item_id;?>"/>
                    </div>
                </div>
                <div class="row" style="text-align: center;">
                    <input type="button" class="btn btn-primary" id="search" value="搜索"/>
                    <input type="button" class="btn btn-primary" id="download" data-content="只能导出200条记录" value="导出"/>
                </div>

                <div style="width: 100px;margin: 0 auto;">
                    <input type="hidden"  id="act" name="act"  >
                    <input type="hidden"  id="page_current" name="page_current"
                        <?php if(isset($page_current)) echo "value={$page_current}"; ?> />
                    <input type="hidden"  id="page_count" name="page_count"
                        <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                    <input type="hidden"  id="page_limit" name="page_limit"
                        <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> />
                    <!-- 隐藏的 input  end  -->
                </div>
            </form>
        </div>
    </div>
    虚拟仓入库数量 = 实体仓入库数量+虚拟仓在途盘亏数量+虚拟仓暂存盘亏数量+虚拟仓供应商退货数量<br/>
    \只能查看用户自己拥有的条目
    <table id="listTable" class="table table-striped table-bordered " style="width: 100%;margin-top:10px;margin-right:10px;">
        <tr id="thead1">
            <th rowspan="2"></th>
            <th rowspan="2">ASN ITEM ID</th>
            <th rowspan="2">冻结</th>
            <th rowspan="2">ASN日期</th>
            <th rowspan="2">区域</th>
            <th rowspan="2">仓库</th>
            <th rowspan="2">商品名称</th>
            <th rowspan="2">PRODUCT_ID</th>
            <th rowspan="2">采购员</th>
            <th rowspan="2">供应商</th>
            <th rowspan="2">供应商类型</th>
            <th rowspan="2">申请人</th>
            <th colspan="9" style="text-align: center;">仓库</th>
            <th rowspan="2">单位</th>
            <th rowspan="2">入库含税总金额</th>
            <th colspan="7" style="text-align: center;">供应商退货</th>
            <th colspan="9" style="text-align: center;">供价调整</th>
            <th rowspan="2">应付</th>
            <th rowspan="2">坏次果退货</th>
        </tr>
        <tr id="thead2">
            <th>总数</th>
            <th>总箱数</th>
            <th>时间</th>
            <th>仓库</th>
            <th>箱数</th>
            <th>箱规</th>
            <th>入库员</th>
            <th>入库含税单价</th>
            <th>进项税率</th>
            <th>类型</th>
            <th>单价</th>
            <th>箱数</th>
            <th>箱规</th>
            <th>申请总金额</th>
            <th>退货金额</th>
            <th>收款总金额</th>
            <th>采购数量</th>
            <th>补货数量</th>
            <th>调整时状态</th>
            <th>含税总价</th>
            <th>进项税率</th>
            <th>扣除率</th>
            <th>不含税单价</th>
            <th>其他费用</th>
            <th>调整率</th>
        </tr>
        <tbody >
        <?php
        function min_multiple($a, $b) {
            //将初始值保存起来
            $i = $a;
            $j = $b;
            //辗转相除法求最大公约数
            while ($b <> 0) {
                $p = $a % $b;
                $a = $b;
                $b = $p;
            }
            return $i * $j / $a;
        }
        if( isset($purchase_finance_price_list) && is_array($purchase_finance_price_list))  foreach ($purchase_finance_price_list as $key => $order) {
            $inventory_count = count($order['inventory_list']);
            $virtual_inventory_count = count($order['virtual_inventory_list']);
            $supplier_return_count = count($order['supplier_return_list']);
            if (isset($order['history'])) {
                $history_count = count($order['history']);
            } else {
                $history_count = 1;
            }
            $history_count = $history_count == 0 ? 1 : $history_count;

            if($inventory_count == 0) {
                $inventory_count = 1;
            }
            if($virtual_inventory_count == 0) {
                $virtual_inventory_count = 1;
            }
            if($supplier_return_count == 0) {
                $supplier_return_count = 1;
            }
            $rowspans = min_multiple($inventory_count, $virtual_inventory_count);
            $rowspans = min_multiple($rowspans, $supplier_return_count);
            $rowspans = min_multiple($rowspans, $history_count);
            if (isset($order['history'])) {
                $rowspans = max($rowspans, count($order['history']));
            }
            $history_rowspan = $rowspans/$history_count;
            $virtual_rowspans = $rowspans/$virtual_inventory_count;
            $general_rowspans = $rowspans/$inventory_count;
            $supplier_rowspans = $rowspans/$supplier_return_count;
            ?>
            <tr data-id="<?php echo $order['asn_item_id'];?>" <?php if (!$order['is_identity_ok']) echo "style=\"color: red;\""?> >
                <td style="vertical-align: middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <input type="checkbox" class="checkbox" data-asn-item-id="<?php echo $order['asn_item_id'];?>"
                           data-supplier-id="<?php echo $order['product_supplier_id'] ?>">
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['asn_item_id'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['frozen'] == 1 ? '已冻结' : '未冻结' ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['asn_date'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['area_name'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['facility_name'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['product_name'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['product_id'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['purchase_user'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell supplier-name">
                    <?php echo $order['product_supplier_name'] ?>
                </td>
                <th style="vertical-align:middle;" rowspan="<?php echo $rowspans;?>" class="product_cell">
                    <?php
                    $supplierType = $order['supplier_type'];
                    if ($supplierType == 'market') {
                        echo '市场';
                    } elseif ($supplierType == 'cooperative') {
                        echo '产地供应商';
                    } elseif ($supplierType == 'company') {
                        echo '公司';

                    }
                     ?>
                </th>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo !empty($order['apply_user']) ? $order['apply_user'] : ''; ?>
                </td>

                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['arrival_real_quantity'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell arrival-case-num">
                    <?php echo $order['arrival_case_num'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                    <?php echo !empty($order['inventory_list'][0]['created_time'])?$order['inventory_list'][0]['created_time']:'' ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                    <?php echo !empty($order['inventory_list'][0]['facility_name'])?$order['inventory_list'][0]['facility_name']:'' ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                    <?php echo !empty($order['inventory_list'][0]['quantity'])?sprintf("%.2f", $order['inventory_list'][0]['quantity']):0 ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                    <?php echo !empty($order['inventory_list'][0]['unit_quantity'])?$order['inventory_list'][0]['unit_quantity']:0 ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                    <?php echo !empty($order['inventory_list'][0]['created_user'])?$order['inventory_list'][0]['created_user']:0 ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                    <?php
                    if(!empty($order['inventory_list'][0]['unit_price'])) {
                        echo $order['inventory_list'][0]['unit_price'];
                    } elseif(!empty($order['inventory_list'][0]['estimated_unit_price'])) {
                        echo $order['inventory_list'][0]['estimated_unit_price'];
                    } else {
                        echo 0;
                    }
                    ?>
                </td>
                <td style="vertical-align: middle;" rowspan="<?php echo $rowspans?>"><?php echo $order['tax_rate']?></td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php echo $order['product_unit_code'] ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                    <?php
                    $len = count($order['inventory_list']);
                    $total = 0;
                    for ($i = 0; $i < $len; $i++) {
                        if (!empty($order['inventory_list'][$i]['unit_price'])) {
                            $total += $order['inventory_list'][$i]['unit_price']*$order['inventory_list'][$i]['quantity'];
                        } elseif (!empty($order['inventory_list'][$i]['estimated_unit_price'])) {
                            $total += $order['inventory_list'][$i]['estimated_unit_price']*$order['inventory_list'][$i]['quantity'];
                        }
                    }
                    echo $total;
                    ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                    <?php
                    if( ! empty($order['supplier_return_list'][0]['return_type'])) {
                        if ($order['supplier_return_list'][0]['return_type'] == "exchange")
                            echo "换货";
                        else if ($order['supplier_return_list'][0]['return_type'] == "return")
                            echo "退货";
                        else if ($order['supplier_return_list'][0]['return_type'] == "sale")
                            echo "销售";
                    } else {
                        echo "";
                    }
                    ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                    <?php echo !empty($order['supplier_return_list'][0]['unit_price'])?$order['supplier_return_list'][0]['unit_price']:'' ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                    <?php echo !empty($order['supplier_return_list'][0]['quantity'])?$order['supplier_return_list'][0]['quantity']:'' ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                    <?php echo !empty($order['supplier_return_list'][0]['container_quantity'])?$order['supplier_return_list'][0]['container_quantity']:0 ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                    <?php echo !empty($order['supplier_return_list'][0]['apply_amount'])?sprintf('%.2f',$order['supplier_return_list'][0]['apply_amount']):0 ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                    <?php echo !empty($order['supplier_return_list'][0]['transaction_amount'])?sprintf('%.2f',$order['supplier_return_list'][0]['transaction_amount']):0 ?>
                </td>
                <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                    <?php echo !empty($order['supplier_return_list'][0]['finance_amount'])?sprintf('%.2f',$order['supplier_return_list'][0]['finance_amount']):0 ?>
                </td>


                <?php
                if (empty($order['history'])) {
                    echo "<td rowspan='$rowspans'></td><td rowspan='$rowspans'></td><td rowspan='$rowspans'></td><td rowspan='$rowspans'></td><td rowspan='$rowspans'></td>
							<td rowspan='$rowspans'></td><td rowspan='$rowspans'></td><td rowspan='$rowspans'></td><td rowspan='$rowspans'></td>";
                }else{
                    ?>

                    <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;" class="product_cell"><?php if ($order['history'][0]['purchase_unit'] == 'case'){echo $order['history'][0]['case_num'];}else{echo $order['history'][0]['kg_num']*2;}?></td>
                    <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;" class="product_cell"><?php if ($order['history'][0]['purchase_unit'] == 'case'){echo $order['history'][0]['replenish_case_num'];}else{echo $order['history'][0]['replenish_kg_num']*2;}?></td>
                    <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;" class="product_cell"><?php echo $financeStatus[$order['history'][0]['modified_finance_status']]?></td>
                    <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;" class="product_cell"><?php echo $order['history'][0]['total_price']?></td>
                    <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;" class="product_cell"><?php echo $order['history'][0]['tax_rate']?></td>
                    <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;" class="product_cell"><?php echo $order['history'][0]['deduction_rate']?></td>
                    <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;" class="product_cell"><?php
                        if ($order['history'][0]['purchase_unit'] == 'case') {
                            $amount = $order['history'][0]['case_num']+$order['history'][0]['replenish_case_num'];
                        } else {
                            $amount = $order['history'][0]['kg_num']*2+$order['history'][0]['replenish_kg_num']*2;
                        }
                        $taxRate = $order['history'][0]['tax_rate'] == '' ? 0 : $order['history'][0]['tax_rate'];
                        $deductionRate = $order['history'][0]['deduction_rate'] ? 0 : $order['history'][0]['deduction_rate'];
                        $unitPrice = ($order['history'][0]['total_price'] - $order['history'][0]['total_price']/(1+$taxRate)*$deductionRate)/$amount;
                        echo sprintf('%.2f', $unitPrice);
                        ?></td>

                    <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;" class="product_cell"><?php echo $order['history'][0]['other_price']?></td>

                    <?php
                    if (count($order['history']) == 1) {
                        $adjusted = $order['purchase_total_price'];
                    } else {
                        $adjusted = $order['history'][1]['total_price'] + $order['history'][1]['other_price'];
                    }
                    $before = $order['history'][0]['total_price']+$order['history'][0]['other_price'];
                    if ($before) {
                        $rate = sprintf('%.3f',($adjusted-$before)*100/$before);
                    } else {
                        $rate = 0;
                    }
                    $style = $rate>=10 || $rate <= -10?'font-weight: 600; color: #0C1CEA':'';
                    echo "<td rowspan='$history_rowspan' style='vertical-align:middle;$style' class='product_cell'>$rate%</td>";

                    ?>
                <?php }
                ?>
                <td hidden="hidden" class="defective-return-list">
                    <?php
                    $defectiveSum = 0;
                    foreach ($order['defectiveReturnList'] as $defective) {
                        $defectiveSum += $defective['total_price'];
                        echo "{{tr data-id='$defective[supplier_return_id]'}}{{td}}$defective[supplier_return_id]{{/td}},
                                   {{td}} $defective[product_name]{{/td}},
                                  {{td}}  $defective[type]{{/td}},
                                  {{td}}  $defective[total_price]{{/td}}
                                  {{td}}{{input class='btn btn-danger btn-delete' type='button' value='删除'}}{{/td}}{{/tr}}";
                    }
                    ?>
                </td>
                <td hidden="hidden" class="original-amount">
                    <?php
                    $return_sum = 0;
                    foreach($order['supplier_return_list'] as $item) {
                        if ($item['return_type'] == 'return')
                            $return_sum += $item['transaction_amount'];
                    }
                    $original_amount = $order['purchase_total_price']-$return_sum;
                    echo sprintf('%.2f',$original_amount);
                    ?>
                </td>
                <td class="amount" rowspan="<?php echo $rowspans; ?>" style="vertical-align: middle">
                    <?php echo sprintf('%.2f',$original_amount-$defectiveSum); ?>
                    </td>
                <td style="vertical-align: middle;" rowspan="<?php echo $rowspans;?>">
                    <input type="button" class="btn btn-primary return-btn"  value="坏次果退货"><br>
                    <input type="button" class="btn btn-success return-view" style="width:96px" value="查看" >
                </td>
                <td hidden="hidden" class="supplier-type"><?php echo $order['supplier_type']; ?></td>
            </tr>

            <?php for($i=1; $i< $rowspans; $i++) {
                ?>
                <tr data-id="<?php echo $order['asn_item_id']; ?>" <?php if (!$order['is_identity_ok']) echo "style=\"color: red;\""?>>
                    <?php if($i % $general_rowspans == 0) {?>
                        <td class="product_cell"  rowspan="<?php echo $general_rowspans ?>">
                            <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['created_time'])?$order['inventory_list'][$i/$general_rowspans]['created_time']:'' ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $general_rowspans ?>">
                            <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['facility_name'])?$order['inventory_list'][$i/$general_rowspans]['facility_name']:'' ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $general_rowspans ?>">
                            <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['quantity'])?sprintf("%.2f",$order['inventory_list'][$i/$general_rowspans]['quantity']):0 ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $general_rowspans ?>">
                            <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['unit_quantity'])?$order['inventory_list'][$i/$general_rowspans]['unit_quantity']:0 ?>
                        </td>
                        <td rowspan="<?php echo $general_rowspans?>" class="product_cell">
                            <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['created_user'])?$order['inventory_list'][$i/$general_rowspans]['created_user']:0 ?>
                        </td>
                        <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                            <?php
                            if(!empty($order['inventory_list'][$i/$general_rowspans]['unit_price'])) {
                                echo $order['inventory_list'][$i/$general_rowspans]['unit_price'];
                            } elseif(!empty($order['inventory_list'][$i/$general_rowspans]['estimated_unit_price'])) {
                                echo $order['inventory_list'][$i/$general_rowspans]['estimated_unit_price'];
                            } else {
                                echo 0;
                            }
                            ?>
                        </td>
                    <?php }?>
                    <?php if($i % $supplier_rowspans == 0) {?>
                        <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                            <?php
                            if( ! empty($order['supplier_return_list'][$i/$supplier_rowspans]['return_type'])) {
                                if ($order['supplier_return_list'][$i/$supplier_rowspans]['return_type'] == "exchange")
                                    echo "换货";
                                else if ($order['supplier_return_list'][$i/$supplier_rowspans]['return_type'] == "return")
                                    echo "退货";
                                else if ($order['supplier_return_list'][$i/$supplier_rowspans]['return_type'] == "sale")
                                    echo "销售";
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
                            <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['unit_price'])?$order['supplier_return_list'][$i/$supplier_rowspans]['unit_price']:'' ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
                            <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['quantity'])?sprintf("%.2f",$order['supplier_return_list'][$i/$supplier_rowspans]['quantity']):'' ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
                            <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['container_quantity'])?sprintf("%.2f",$order['supplier_return_list'][$i/$supplier_rowspans]['container_quantity']):'' ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
                            <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['apply_amount'])?sprintf("%.2f",$order['supplier_return_list'][$i/$supplier_rowspans]['apply_amount']):'' ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
                            <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['transaction_amount'])?sprintf("%.2f",$order['supplier_return_list'][$i/$supplier_rowspans]['transaction_amount']):'' ?>
                        </td>
                        <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
                            <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['finance_amount'])?$order['supplier_return_list'][$i/$supplier_rowspans]['finance_amount']:'' ?>
                        </td>
                    <?php }?>
                    <?php if ($i % $history_rowspan == 0){
                        $unit = $order['history'][$i/$history_rowspan]['purchase_unit'];
                        $ordinal = $i/$history_rowspan;?>
                        <td rowspan="<?php echo $history_rowspan; ?>"  style="vertical-align:middle;" class="product_cell">
                            <?php if($unit=='case'){echo $order['history'][$i/$history_rowspan]['case_num'];}else{echo $order['history'][$ordinal]['kg_num'];} ?></td>
                        <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;"  class="product_cell">
                            <?php if($unit=='case'){echo $order['history'][$i/$history_rowspan]['replenish_case_num'];}else{echo $order['history'][$ordinal]['replenish_kg_num'];} ?></td>
                        <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;"  class="product_cell">
                            <?php echo $financeStatus[$order['history'][$i/$history_rowspan]['modified_finance_status']]; ?></td>
                        <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;"  class="product_cell">
                            <?php echo $order['history'][$i/$history_rowspan]['total_price']; ?></td>
                        <td rowspan="<?php echo $history_rowspan; ?>" style="vertical-align:middle;"  class="product_cell">
                            <?php echo $order['history'][$i/$history_rowspan]['tax_rate']; ?></td>
                        <td rowspan="<?php echo $history_rowspan;?>" style="vertical-align: middle;" class="product_cell">
                            <?php echo $order['history'][$i/$history_rowspan]['deduction_rate']; ?>
                        </td>
                        <td rowspan="<?php echo $history_rowspan;?>" style="vertical-align: middle;" class="product_cell">
                            <?php
                            if ($order['history'][$ordinal]['purchase_unit'] == 'case') {
                                $amount = $order['history'][$ordinal]['case_num']+$order['history'][$ordinal]['replenish_case_num'];
                            } else {
                                $amount = $order['history'][$ordinal]['kg_num']*2+$order['history'][$ordinal]['replenish_kg_num']*2;
                            }
                            $taxRate = $order['history'][$ordinal]['tax_rate'] == '' ? 0 : $order['history'][$ordinal]['tax_rate'];
                            $deductionRate = $order['history'][$ordinal]['deduction_rate'] == ''? 0 : $order['history'][$ordinal]['deduction_rate'];
                            $unitPrice = ($order['history'][$ordinal]['total_price'] - $order['history'][$ordinal]['total_price']/(1+$taxRate)*$deductionRate)/$amount;
                            echo sprintf('%.2f', $unitPrice);
                            ?>
                        </td>
                        <td rowspan="<?php echo $history_rowspan; ?>"  style="vertical-align:middle;" class="product_cell">
                            <?php echo $order['history'][$i/$history_rowspan]['other_price']; ?></td>
                        <?php
                        if ($ordinal == $history_count-1) {
                            $adjusted = $order['purchase_total_price'];
                        } else {
                            $adjusted = $order['history'][$ordinal+1]['total_price'] + $order['history'][$ordinal+1]['other_price'];
                        }
                        $before = $order['history'][$ordinal]['total_price']+$order['history'][$ordinal]['other_price'];
                        if ($before) {
                            $rate = sprintf('%.3f',($adjusted-$before)*100/$before);
                        } else {
                            $rate = 0;
                        }
                        $style = $rate>=10 || $rate <=-10?'font-weight: 600; color: #0C1CEA':'';
                        echo "<td rowspan='$history_rowspan' style='vertical-align:middle;$style' class='product_cell'>$rate%</td>";
                        ?>
                    <?php } ?>


                </tr>
            <?php }?>
        <?php }?>
        </tbody>

    </table>
    <div class="row">
        <nav style="float: right;margin-top: -7px;">
            <ul class="pagination">
                <li>
                    <a href="#"   id="page_prev">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php if(isset($page)) echo $page; ?>
                <li>
                    <a href="#" id="page_next" >
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li><a href='#'>
                        <?php if(isset($page_count)) echo "共{$page_count}页 &nbsp;";
                        if(isset($record_total))  echo  "共{$record_total}条记录";
                        ?>
                    </a></li>
            </ul>
        </nav>
    </div>


</div>
<!-- 上传Modal -->
<div>
    <div class="modal fade ui-draggable text-center" id="uploadModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 600px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" style="text-align: left; margin-left:15%">
                        <div class='row'>
                            <label  style="text-align: right;">扫描件：</label><input type="file"  name="uploaded_file" id="upload-file" >
                        </div>
                </div>
                <div class="modal-footer">
                    <input id="doUpload" type="button" class="btn btn-primary" style="text-align: right" value="提交">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal end  -->
<!--return modal-->
<div>
    <div class="modal fade ui-draggable text-center" id="returnModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 600px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">坏次果退货</h4>
                </div>
                <div class="modal-body" style="text-align: left; margin-left:15%">
                        <div class='row'>
                            <label  class="control-label col-md-2" style="text-align: right;">RETURN_ID：</label>
                            <div class="col-md-5">
                                <input type="text" placeholder="多个ID以逗号隔开" class="form-control" name="return_id" id="return_id" >
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input id="return_submit" type="button" class="btn btn-primary" style="text-align: right" value="提交">
                </div>
            </div>
        </div>
    </div>
</div>
<!--return modal end-->
<!-- 显示 modal -->
<div>
    <div class="modal fade ui-draggable text-center" id="viewModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 600px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">扫描件</h4>
                </div>
                <div class="modal-body" style="text-align: left;">
                    <div>
                        <table class="table table-striped table-bordered">
                            <tr><td>RETURN_ID</td><td>类型</td><td>商品名</td><td>金额</td><td>操作</td></tr>
                            <tbody id="return_list">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="delete" class="btn btn-primary" type="button" value="删除">
                    <input id="view" data-dismiss="modal" type="button" class="btn btn-primary" style="text-align: right" value="确定">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal end-->
<!-- 付款申请 modal-->
<div>
    <div class="modal fade ui-draggable text-center" id="paymentModal" role="dialog">
        <div class="modal-dialog" style="display: inline-block; width: 900px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">付款申请</h4>
                </div>
                <div class="modal-body" style="text-align: left;">
                    <div class="row"></div>
                    <div style="overflow: auto;">
                        <table id="resultTable" class="table table-striped table-bordered">
                        </table>
                    </div>
                    <div class="row">

                        <label for="note" class="control-label col-md-2">备注</label>
                        <div class="col-md-3">
                            <input id="note" type="text" class="form-control">
                        </div>
                        <label for="amount" class="control-label col-md-2">应付合计</label>
                        <div class="col-md-3">
                            <input id="amount" type="text" readonly="true" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <label for="unit" class="control-label col-md-2">收款单位</label>
                        <div class="col-md-3">
                            <input id="unit" type="text" class="form-control">
                        </div>
                        <label for="bank" class="control-label col-md-2">收款银行</label>
                        <div class="col-md-3">
                            <input id="bank" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <label for="account" class="control-label col-md-2">收款账号</label>
                        <div class="col-md-3">
                            <input id="account" type="text" class="form-control">
                        </div>
                        <label for="area" class="control-label col-md-2">所属大区</label>
                        <div class="col-md-3">
                            <select id="area" name="area" class="form-control">
                                <?php foreach ($area_list as $area) {
                                    echo "<option value=\"{$area['area_id']}\">{$area['area_name']}</option>";
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="genRequest"  type="button" class="btn btn-primary" style="text-align: right" value="立即申请">
                </div>
            </div>
        </div>
    </div>
</div>
<!--  end -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
    var property={
        divId:"demo1",
        needTime:true,
        yearRange:[1970,2030],
        week:['日','一','二','三','四','五','六'],
        month:['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        format:"yyyy-MM-dd hh:mm:00"
    };

    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd HH:mm:ss';
        // [more..]
    })($.calendar.setting);


    $(document).ready(function(){
        $("#start_time").calendar({btnBar:true,
            minDate:'2010-05-01',
            maxDate:'2022-05-01'});
        $("#end_time").calendar({  btnBar:true,
            minDate:'#start_time',
            maxDate:'2022-05-01'});
        $("#asn_date_start").calendar({  btnBar:true,
            minDate:'2010-05-01',
            maxDate:'2022-05-01',
            format:'yyyy-MM-dd'});
        $("#asn_date_end").calendar({  btnBar:true,
            minDate:'2010-05-01',
            maxDate:'2022-05-01',
            format:'yyyy-MM-dd'});
        $("#download").popover({"trigger":"hover"});

    }) ;  // end document ready function

    var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
    var upload_path = "<?php echo $upload_path;?>";;

    // 点击下载 excel 按钮
    $('#download').click(function(){
        $("#act").val("download");
        $("form").submit();
        $("#act").val("query");
    });


    $("#search").click(function(){
        $("#page_current").val("1");
        $("form").submit();
    });

    // 分页
    $('a.page').click(function(){
        var page =$(this).attr('p');
        $("#page_current").val(page);
        $("form").submit();
    });

    // 上一页
    $('a#page_prev').click(function(){
        var page = $("#page_current").val();
        if(page != parseInt(page) ) {
            $('#page_current').val(1);
            page = 1;
        }else{
            page = parseInt(page);
            if(page > 1 ){
                page = page - 1;
                $('#page_current').val(page);
                $("form").submit();
            }
        }
    });

    // 下一页
    $('a#page_next').click(function(){
        var page = $("#page_current").val();
        page = parseInt(page);
        var page_count = $("#page_count").val();
        page_count = parseInt(page_count);
        if(page < page_count ){
            page = page + 1;
            $("#page_current").val(page);
            $("form").submit();
        }
    });
    $(".return-view").click(function(){
        var items = $(this).parent().parent().find('.defective-return-list').html();
        asn_item_id = $(this).parent().parent().attr('data-id');
        items = items.replace(/{{/g,'<');
        items = items.replace(/}}/g,'>');
        console.log(items);
        $("#return_list").html(items);
        $("#viewModal").modal('show');
    });
    $(".return-btn").click(function(){
        asn_item_id = $(this).parent().parent().attr('data-id');
        $("#returnModal").modal('show');
    });
    $("#return_submit").click(function(){
        var ids = $("#return_id").val();
        $("")
        if (ids == '') {
            alert("请输入RETURN ID");
            return false;
        }
        ids = ids.replace(/，/g,',');
        $.ajax({
            url:WEB_ROOT+'purchasePayment/addDefectiveReturn',
            type:'GET',
            dataType:'json',
            data:{ids:ids,asn_item_id:asn_item_id},
            success:function(data){
                if (data.message == 'success') {
                    var len = data.data.length;
                    var rows = '';
                    var defectiveSum = 0;
                    for (var i = 0; i < len; i++) {
                        rows += '{{tr data-id="'+data.data[i].supplier_return_id+'"}}';
                        rows += '{{td}}'+data.data[i].supplier_return_id+'{{/td}}';
                        rows += '{{td}}'+data.data[i].type+'{{/td}}';
                        rows += '{{td}}'+data.data[i].product_name+'{{/td}}';
                        rows += '{{td}}'+data.data[i].total_price+'{{/td}}';
                        rows += '{{td}}{{button class="btn btn-danger btn-delete" value="删除"}}{{/td}}';
                        rows += '{{tr}}';
                        defectiveSum += parseFloat(data.data[i].total_price);
                    }
                    $("tr[data-id="+asn_item_id+"]").find('.defective-return-list').html(rows);
                    var amount = parseFloat($("tr[data-id="+asn_item_id+"]").find('.original-amount').html())-defectiveSum;
                    console.log(amount);
                    $("tr[data-id="+asn_item_id+"]").find('.amount').html(amount);
                    $("#returnModal").modal('hide');
                } else {
                    alert(data.error_info);
                }

            }
        })
    });
    $(document).on('click','.btn-delete',function(){
        var returnId = $(this).parent().parent().attr('data-id');
        $.ajax({
            url:WEB_ROOT+'purchasePayment/removeDefectiveReturn',
            type:'GET',
            dataType:'json',
            data:{id:returnId,asn_item_id:asn_item_id},
            success:function(data){
                if (data.message == 'success') {
                    var len = data.data.length;
                    var rows = '';
                    var defectiveSum = 0;
                    for (var i = 0; i < len; i++) {
                        rows += '{{tr data-id="'+data.data[i].supplier_return_id+'"}}';
                        rows += '{{td}}'+data.data[i].supplier_return_id+'{{/td}}';
                        rows += '{{td}}'+data.data[i].type+'{{/td}}';
                        rows += '{{td}}'+data.data[i].product_name+'{{/td}}';
                        rows += '{{td}}'+data.data[i].total_price+'{{/td}}';
                        rows += '{{td}}{{input class="btn btn-danger btn-delete" type="button" value="删除"}}{{/td}}';
                        rows += '{{tr}}';
                        defectiveSum += parseFloat(data.data[i].total_price);
                    }
                    $("tr[data-id="+asn_item_id+"]").find('.defective-return-list').html(rows);
                    var amount = parseFloat($("tr[data-id="+asn_item_id+"]").find('.original-amount').html())-defectiveSum;
                    console.log(amount);
                    $("tr[data-id="+asn_item_id+"]").find('.amount').html(amount);
                    $("#viewModal").modal('hide');
                } else {
                    alert(data.error_info);
                }
            }
        })
    });

    var requestType;
    $("#genPayment").click(function(){
        paymentRequest();
    });
    var items;
    function paymentRequest(){
        items = [];
        var checked = $('#listTable .checkbox:checked');
        var sum = 0;
        if (!checked.length) {
            alert('请勾选数据');
            return;
        }
        supplierId = $(checked[0]).attr('data-supplier-id');
        requestType = 'G';
        var first = true;
        for (var i = 0; i < checked.length; i++) {
            var tr = $(checked[i]).parent().parent();
            var supplier = tr.find('.supplier-name').html();
            if (supplier.indexOf('PO调整')!=-1 || supplier.indexOf('规格转换')!=-1) {
                items.push($(checked[i]).attr('data-asn-item-id'));
                continue;
            }
            if (first) {
                type = tr.find('.supplier-type').html();
                supplierId = $(checked[i]).attr('data-supplier-id');
                if (type=='company'||type=='cooperative') {
                    requestType = 'G';
                } else if (type=='market') {
                    requestType = 'S';
                } else {
                    alert(type)
                    alert("请确保供应商类型正确");
                    return;
                }
                first = false;
            }

            if (type == 'company' || type == 'cooperative') {
                if ($(checked[i]).attr('data-supplier-id') != supplierId) {
                    alert("生成对公付款申请时除PO调整外供应商必须相同");
                    return;
                }
            } else if (type == 'market') {
                if (tr.find('.supplier-type').html()!='market') {
                    alert("供应商类型不同不能生成付款申请");
                    return;
                }
            } else {
                alert("请确保供应商类型正确");
                return;
            }


            if ($(checked[i]).parent().parent().find('.image-url').val()=='' ||
                 $(checked[i]).parent().parent().find('.image-url').val()==undefined) {
                if (supplier.indexOf('PO调整')==-1 && supplier.indexOf('规格转换')==-1) {
                    alert('请先上传扫描件');
                    return;
                }
            }
            items.push($(checked[i]).attr('data-asn-item-id'));
            sum += parseFloat($(checked[i]).parent().parent().find('.amount').html());
        }
        if (first) {
            alert('不能全为PO调整或规格转换');
            return;
        }
        $("#resultTable").html('');
        var head1 = $('#thead1').clone();
        head1.find(':first').remove();
        head1.find(':last').remove();
        $('#resultTable').append(head1);
        $('#resultTable').append($('#thead2').clone());
        var row;
        for (var i = 0; i <checked.length; i++) {
            row = $(checked[i]).parent().parent().clone();
            row.find(":first").remove();
            row.find("td:last").remove();
            row.find("td:last").remove();
            $('#resultTable').append(row);
        }
        $("#amount").val(sum);
        $("#paymentModal").modal("show");
        if (requestType == 'S') {
            $("#unit").attr('readonly','readonly');
            $("#bank").attr('readonly','readonly');
            $("#account").attr('readonly','readonly');
        }
    }
    $(".btn-upload").click(function(){
        $("#uploadModal").modal("show");
        $("#upload-file").val('');
        asnItemId = $(this).parent().parent().find(".checkbox").attr("data-asn-item-id");
        uploadTd = $(this).parent();
    });
    $("#doUpload").click(function(){
        var formData = new FormData();
        formData.append('asnItemId', asnItemId);
        formData.append('file',document.getElementById("upload-file").files[0]);
        $.ajax({
            type:'POST',
            url:WEB_ROOT+'purchasePayment/upload',
            data:formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success:function(data) {
                if (data.success == 'true') {
                    alert("上传成功");
                    if (!uploadTd.find('.btn-view').length) {
                        $('<input type="button" class="btn btn-success btn-view" value="查看">').appendTo(uploadTd);
                        $('<input type="hidden" class="image-url" value="'+data.path+'">').appendTo(uploadTd);
                    } else {
                        var imageURL = uploadTd.find('.image-url');
                        imageURL.val(imageURL.val()+','+data.path);
                    }
                    $(window.parent.document).find('tr[data-id='+asnItemId+']').find('.image-operation').html(uploadTd.html());
                } else {
                    alert("上传失败："+data.error_info);
                }
            }
        });
        $("#uploadModal").modal("hide");
    })
    function genUl(urls) {
        var element = '<ul class="slides">';
        var len = urls.length;
        for (var i = 0; i < len; i++) {
            element += '<li id="i'+urls[i].substring(0,urls[i].lastIndexOf('.'))+'"><a><img height="400px" width="600px" style="background: url('+WEB_ROOT+upload_path+urls[i]+') no-repeat center;" src="/assets/img/alpha.png"></a></li>';
        }
        element += '</ul>'
        element += '<ul class="flex-direction-nav">';
        element += '<li><a class="flex-prev" href="javascript:;">Previous</a></li>';
        element += '<li><a class="flex-next" href="javascript:;">Next</a></li>';
        element += '</ul>';
        element += '<ol id="bannerCtrl" class="flex-control-nav flex-control-paging">';
        for(var i = 0; i < len; i++) {
            if (i==0) {
                element +='<li class="active" data-ordinal="'+i+'"><a>'+urls[i]+'</a></li>';
            } else {
                element +='<li data-ordinal="'+i+'"><a>'+urls[i]+'</a></li>';
            }
        }
        return element + '</ol>';
    }
    $(document).on('click','.btn-view',function(){
        var urls = $(this).parent().find(".image-url").val().split(',');
        asnItemId = $(this).parent().parent().find(".checkbox").attr("data-asn-item-id");
        $("#images").html(genUl(urls));
        var bannerSlider = new Slider($('#images'), {
            time: 5000,
            delay: 400,
            event: 'hover',
            auto: true,
            mode: 'fade',
            controller: $('#bannerCtrl'),
            activeControllerCls: 'active'
        });
        $('#images .flex-prev').click(function() {
            bannerSlider.prev()
        });
        $('#images .flex-next').click(function() {
            bannerSlider.next()
        });
        $("#viewModal").modal("show");
    });
    $("#delete").click(function() {
        var active = $("#bannerCtrl").find("li.active");
        var url = active.find('a').html();
        var ordinal = active.attr("data-ordinal");
        $.ajax({
            url: WEB_ROOT+'purchasePayment/deleteImage',
            type: "GET",
            dataType:'json',
            data: {url:url,asn_item_id:asnItemId},
            success: function(data) {
                if (data.success=='true') {
                    active.remove();
                    $("#i"+url.substring(0,url.lastIndexOf('.'))).remove();
                    var urls = $("tr[data-id="+asnItemId+"]").find('.image-url').val();
                    var urlsArray = urls.split(',');
                    var len = urlsArray.length;
                    for (var i = 0; i < len; i++) {
                        if (urlsArray[i]==url) {
                            urlsArray.splice(i,1);
                            break;
                        }
                    }
                    if (urlsArray.length == 0) {
                        $("tr[data-id="+asnItemId+"]").find('.image-url').remove();
                        $("tr[data-id="+asnItemId+"]").find('.btn-view').remove();
                    } else {
                        $("tr[data-id="+asnItemId+"]").find('.image-url').val(urlsArray.join(','));
                    }

                }
                console.log(data)
            }
        })
        console.log(url);
        console.log(ordinal);
    });
    $("#genRequest").click(function(){
        var unit = $("#unit").val();
        var bank = $("#bank").val();
        var account = $("#account").val();
        var area = $("#area").val();
        if (requestType == 'G' && (unit == '' || bank == '' || account == '')) {
            alert("请填写收款方信息");
            return;
        }
        $.ajax({
            url: WEB_ROOT+'purchasePayment/genRequest',
            type: "POST",
            data:{requestType:requestType,area:area,unit:unit,bank:bank,account:account,asn_items:items,supplier_id:supplierId,note:$("#note").val()},
            dataType:'json',
            success: function(data) {
                if (data.error_info) {
                    alert(data.error_info);
                } else if (data.data.message=='success'){
                    alert('生成付款申请成功');
                    var len = items.length;
                    for (var i = 0; i < len; i++) {
                        $("tr[data-id="+items[i]+"]").remove();
                    }
                    $("#paymentModal").modal('hide');
                }
            }
        });


    });
</script>
</body>
</html>
