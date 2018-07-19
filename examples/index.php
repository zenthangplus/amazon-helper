<?php

use ZenThangPlus\AmazonHelper\Crawler;
use ZenThangPlus\AmazonHelper\ProductParser;
use ZenThangPlus\AmazonHelper\Product;
use ZenThangPlus\AmazonHelper\Order;
use ZenThangPlus\AmazonHelper\Exceptions\CrawlerException;
use ZenThangPlus\AmazonHelper\Exceptions\ParserException;

require_once '../vendor/autoload.php';

try {
    $order = new Order();

    $response = Crawler::init()->start( 'https://www.amazon.com/Anker-Portable-Reader-RS-MMC-Micro/dp/B006T9B6R2/' );
    $parser   = new ProductParser( $response );
    $product1 = new Product();
    $product1->set_url($response->get_url());
    $product1->set_title( $parser->title() );
    $product1->set_price( $parser->price() );
    $product1->set_weight( $parser->weight() );
    $product1->set_width( $parser->width() );
    $product1->set_height( $parser->height() );
    $product1->set_depth( $parser->depth() );
    $product1->set_weight_coefficient( 11 );
    $product1->set_dimension_coefficient( 5 );
    $order->add_product( $product1 );

    $response = Crawler::init()->start( 'https://www.amazon.com/LENRUE-Portable-Bluetooth-Handsfree-Smartphone/dp/B071WYX6HF' );
    $parser   = new ProductParser( $response );
    $product2 = new Product();
    $product2->set_url($response->get_url());
    $product2->set_title( $parser->title() );
    $product2->set_price( $parser->price() );
    $product2->set_weight( $parser->weight() );
    $product2->set_width( $parser->width() );
    $product2->set_height( $parser->height() );
    $product2->set_depth( $parser->depth() );
    $product2->set_weight_coefficient( 11 );
    $product2->set_dimension_coefficient( 5 );
    $order->add_product( $product2 );

    ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Weight (kg)</th>
            <th>Width (m)</th>
            <th>Height (m)</th>
            <th>Depth (m)</th>
            <th>Weight coefficient ($/kg)</th>
            <th>Dimension coefficient ($/m3)</th>
            <th>Price</th>
            <th>Shipping fee</th>
            <th>Final price</th>
            <th>View</th>
        </tr>
        <?php $products_list = $order->products(); foreach ($products_list as $id => $item): ?>
            <tr>
                <td><?php echo $id+1 ?></td>
                <td><?php echo $item->title() ?></td>
                <td><?php echo $item->weight() ?></td>
                <td><?php echo $item->width() ?></td>
                <td><?php echo $item->height() ?></td>
                <td><?php echo $item->depth() ?></td>
                <td><?php echo $item->get_weight_coefficient() ?></td>
                <td><?php echo $item->get_dimension_coefficient() ?></td>
                <td>$<?php echo $item->price() ?></td>
                <td>$<?php echo $item->shipping_fee() ?></td>
                <td>$<?php echo $item->final_price() ?></td>
                <td><a href="<?php echo $item->url() ?>" target="_blank">View on Amazon</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-right">
        <button class="btn btn-default">Total: $<?php echo $order->gross_price() ?></button>
    </div>
    <?php
} catch ( CrawlerException $ex ) {
    echo 'Error when crawl data: ' . $ex->getMessage();
} catch ( ParserException $ex ) {
    echo 'Error when parse data: ' . $ex->getMessage();
}

