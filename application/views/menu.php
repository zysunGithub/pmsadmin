<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body id="body-menu" style="overflow-y:scroll;">  
<div id="menu-wrap">
    <ul id="main-menu">
    	<?php if($this->helper->chechActionList(array("caigouManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>采购管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    		<?php if($this->helper->chechActionList(array('purchaseCommit'))) {?>
	    		<li>
	    			<a href="./purchaseCommit" target="main-frame">采购承诺(PO)</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('loadingBill'))) {?>
	    		<li>
	    			<a href="./loadingBill?product_type=goods" target="main-frame" >创建装车单</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('loadingBillList'))) {?>
	    		<li>
	    			<a href="./loadingBillList" target="main-frame" >bol装车单列表</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('asnFinish'))) {?>
		    		<li>
		    			<a href="./asnFinish" target="main-frame" >asn预到货通知单</a>
		    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchasePrice'))) {?>
	    		<li>
	    			<a href="./purchasePrice" target="main-frame" >采购价格录入</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchaseFinanceApply')) || $this->helper->chechActionList(array('purchaseManager'))) {?>
	    		<li>
	    			<a href="./purchaseFinanceList" target="main-frame" >财务申请</a>
	    		</li>
<!--				<li>-->
<!--					<a href="./purchasePayment/paymentRequestPanel" target="main-frame">付款申请</a>-->
<!--				</li>-->
<!--				<li>-->
<!--					<a href="./purchasePayment/requestList" target="main-frame">付款申请列表</a>-->
<!--				</li>-->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('arnormalBolItemList'))) {?>
		    		<li>
		    			<a href="./arnormalBolItemList" target="main-frame" >bol异常清单</a>
		    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('inventoryTransactionList'))) {?>
	    		<li>
	    			<a href="./inventoryTransactionList/product_list" target="main-frame" >查看库存</a>
	    		</li>
    		<?php }?>
            <?php if($this->helper->chechActionList(array('badProductList'))) {?>
                <li>
                    <a href="./badProduct/getBadProductList" target="main-frame" >坏次果列表</a>
                </li>
            <?php }?>
    		<?php if($this->helper->chechActionList(array('purchaseForecast'))) {?>
	    		<li>
	    			<a href="./purchaseForecast" target="main-frame" >采购预估</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchaseForecast'))) {?>
	    		<li>
	    			<a href="./purchaseForecastList" target="main-frame" >采购预估列表</a>
	    		</li>
    		<?php }?> 
    		<?php if($this->helper->chechActionList(array('purchaseForecast'))) {?>
	    		<li>
	    			<a href="./areaPurchaseForecast" target="main-frame" >采购预估汇总</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchasePlace'))) {?>
	    		<li>
	    			<a href="./purchasePlace" target="main-frame" >采购地点列表</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('transferException'))) {?>
	    		<li>
	    			<a href="./transferException/unPurchaseIn" target="main-frame" >调度未入库</a>
	    		</li>
	    		<li>
	    			<a href="./transferException/unTransferOut" target="main-frame" >调度未出库</a>
	    		</li>
	    		<li>
	    			<a href="./transferException/facilityDiff" target="main-frame" >调拨与仓库差异</a>
	    		</li>
	    		<li>
	    			<a href="./transferException/purchaseDiff" target="main-frame" >调度与采购差异</a>
	    		</li>
			<?php }?>
			<?php if($this->helper->chechActionList(array('supplierReturn'))) {?>
	    		<li>
	    			<a href="./supplierReturnList/index" target="main-frame" >供应商退货申请</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('supplierReturnList'))) {?>
	    		<li>
	    			<a href="./supplierReturnList/query" target="main-frame" >供应商退货申请列表</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchasePlaceFacility'))) {?>
    			<li>
	    			<a href="./purchasePlaceFacility" target="main-frame" >采购地仓库对应关系</a>
	    		</li>
	    	<?php }?>
            <?php if($this->helper->chechActionList(array('packageTransformList'))) {?>
            <li>
                <a href="./productTransformApply/packageTransformList" target="main-frame" >包裹转原料申请列表</a>
            </li>
            <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array('suppliesCaigouManager'))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>耗材采购管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    			<?php if($this->helper->chechActionList(array('purchaseCommit'))) {?>
    				<li>
    					<a href="./purchaseCommit/suppliesIndex" target="main-frame" >采购承诺(PO)</a>
    				</li>
    			<?php }?>
				<?php if($this->helper->chechActionList(array('suppliesLoadingBill'))) {?>
					<li>
						<a href="./loadingBill?product_type=supplies" target="main-frame" >创建装车单</a>
					</li>
				<?php }?>
    			<?php if($this->helper->chechActionList(array('loadingBillList'))) {?>
                    <li>
                        <a href="./loadingBillList/suppliesIndex" target="main-frame" >bol装车单列表</a>
                    </li>
                <?php }?>
	    		<?php if($this->helper->chechActionList(array('asnFinish'))) {?>
			    		<li>
			    			<a href="./asnFinish/suppliesIndex" target="main-frame" >asn预到货通知单</a>
			    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('purchasePrice'))) {?>
		    		<li>
		    			<a href="./purchasePrice/suppliesIndex" target="main-frame" >采购价格录入</a>
		    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('purchaseFinanceApply')) || $this->helper->chechActionList(array('purchaseManager'))) {?>
	    		<li>
	    			<a href="./purchaseFinanceList" target="main-frame" >财务申请</a>
	    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('arnormalBolItemList'))) {?>
			    		<li>
			    			<a href="./arnormalBolItemList" target="main-frame" >bol异常清单</a>
			    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('inventoryTransactionList'))) {?>
		    		<li>
		    			<a href="./inventoryTransactionList/product_list" target="main-frame" >查看库存</a>
		    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('productSupplier'))) {?>
		    		<li>
		    			<a href="./productSupplierList" target="main-frame" >耗材供应商列表</a>
		    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('supplierReturn'))) {?>
		    		<li>
		    			<a href="./supplierReturnList/index?product_type=supplies" target="main-frame" >供应商退货申请</a>
		    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('supplierReturnList'))) {?>
		    		<li>
		    			<a href="./supplierReturnList/query?product_type=supplies" target="main-frame" >供应商退货申请列表</a>
		    		</li>
	    		<?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	
        <?php if($this->helper->chechActionList(array('productSupplierManager'))) {?>
        <li class="has-sub-menu">
            <i class="fa fa-chevron-down chevron"></i>
            <a href="#">
                <i class="fa fa-laptop"></i>供应商管理
            </a>
            <ul class="sub-menu sub-menu-hidden">
                <?php if($this->helper->chechActionList(array('productSupplier'))) {?>
                <li>
                    <a href="./productSupplierList" target="main-frame" >供应商列表</a>
                </li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
        <?php if($this->helper->chechActionList(array('merchantManagerTitle'))) {?>
        <li class="has-sub-menu">
            <i class="fa fa-chevron-down chevron"></i>
            <a href="#">
                <i class="fa fa-laptop"></i>商户档案管理
            </a>
            <ul class="sub-menu sub-menu-hidden">
                <?php if($this->helper->chechActionList(array('merchantList'))) {?>
                <li>
                    <a href="./merchantList" target="main-frame" >商户列表</a>
                </li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
		<?php if($this->helper->chechActionList(array("goodsManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>商品档案管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
             <?php if($this->helper->chechActionList(array('goodsFinishedMaterial'))) {?>
                 <li>
                    <a href="./GoodsFinishedMaterial" target="main-frame" >商品映射关系查询</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('goodsProduct'))) {?>
                 <li>
                    <a href="./goodsApply/goodsProduct" target="main-frame" >OMS商品档案申请</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('goodsApplyList'))) {?>
                 <li>
                    <a href="./goodsApply/goodsApplyList" target="main-frame" >OMS商品档案申请列表</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('product'))) {?>
                 <li>
                    <a href="./product" target="main-frame" >产品档案</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('productFacilityShippingList'))) {?>
                 <li>
                    <a href="./productFacilityShippingList" target="main-frame" >商品仓库快递列表</a>
                 </li>
             <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("suppliesManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>耗材档案管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
             <?php if($this->helper->chechActionList(array('product'))) {?>
                 <li>
                    <a href="./product" target="main-frame" >产品档案</a>
                 </li>
             <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("orderManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>订单管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
             <?php if($this->helper->chechActionList(array('orderCount'))) {?>
	    		<li>
	    			<a href="./orderCount" target="main-frame" >订单统计</a>
	    		</li>
	    	<?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("systemManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>系统设置
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    		<?php if($this->helper->chechActionList(array('assignCredit'))) {?>
	    		<li>
	    			<a href="./userRole" target="main-frame" >权限分配</a>
	    		</li>
	    		<li>
	    			<a href="./userRole/userRoleList" target="main-frame" >用户列表</a>
	    		</li>
    		<?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    </ul>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		
         $("#main-menu .has-sub-menu>a").on("click",function(){
			$(this).next().stop().slideToggle(300)
			.end()
			.prev().toggleClass("rotate-up")
			.end()
			.parent().siblings().find(".chevron").removeClass("rotate-up");

			$(this).parent().toggleClass("active")
			.siblings().removeClass("active").find(".sub-menu").stop().slideUp(300);
		});

		$(".sub-menu a").on("click",function(){
			$(this).addClass("active")
			.parent().siblings().find("a").removeClass("active")
			.end()
			.parents(".has-sub-menu").siblings().find(".sub-menu a").removeClass("active");
		});
	});
</script>
</body>
</html>
