<?php

/*
Plugin Name: BM_Woo_Related_Product
Plugin URI: https://breezemarketing.co.nz
Description: Woocommerce Product Related Center
Version: 1.0
Author URI: https://breezemarketing.co.nz
Author: Andre Campos
Text Domain: bm-woo-product-related-center
*/ 


add_shortcode('bm_woo_prc', 'bm_woo_product_related_center_shortcode'); 
function bm_woo_product_related_center_shortcode() {

    // Get Upsells Product ID:
    global $woocommerce;
    $id = get_the_ID();
    $product = new WC_Product($id);
    $upsells = $product->get_upsells();
    $contarproduct = count($upsells);
    if (!$contarproduct){
        $contarproduct = 0;
    }else{
        if($contarproduct == 4 || $contarproduct == 2){
            $contarproduct = 4;
        }
        if($contarproduct == 3 || $contarproduct == 1){
            $contarproduct = 3;
        }
    }
    //echo $upsells;
    //print_r($upsells);
    //if ( sizeof( $upsells ) == 0 ) return;
    // foreach($upsells as $item){
   
    //     $product = wc_get_product( $item );
    //     //print_r($product);
    //     echo "<br><br>";
    //     echo $product->slug;
    //     echo $product->stock_status;
    //     echo $product->price;
    //     //print_r($product->data);
    //     //echo $product->id;

    //     $slug = get_post_field('post_name', $product->id);
    //     $title = get_post_field('post_title', $product->id);
    //     $image = wp_get_attachment_image_src( get_post_thumbnail_id( $item ), 'single-post-thumbnail' );
    //     $image = $image[0];
    //     $image2 = str_replace(".jpg", "-300x300.jpg", $image);
    // }
    //echo $upsells[0][post_status];

    // // Append each upsells to product in cart
    // foreach( $upsells as $upsell_id ) {
    //     $upsell_id = absint( $upsell_id );

    //     // Add upsell into cart and set upsell_of as extra key with parent product item id
    //     $woocommerce->cart->add_to_cart( $upsell_id, 1, '', '', array( 'upsell_of' => $cart_item_key ) );
    // }

    if ($contarproduct > 0){
        echo '
        <div style="margin-top:40px" class="elementor-element products-heading-show elementor-product-loop-item--align-center elementor-grid-'.$contarproduct.' elementor-grid-tablet-3 elementor-grid-mobile-2 elementor-products-grid elementor-wc-products elementor-widget elementor-widget-woocommerce-products" data-id="f296f0b" data-element_type="widget" id="relatedproduct" data-widget_type="woocommerce-products.default">
            <div class="elementor-widget-container">	
                <section class="up-sells upsells products">
                    <h2 style="font-size:30px;text-align:center;color:#0b4513">Related Products</h2>
                    <ul class="products elementor-grid elementor-grid columns-4">';

                        if(count($upsells) == 2 || count($upsells) == 1){
                            echo"<li></li>";
                        }

                        foreach($upsells as $item){
        
                            $product = wc_get_product( $item );
                            //print_r($product);
                            //echo "<br><br>";
                            //echo $product->slug;
                            //echo $product->stock_status;
                            //echo "price " . $product->price;
                            //echo "price Regular " . $product->regular_price;
                            //echo "price Sale " . $product->sale_price;
                            //print_r($product->data);
                            //echo $product->id;

                            
                    
                            $slug = get_post_field('post_name', $product->id);
                            $title = get_post_field('post_title', $product->id);
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $item ), 'single-post-thumbnail' );
                            $image = $image[0];
                            $pieces = explode(".", $image);
                            $piecestotal = count($pieces) - 1;
                            $imagetype = "." . $pieces[$piecestotal];
                            $imagefinal = "-300x300.".$pieces[$piecestotal];
                            $image2 = str_replace($imagetype, $imagefinal, $image);

                            

                            echo"<li style='text-align:center;background-color:#F8F8F8;padding-bottom:10px;' class='product type-product post-$product->id status-publish $product->stock_status product_cat-fabrication-processing has-post-thumbnail shipping-taxable product-type-simple'>";
                                echo"<a href='https://breeze.marketing/cebelio/product/$product->slug' class='woocommerce-LoopProduct-link woocommerce-loop-product__link'>";
                                    echo"<img width='300' height='300' src='$image2' class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail' alt='' loading='lazy'>";
                                    echo"<h2 style='color:#0b4513' class='woocommerce-loop-product__title'>$title</h2>";
                                echo"</a>";
                                if($product->price){
                                    echo"<span class='price'>";
                                    if($product->regular_price != $product->price){
                                        echo"<del aria-hidden='true'><span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span>$product->regular_price</span></del>";
                                    }
                                    echo"<ins><span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span>$product->price</span></ins></span>";  
                                    echo"<a style='background-color:#0b4513;color:white;margin-top:-2px;' href='?add-to-cart=$product->id' data-quantity='1' class='button product_type_simple add_to_cart_button ajax_add_to_cart' data-product_id='$product->id' data-product_sku='' aria-label='Read more about “$title”' rel='nofollow'>Add to cart</a>";
                                }else{
                                    echo"<a style='background-color:#0b4513;color:white' href='https://breeze.marketing/cebelio/product/$product->slug' data-quantity='1' class='button product_type_simple' data-product_id='$product->id' data-product_sku='' aria-label='Read more about “$title”' rel='nofollow'>Read more</a>";
                                }          
                            echo"</li>";

                        }
                        echo'
                    </ul>
                </section>
            </div>
        </div>
        ';
    }
}


function myplugin_add_meta_box_application() {

    $screens = array( 'post', 'page' );
    
    foreach ( $screens as $screen ) {
    
        add_meta_box('metabpx_application','Applications','wk_custom_tab_data_application',$screen);
    }
} 
add_action( 'add_meta_boxes', 'myplugin_add_meta_box_application', 1);


add_filter( 'woocommerce_product_data_tabs', 'wk_custom_product_tab_application', 10, 1 );
function wk_custom_product_tab_application( $default_tabs ) {
    $default_tabs['custom_tab_application'] = array(
        'label'   =>  __( 'Application', 'domain' ),
        'target'  =>  'wk_custom_tab_data_application',
        'priority' => 70,
        'class'   => array()
    );
    return $default_tabs;
}

add_action( 'woocommerce_product_data_panels', 'wk_custom_tab_data_application' );
function wk_custom_tab_data_application() {

    $plugin_url = plugin_dir_url( __FILE__ );

	wp_enqueue_script( 'jsapplication', $plugin_url . 'js/js.js' );

    $url = $plugin_url . 'bm-application-add.php';
    $urldelete = $plugin_url . 'bm-application-delete.php';
    $pid = $_GET['post'];

    global $wpdb;
    $all_product_data = $wpdb->get_results("SELECT ID FROM `" . $wpdb->prefix . "posts` where post_type='pruduct-application' and post_title = $pid");

    //echo count($all_product_data);

    echo '<div id="wk_custom_tab_data_application" class="panel woocommerce_options_panel">


    <div id="productgeral_application" style="padding-left: 15px;">


        <div class="wrap">

            <h3>Title*</h3>

    	</div>

    	<input type="text" name="applicationtitle" id="applicationtitle" class="regular-text"><br><br>

    	
        <div class="wrap">

            <h3>Imagem*</h3>

    	</div>

        <input type="text" name="image_url_application" id="image_url_application" class="regular-text">

        <input type="button" style="width:150px;" name="upload-btn" id="upload-btn-application" class="button-secondary" value="Upload Image"><br><br>

        <div class="wrap">

            <div id="bm-application-button" onclick="buttonsaveapplication2(\''.$url.'\', \''.$pid.'\')" style="cursor: pointer;width:80px;height:25px;size:16px;background-color: #428bca;color:white;text-align:center;padding-top:5px">Save</div>

            <div id="applicationerror" style="color:red;size:16px;padding-top:5px"></div>

        </div>';

        if (count($all_product_data) > 0){
            echo '<div style="margin-top:20px;margin-bottom:-20px;" class="wrap">';
                echo '<h3>Application List</h3>';
            echo '</div>';
            
            foreach($all_product_data as $applicationss) {
                $newid =  $applicationss->ID;
                $divid = "p" . $newid;
                $url_value = get_post_meta( $newid, 'application_url', true );
                $title_value = get_post_meta( $newid, 'application_title', true );
                echo "<div id='$divid' style='margin-top:20px;width:100%;display:inline-block;min-width: 100% !important;'>";
                    echo '<div onclick="buttondeleteapplication(\''.$urldelete.'\', \''.$newid.'\')" style="cursor: pointer;float:left;width:80px;height:25px;size:16px;background-color:#aa3210;color:white;text-align:center;padding-top:5px;margin-right:10px">Delete</div>';
                    echo "<div style='float:left;padding-top:5px;size:45px;font-weight:bold;'>$title_value</div>";
                echo '</div>';
            }

        }
    echo '

    </div>
    <div style="height:65px;"></div>
    <script type="text/javascript">

    jQuery(document).ready(function($){

        $("#upload-btn-application").click(function(e) {

            e.preventDefault();

            var image = wp.media({ 

                title: "Upload Application",

                multiple: false

            }).open()

            .on("select", function(e){

                var uploaded_image = image.state().get("selection").first();

                console.log(uploaded_image);

                var image_url = uploaded_image.toJSON().url;

                $("#image_url_application").val(image_url);

            });

        });

    });
    </script>
   </div>';
}

add_shortcode('bm_woo_aplications', 'bm_woo_product_aplication_shortcode'); 
function bm_woo_product_aplication_shortcode() {
    ob_start();
    // Get Upsells Product ID:
    global $woocommerce;
    $id = get_the_ID();
    $upload_dir   = wp_upload_dir();

    global $wpdb;
    $all_product_data = $wpdb->get_results("SELECT ID FROM `" . $wpdb->prefix . "posts` where post_type='pruduct-application' and post_title = $id");

    $contarproduct = count($all_product_data);
    if (!$contarproduct){
        $contarproduct = 0;
    }else{
        if($contarproduct >= 4 || $contarproduct == 2){
            $setcontarproduct = 4;
        }
        if($contarproduct == 3 || $contarproduct == 1){
            $setcontarproduct = 3;
        }
    }

    if ($contarproduct > 0 && $contarproduct < 4){
        if ($contarproduct == 1 ){$divx = "280px";}
        if ($contarproduct == 2 ){$divx = "570px";}
        if ($contarproduct == 3 ){$divx = "860px";}
        echo '
        <div style="width:100%;display:inline-block;text-align:center;">
        <div style="max-width:'.$divx.';display:inline-block;text-align:center;">
        <div class="elementor-element products-heading-show elementor-product-loop-item--align-center elementor-grid-4 elementor-grid-tablet-2 elementor-grid-mobile-1 elementor-products-grid elementor-wc-products elementor-widget elementor-widget-woocommerce-products" data-id="f296f0b" data-element_type="widget" id="relatedproduct" data-widget_type="woocommerce-products.default">
            <div class="elementor-widget-container">	
                <section class="up-sells upsells products">
                    <h2 style="font-size:30px;text-align:center;color:#0b4513">Applications</h2>';
                        echo'
                        <ul class="products elementor-grid elementor-grid columns-4">';

                            // if(count($all_product_data) == 2 || count($all_product_data) == 1){
                            //     echo"<li style='visibility:hidden'></li>";
                            // }
                            $contar = 0;
                            foreach($all_product_data as $item){
                                $contar++;
                                $newid =  $item->ID;
                                $url_value = get_post_meta( $newid, 'application_url', true );
                                $title_value = get_post_meta( $newid, 'application_title', true );
                                $upload_dir2 = $upload_dir['baseurl'] . "/" . $url_value ;

                        
                                if (str_contains($upload_dir2, '-scaled')) { 
                                    $upload_dir2 = str_replace('-scaled', '', $upload_dir2);
                                }
                                $pieces = explode(".", $upload_dir2);
                                $piecestotal = count($pieces) - 1;
                                $imagetype = "." . $pieces[$piecestotal];
                                $imagefinal = "-300x300.".$pieces[$piecestotal];
                                $image2 = str_replace($imagetype, $imagefinal, $upload_dir2);

                                if ($contar == 1){
                                    echo"<li style='max-width:270px;text-align:center;background-color:white;padding-bottom:10px;margin-left:-20px;margin-right:20px' class='product type-product post-$product->id status-publish $product->stock_status product_cat-fabrication-processing has-post-thumbnail shipping-taxable product-type-simple'>";
                                            echo"<img width='100%' height='300px' src='$image2' class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail' alt='' loading='lazy'>";
                                            echo"<div style='width:270px;display:inline-block;'><div style='text-align:center;width:270px;min-height:50px;background-color:white;padding-top:5px;margin-top:-6px;color:#0b4513;font-size:22px'>$title_value</div></div>";
                                    echo"</li>";
                                }else{
                                    echo"<li style='max-width:270px;text-align:center;background-color:white;padding-bottom:10px;margin-left:-20px;margin-right:20px' class='product type-product post-$product->id status-publish $product->stock_status product_cat-fabrication-processing has-post-thumbnail shipping-taxable product-type-simple'>";
                                        echo"<img width='100%' height='300px' src='$image2' class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail' alt='' loading='lazy'>";
                                        echo"<div style='width:270px;display:inline-block;'><div style='text-align:center;width:270px;min-height:50px;background-color:white;padding-top:5px;margin-top:-6px;color:#0b4513;font-size:22px'>$title_value</div></div>";
                                    echo"</li>";
                                }
                            }
                            echo'
                        </ul>';
                    

                echo'
                </section>
            </div>
        </div>
        </div>
        </div>
        ';
    }
    if ($contarproduct > 3){
        echo "

        <section style='margin-top:40px;padding-top:20px;padding-left:5px;padding-right:5px;padding-bottom:20px;background-color:#dae0e7' class='elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default elementor-section-height-default' data-id='' data-element_type='section'>
            <h2 style='font-size:30px;text-align:center;color:#0b4513'>Applications</h2>
            <div class='elementor-container elementor-column-gap-default'>
                <div class='elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-d1daabe' data-id='d1daabe' data-element_type='column'>
                    <div class='elementor-widget-wrap elementor-element-populated e-swiper-container'>
                        <div class='elementor-element elementor-arrows-position-inside elementor-pagination-position-outside elementor-widget elementor-widget-image-carousel e-widget-swiper' data-id='' data-element_type='widget' data-settings='{&quot;slides_to_show&quot;:&quot;4&quot;,&quot;slides_to_scroll&quot;:&quot;1&quot;,&quot;navigation&quot;:&quot;both&quot;,&quot;autoplay&quot;:&quot;yes&quot;,&quot;pause_on_hover&quot;:&quot;yes&quot;,&quot;pause_on_interaction&quot;:&quot;yes&quot;,&quot;autoplay_speed&quot;:5000,&quot;infinite&quot;:&quot;yes&quot;,&quot;speed&quot;:500}' data-widget_type='image-carousel.default'>
                            <div class='elementor-widget-container'>
                                <style>
                                    .elementor-widget-image-carousel .swiper-container{position:static}.elementor-widget-image-carousel .swiper-container .swiper-slide figure{line-height:inherit}.elementor-widget-image-carousel .swiper-slide{text-align:center}.elementor-image-carousel-wrapper:not(.swiper-container-initialized) .swiper-slide{max-width:calc(100% / var(--e-image-carousel-slides-to-show, 3))}
                                </style>		
                                <div class='elementor-image-carousel-wrapper swiper-container swiper-container-initialized swiper-container-horizontal' dir='ltr'>
                                    <div class='elementor-image-carousel swiper-wrapper' style='transform: translate3d(-1960px, 0px, 0px); transition-duration: 0ms;'>";
                                    

 
                                        //$contarproductindex = $contarproduct - 1;
                                        for ($i = $contarproduct - 4; $i <= $contarproduct - 2; $i++) {
                                            $array = getimageurl($all_product_data[$i]->ID);
                                            echo " <div class='swiper-slide swiper-slide-duplicate' data-swiper-slide-index='$i' style='width: 280px;'>
                                                <figure class='swiper-slide-inner'>
                                                    <img class='swiper-slide-image' width='200px' src='$array[1]' alt='$array[0]'>
                                                </figure>
                                            </div>";
                                        }
                                        $array = getimageurl($all_product_data[$contarproduct - 1]->ID);
                                        $newindex = $contarproduct - 1;
                                        echo " <div class='swiper-slide swiper-slide-duplicate swiper-slide-prev' data-swiper-slide-index='$newindex' style='width: 280px;'>
                                            <figure class='swiper-slide-inner'>
                                                <img class='swiper-slide-image' width='200px' src='$array[1]' alt='$array[0]'>
                                            </figure>
                                        </div>";


                                        //------------
                                     

                                        $array = getimageurl($all_product_data[0]->ID);
                                        echo"<div class='swiper-slide swiper-slide-active' data-swiper-slide-index='0' style='width: 280px;'>
                                            <figure class='swiper-slide-inner'>
                                                <img class='swiper-slide-image' style='object-fit:cover;' width='270px' height='320px' src='$array[1]' alt='$array[0]'>
                                                <div style='width:270px;display:inline-block;'><div style='text-align:center;width:270px;min-height:50px;background-color:white;padding-top:5px;margin-top:-6px;color:#0b4513;font-size:22px'>$array[0]</div></div>
                                            </figure>
                                        </div>";

                                        $array = getimageurl($all_product_data[1]->ID);
                                        echo"<div class='swiper-slide swiper-slide-next' data-swiper-slide-index='1' style='width: 280px;'>
                                            <figure class='swiper-slide-inner'>
                                                <img class='swiper-slide-image' style='object-fit:cover;' width='270px' height='320px' src='$array[1]' alt='$array[0]'>
                                                <div style='width:270px;display:inline-block;'><div style='text-align:center;width:270px;min-height:50px;background-color:white;padding-top:5px;margin-top:-6px;color:#0b4513;font-size:22px'>$array[0]</div></div>
                                            </figure>
                                        </div>";

                                        for ($i = 2; $i <= $contarproduct - 2; $i++) {
                                            $array = getimageurl($all_product_data[$i]->ID);
                                            echo "<div class='swiper-slide' data-swiper-slide-index='$i' style='width: 280px;'>
                                                <figure class='swiper-slide-inner'>
                                                    <img class='swiper-slide-image' style='object-fit:cover;' width='270px' height='320px' src='$array[1]' alt='$array[0]'>
                                                    <div style='width:270px;display:inline-block;'><div style='text-align:center;width:270px;min-height:50px;background-color:white;padding-top:5px;margin-top:-6px;color:#0b4513;font-size:22px'>$array[0]</div></div>
                                                </figure>
                                            </div>";
                                        }

                                        $array = getimageurl($all_product_data[$contarproduct - 1]->ID);
                                        $newindex = $contarproduct - 1;
                                        echo " <div class='swiper-slide swiper-slide-duplicate-prev' data-swiper-slide-index='$newindex' style='width: 280px;'>
                                            <figure class='swiper-slide-inner'>
                                                <img class='swiper-slide-image' width='270px' height='320px' src='$array[1]' alt='$array[0]'>
                                                <div style='width:270px;display:inline-block;'><div style='text-align:center;width:270px;min-height:50px;background-color:white;padding-top:5px;margin-top:-6px;color:#0b4513;font-size:22px'>$array[0]</div></div>
                                            </figure>
                                        </div>";


                                        //------------


                                        $array = getimageurl($all_product_data[0]->ID);
                                        echo " <div class='sswiper-slide swiper-slide-duplicate swiper-slide-duplicate-active' data-swiper-slide-index='0' style='width: 280px;'>
                                            <figure class='swiper-slide-inner'>
                                                <img class='swiper-slide-image' width='200px' src='$array[1]' alt='$array[0]'>
                                            </figure>
                                        </div>";

                                        $array = getimageurl($all_product_data[1]->ID);
                                        echo " <div class='swiper-slide swiper-slide-duplicate swiper-slide-duplicate-next' data-swiper-slide-index='1' style='width: 280px;'>
                                            <figure class='swiper-slide-inner'>
                                                <img class='swiper-slide-image' width='200px' src='$array[1]' alt='$array[0]'>
                                            </figure>
                                        </div>";

                                        $array = getimageurl($all_product_data[2]->ID);
                                        echo " <div class='swiper-slide swiper-slide-duplicate' data-swiper-slide-index='2' style='width: 280px;'>
                                            <figure class='swiper-slide-inner'>
                                                <img class='swiper-slide-image' width='200px' src='$array[1]' alt='$array[0]'>
                                            </figure>
                                        </div>";

                                        $array = getimageurl($all_product_data[3]->ID);
                                        echo " <div class='swiper-slide swiper-slide-duplicate' data-swiper-slide-index='3' style='width: 280px;'>
                                            <figure class='swiper-slide-inner'>
                                                <img class='swiper-slide-image' width='200px' src='$array[1]' alt='$array[0]'>
                                            </figure>
                                        </div>";

                                    echo"
                                    </div>
                                    <div class='swiper-pagination swiper-pagination-clickable swiper-pagination-bullets'>
                                    <span class='swiper-pagination-bullet swiper-pagination-bullet-active' tabindex='0' role='button' aria-label='Go to slide 2'></span>";
                                    for ($i = 2; $i <= $contarproduct - 1; $i++) {
                                        echo"<span class='swiper-pagination-bullet' tabindex='0' role='button' aria-label='Go to slide $i'></span>";
                                    }
                                    echo"
                                    </div>
                                    <div class='elementor-swiper-button elementor-swiper-button-prev' tabindex='0' role='button' aria-label='Previous slide'>
                                        <i aria-hidden='true' class='eicon-chevron-left' style='background-color:green;width:40px;height:45px;padding-left:5px;padding-top:10px;margin-left:-25px'></i>						
                                        <span class='elementor-screen-only'>Previous</span>
                                    </div>
                                    <div class='elementor-swiper-button elementor-swiper-button-next' tabindex='0' role='button' aria-label='Next slide'>
                                        <i aria-hidden='true' class='eicon-chevron-right' style='background-color:green;width:40px;height:45px;padding-left:10px;padding-top:10px;margin-right:-25px'></i>
                                        <span class='elementor-screen-only'>Next</span>
                                    </div>
                                    <span class='swiper-notification' aria-live='assertive' aria-atomic='true'></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        ";
    }
    if ($contarproduct == 0){
        echo'
            <script type="text/javascript">
                document.getElementById("aplicationdiv").style.display = "none";
            </script>
        ';
    }


    return ob_get_clean();
}


function getimageurl($newid)
{
    global $woocommerce;
    $id = get_the_ID();
    $upload_dir   = wp_upload_dir();
    global $wpdb;
    
    $url_value = get_post_meta( $newid, 'application_url', true );
    $title_value = get_post_meta( $newid, 'application_title', true );
    $upload_dir2 = $upload_dir['baseurl'] . "/" . $url_value ;


    if (str_contains($upload_dir2, '-scaled')) { 
        $upload_dir2 = str_replace('-scaled', '', $upload_dir2);
    }
    $pieces = explode(".", $upload_dir2);
    $piecestotal = count($pieces) - 1;
    $imagetype = "." . $pieces[$piecestotal];
    $imagefinal = "-300x300.".$pieces[$piecestotal];
    $image2 = str_replace($imagetype, $imagefinal, $upload_dir2);
    return array($title_value,$image2);
}






//#######################################################################################################


function myplugin_add_meta_box_related_product() {

    $screens = array( 'post', 'page' );
    
    foreach ( $screens as $screen ) {
    
        add_meta_box('metabpx_related_product','Related Product','wk_custom_tab_data_related_product',$screen);
    }
} 
add_action( 'add_meta_boxes', 'myplugin_add_meta_box_related_product', 1);


add_filter( 'woocommerce_product_data_tabs', 'wk_custom_tab_data_related_product2', 10, 1 );
function wk_custom_tab_data_related_product2( $default_tabs ) {

    $default_tabs['custom_tab_related_product2'] = array(

        'label'   =>  __( 'Related Product', 'domain' ),

        'target'  =>  'wk_custom_tab_data_related_product',

        'priority' => 70,

        'class'   => array()

    );

    return $default_tabs;
}



add_action( 'woocommerce_product_data_panels', 'wk_custom_tab_data_related_product' );
function wk_custom_tab_data_related_product() {

    $plugin_url = plugin_dir_url( __FILE__ );

	wp_enqueue_script( 'jsrelatedproduct', $plugin_url . 'js/js.js' );

    $url = $plugin_url . 'bm-releted-product-add.php';
    $urldelete = $plugin_url . 'bm-releted-product-delete.php';
    $pid = $_GET['post'];

    global $wpdb;
    $all_product_data2 = $wpdb->get_results("SELECT ID FROM `" . $wpdb->prefix . "posts` where post_type='pruduct-relatedp' and post_title = $pid");
    $all_product2 = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "posts` where post_type='product'");

    //echo count($all_product_data);
    
    
    echo '<div id="wk_custom_tab_data_related_product" class="panel woocommerce_options_panel">


    <div id="productgeral_related_product" style="padding-left: 15px;">


    <div class="wrap">

        <h3>Product*</h3>

    </div>

    <div id="relatedproducterror" style="color:red;size:16px;padding-top:5px;"></div>
    <div Style="display: inline-block;">
        <div style="float:left;width:320px"><input type="text" name="relatedproducttitle" id="relatedproducttitle" onkeyup="cchangeFunction()" onkeydown="cchangeFunction()" class="regular-text" style="width:320px;"></div>
        <div id="bm-relatedproduct-button" style="float:left;cursor:pointer;width:80px;height:25px;size:16px;background-color:#428bca;color:white;text-align:center;padding-top:5px;margin-top:7px">Find</div>
    </div>
    <div style="width:400px;min-height:25px;margin-top:-15px">';
        foreach($all_product2 as $aapplicationss) {
            echo"<div onclick='cchangeFunction2(\"$url\", \"$urldelete\", $pid, $aapplicationss->ID, \"$aapplicationss->post_title\")' style='display:none;cursor:pointer;padding-top:5px;padding-bottom:5px;font-size:16px;padding-left:10px;width:100%;border-bottom: 1px solid gray;' class='productsearch'>$aapplicationss->post_title</div>";
        }
    echo '</div>';

    

    if (count($all_product_data2) > 0){

        echo '<div id="titlerelatedtext" style="margin-top:20px;margin-bottom:-20px;display:block" class="wrap">';
                echo '<h3>Related Product List</h3>';
        echo '</div>';

        foreach($all_product_data2 as $applicationsss) {
            $newid =  $applicationsss->ID;
            $divid = "p" . $newid;
            $title_value = get_post_meta( $newid, 'related_product_title', true );
            echo "<div id='$divid' style='margin-top:20px;width:100%;display:inline-block;min-width: 100% !important;'>";
                echo '<div onclick="buttondeleterelatedproduct(\''.$urldelete.'\', \''.$newid.'\')" style="cursor: pointer;float:left;width:80px;height:25px;size:16px;background-color:#aa3210;color:white;text-align:center;padding-top:5px;margin-right:10px">Delete</div>';
                echo "<div style='float:left;padding-top:5px;size:45px;font-weight:bold;'>$title_value</div>";
            echo '</div>';
        }

    }else{
        echo '<div id="titlerelatedtext" style="margin-top:20px;margin-bottom:-20px;display:none" class="wrap">';
                echo '<h3>Related Product List</h3>';
        echo '</div>';
    }
    echo '</div></div>';

}


add_shortcode('bm_related_product', 'bm_related_product_shortcode'); 
function bm_related_product_shortcode() {
    ob_start();
    // Get Upsells Product ID:
    global $woocommerce;
    $id = get_the_ID();
    $upload_dir   = wp_upload_dir();
    
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'cssrelated', $plugin_url . 'css/css.css' );

    global $wpdb;
    $all_product_data = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "posts` where post_type='pruduct-relatedp' and post_title = $id");
    $contar = 0;
    echo "<div class='relatedboxx'>";
    foreach($all_product_data as $item){

        $productid = $item->ID;
        $productpostid = get_post_meta( $productid, 'related_product_ppostid', true );
        $producttitle = get_post_meta( $productid, 'related_product_title', true );
        $productsubtitle = get_post_meta( $productid, 'related_product_subtitle', true );
        $producturlid = get_post_meta( $productpostid, '_thumbnail_id', true );
        $producturl = get_post_meta( $producturlid, '_wp_attached_file', true );

        $productimage = $upload_dir['baseurl'] . "/" . $producturl;

        $all_product_data2 = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "posts` where post_type='product' and ID = $productpostid");
        $productlink2 = str_replace("/wp-content/uploads", "", $upload_dir['baseurl']);
        $productlink = $productlink2 . "/product/" . $all_product_data2[0]->post_name ;
        //echo $upload_dir['baseurl'];
        

        // $terms = get_the_terms( $post->ID, 'product_cat' );
        // foreach ($terms as $term) {
        //     $product_cat_id = $term->term_id;
        //     break;
        // }
        // echo $product_cat_id;


        echo "<div class='relatedbox'>";
            
            
            echo "<a href='$productlink'>";
                echo "<div class='relatedboximage' style='background-image: url(\"$productimage\");background-size: cover;'>";
                echo "</div>";
            echo "</a>";

            echo "<a href='$productlink'>";
                echo "<div class='relatedboxdescription'>";
                    echo "<div>$producttitle</div>	";	
                    echo "<div>$productsubtitle</div>	";	
                echo "</div>";
            echo "</a>";

        echo "</div>";

    }           
    echo "</div>";
    
    if (count($all_product_data) == 0){
        echo'
            <script type="text/javascript">
                document.getElementById("relatedproductdiv").style.display = "none";
            </script>
        ';
    }


    return ob_get_clean();
}


?>