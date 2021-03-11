<div class="row align-items-center mb-4 middle-header">
    <div class="col-md-5 mb-4 mb-md-0">
        <span class="h2 mb-0 text-white d-block">Hello, <?php echo ucwords($user['first_name'].' '.$user['last_name']); ?></span>
        <span class="h6 text-white">ID: <?php echo ucwords($user['uniqueid']); ?></span>
        <?php /* if($user['type'] == CUSTOMER) {?>
        <span class="text-white"><a onclick="return addseller(<?php echo $user['id'] ?>)" class="d-sm-block h5 text-white font-weight-bold" href='JavaScript:Void(0);'>Become a Reseller</a></span>
        <?php } */?>
    </div>
    <?php if($user['type'] != CUSTOMER) { ?>
    <div class="col-auto flex-fill d-none d-xl-block">
        <ul class="list-inline row justify-content-lg-end mb-0">
        <li class="list-inline-item col-sm-4 col-md-auto px-3 my-2 mx-0">
            <span class="badge badge-dot text-white">
                <i class="bg-success"></i>Products
            </span>
            <a class="d-sm-block h5 text-white font-weight-bold pl-2" href="javascript:void(0)">
            <!-- 20.5% -->
            <span class="product-rate">0</span>
            <small class="fas fa-angle-up text-success"></small>
            </a>
        </li>
        <li class="list-inline-item col-sm-4 col-md-auto px-3 my-2 mx-0">
            <span class="badge badge-dot text-white">
            <i class="bg-warning"></i>Sales
            </span>
            <a class="d-sm-block h5 text-white font-weight-bold pl-2" href="javascript:void(0)">
            <!-- 5.7% -->
            <span class="sale-rate">0</span>
            <small class="fas fa-angle-up text-success"></small>
            </a>
        </li>
        <li class="list-inline-item col-sm-4 col-md-auto px-3 my-2 mx-0">
            <span class="badge badge-dot text-white">
            <i class="bg-danger"></i>Followers
            </span>
            <a class="d-sm-block h5 text-white font-weight-bold pl-2" href="javascript:void(0)">
            <!-- -3.24% -->
            <span class="follow-rate">0</span>
            <small class="fas fa-angle-up text-success"></small>
            <!-- <small class="fas fa-angle-down text-danger"></small> -->
            <!-- <small class="fas fa-angle-up text-warning"></small> -->
            </a>
        </li>
        </ul>
    </div>
    <?php } ?>
</div>