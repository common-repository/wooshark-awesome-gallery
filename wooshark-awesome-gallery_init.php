<?php
/*
    "WordPress Plugin Template" Copyright (C) 2020 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

function WoosharkAwesomeGallery_init($file)
{

    require_once('WoosharkAwesomeGallery_Plugin.php');
    $aPlugin = new WoosharkAwesomeGallery_Plugin();

    // Install the plugin
    // NOTE: this file gets run each time you *activate* the plugin.
    // So in WP when you "install" the plugin, all that does it dump its files in the plugin-templates directory
    // but it does not call any of its code.
    // So here, the plugin tracks whether or not it has run its install operation, and we ensure it is run only once
    // on the first activation
    if (!$aPlugin->isInstalled()) {
        $aPlugin->install();
    } else {
        // Perform any version-upgrade activities prior to activation (e.g. database changes)
        $aPlugin->upgrade();
    }

    // Add callbacks to hooks
    $aPlugin->addActionsAndFilters();

    if (!$file) {
        $file = __FILE__;
    }
    // Register the Plugin Activation Hook
    register_activation_hook($file, array(&$aPlugin, 'activate'));


    // Register the Plugin Deactivation Hook
    register_deactivation_hook($file, array(&$aPlugin, 'deactivate'));
}



function wish_getProductsCount()
{
  $argsProductsCount = array('post_type' => 'product', 'meta_query' => array(array('key' => 'productUrl', 'value' => '.wish.', 'compare' => 'LIKE',)));
  $query = new WP_Query($argsProductsCount);
  $total = $query->found_posts;
  wp_reset_postdata();
  wp_send_json($total);
}
add_action('wp_ajax_wish_getProductsCount', 'wish_getProductsCount');
add_action('wp_ajax_nopriv_wish_getProductsCount', 'wish_getProductsCount');


function wish_getProduct_FROMWP()
{
  $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : '';
  $args = array('post_type' => 'product', 'posts_per_page' => 20, 'paged' => $paged, 'meta_query' => array(array('key' => 'productUrl', 'value' => '.wish.', 'compare' => 'LIKE',)));
  $products = new WP_Query($args);
  $finalList = array();
  if ($products->have_posts()) {
    while ($products->have_posts()) : $products->the_post();
      $theid = get_the_ID();
      $product = new WC_Product($theid);
      if (has_post_thumbnail()) {
        $thumbnail = get_post_thumbnail_id();
        $image = $thumbnail ? wp_get_attachment_url($thumbnail) : '';
      }
      $finalList[] = array(sku => $product->get_sku(), id => $theid, image => $image, title => $product->get_title(), productUrl => get_post_meta($theid, 'productUrl', true));
    endwhile;
  } else {
    echo __('No products found');
  }
  wp_reset_postdata();
  wp_send_json($finalList);
}
function wish_insertProductInWoocommerce()
{
  $nonce = $_POST['nonce'];
  $nonce = $_POST['nonce'];
  if (isset($_POST)) {
    $sku = isset($_POST['sku']) ? sanitize_text_field($_POST['sku']) : '';
    $images = isset($_POST['images']) ? $_POST['images'] : array();
    $categories = isset($_POST['categories']) ? $_POST['categories'] : array();
    $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $productType = isset($_POST['productType']) ? sanitize_text_field($_POST['productType']) : 'simple';
    $regularPrice = isset($_POST['regularPrice']) ? sanitize_text_field($_POST['regularPrice']) : '0';
    $salePrice = isset($_POST['salePrice']) ? sanitize_text_field($_POST['salePrice']) : '0';
    $quantity = isset($_POST['quantity']) ? sanitize_text_field($_POST['quantity']) : '0';
    $postStatus = isset($_POST['postStatus']) ? sanitize_text_field($_POST['postStatus']) : 'draft';
    $variations = isset($_POST['variations']) ? $_POST['variations'] : array();
    $attributes = isset($_POST['attributes']) ? $_POST['attributes'] : array();
    $productUrl = isset($_POST['productUrl']) ? sanitize_text_field($_POST['productUrl']) : '';
    $shortDescription = isset($_POST['shortDescription']) ? sanitize_text_field($_POST['shortDescription']) : '';
    $importVariationImages = isset($_POST['importVariationImages']) ? sanitize_text_field($_POST['importVariationImages']) : '';
    $reviews = isset($_POST['reviews']) ? $_POST['reviews'] : array();
    $tags = isset($_POST['tags']) ? $_POST['tags'] : array();

    $allowed_html = array('a' => array('href' => array(),), 'img' => array(),);
    $sanitizedDEscription = html_entity_decode($description);
    if ($productType == 'simple') {
        // if (false) {
          $product = new WC_Product_Simple();
            if (isset($title)) {
              $product->set_name($title);
            }
            if (isset($description)) {
              $product->set_description($description);
            }
            if (isset($shortDescription)) {
              $product->set_short_description($shortDescription);
            }
    
            if (isset($sku)) {
              $product->set_sku($sku);
            }
    
            if (isset($postStatus)) {
              $product->set_status($postStatus);
            }
            if (isset($salePrice)) {
              $product->set_price($salePrice);
              $product->set_regular_price($salePrice);
            }
    
            if (isset($salePrice)) {
              $product->set_sale_price($salePrice);
            }
            
            if (isset($quantity)) {
              $product->set_stock_quantity($quantity);
              $product->set_stock_status('instock');
            }
    
            //   //categories
            if (is_array($categories) && count($categories)) {
              $product->set_category_ids($categories);
            }
            //images
            
    
            wish_save_product_images($product, $images);
    
            try {
              $post_id = $product->save();
            } catch (Exception $e) {
            //   $results = array(
            //     'error' => true,
            //     'error_msg' => 'Error received when trying to insert the product' . $e->getMessage(),
            //     'data' => ''
            //   );
            //   wp_send_json($results);

            $results = array('error' => true, 'error_msg' => 'Error received when trying to insert the product' . $e->getMessage(), 'data' => '');
            wp_send_json($results);

            }
    
            if (isset($productUrl)) {
              update_post_meta($post_id, 'productUrl', $productUrl);
            }
    
            if ( is_array( $tags ) && count( $tags ) ) {
                wp_set_object_terms( $post_id, $tags, 'product_tag' );
            }
            if ( is_array( $tags ) && count( $tags ) ) {
                wp_set_post_terms( $post_id, $tags, 'product_tag', true );
            }
            // wp_send_json(array('price' => $salePrice, 'quantity' => $quantity));

            $results = array(
              'error' => false,
              'error_msg' => '',
              'data' => 'Product inserted successfully'
            );
            wp_send_json($results);
    
    
         
    
    
         } else {
      try {
        $product = new WC_Product_Variable();
        if (isset($title)) {
          $product->set_name($title);
        }
        if (isset($description)) {
          $product->set_description($description);
        }
        if (isset($shortDescription)) {
          $product->set_short_description($shortDescription);
        }
        if (isset($sku)) {
          $product->set_sku($sku);
        }
        if (isset($postStatus)) {
          $product->set_status($postStatus);
        }
        if (is_array($categories) && count($categories)) {
          $product->set_category_ids($categories);
        }
        wish_save_product_images($product, $images);
        $attributeArray = array();
        if (is_array($attributes) && count($attributes)) {
          foreach ($attributes as $attributeValue) {
            $values = $attributeValue['values'];
            $attr_label = $attributeValue['name'];
            $isVariation = $attributeValue['variation'];
            $attribute = new WC_Product_Attribute();
            $attribute->set_name($attr_label);
            $attribute->set_options($values);
            $attribute->set_visible(1);
            if ($isVariation == true) {
              $attribute->set_variation(1);
            } else {
              $attribute->set_variation(0);
            }
            array_push($attributeArray, $attribute);
          }
          $product->set_attributes($attributeArray);
        } else {
          $results = array('error' => true, 'error_msg' => 'Missing attributes or variations, could not insert product ', 'data' => '');
          wp_send_json($results);
        }
      } catch (Exception $ex) {
        $results = array('error' => true, 'error_msg' => 'Error received when trying to insert the product' . $ex->getMessage(), 'data' => '');
        wp_send_json($results);
      }
      try {
        $post_id = $product->save();
      } catch (Exception $e) {
        $results = array('error' => true, 'error_msg' => 'Error received when trying to insert the product' . $ex->getMessage(), 'data' => '');
        wp_send_json($results);
      }
      if (isset($productUrl)) {
        update_post_meta($post_id, 'productUrl', $productUrl);
      }
      if (is_array($variations) && count($variations)) {
        foreach ($variations as $variation) {
          $attributesVariations = $variation['attributesVariations'];
          $variationToCreate = new WC_Product_Variation();
          $variationToCreate->set_parent_id($post_id);
          if (!empty($variation['SKU'])) {
            $variationToCreate->set_sku($variation['SKU']);
          }
          if (!empty(sanitize_text_field($variation['regularPrice']))) {
            $variationToCreate->set_regular_price($variation['regularPrice']);
          }
          if (!empty(sanitize_text_field($variation['salePrice']))) {
            $variationToCreate->set_sale_price($variation['salePrice']);
          }
          $stockProduct = sanitize_text_field($variation['availQuantity']);
          if (isset($stockProduct)) {
            $variationToCreate->set_stock_quantity($stockProduct);
          }
          $variationsArray = array();
          foreach ($attributesVariations as $attributesVariation) {
            $variationsArray[$attributesVariation['name']] = $attributesVariation['value'];
            $arrayImageId = array();
            if (isset($importVariationImages) && $importVariationImages == true) {
              $imageVariations = $attributesVariation['image'];
              $imageId = false;
              foreach ($arrayImageId as $imageObject) {
                if ($imageObject->imageVariations == $imageVariations) {
                  $imageId = $imageObject->id;
                  break;
                }
              }
              if ($imageId != false) {
                $variationToCreate->set_image_id($imageId);
              } else {
                $imageIdVariation = wish_upload_image($imageVariations);
                array_push($arrayImageId, array('image' => $imageVariations, 'id' => $imageIdVariation));
                if (isset($imageIdVariation)) {
                  $variationToCreate->set_image_id($imageIdVariation);
                }
              }
            }
          };
          $variationToCreate->set_attributes($variationsArray);
          try {
            $variationToCreate->save();
          } catch (Exception $e) {
            echo $e;
          }
        }
        if (isset($reviews) && count($reviews)) {
          foreach ($reviews as $review) {
            $comment_id = wp_insert_comment(array('comment_post_ID' => sanitize_text_field($post_id), 'comment_author' => sanitize_text_field($review['username']), 'comment_author_email' => sanitize_text_field($review['email']), 'comment_author_url' => '', 'comment_content' => sanitize_text_field($review['review']), 'comment_type' => '', 'comment_parent' => 0, 'user_id' => 5, 'comment_author_IP' => '', 'comment_agent' => '', 'comment_date' => date('Y-m-d H:i:s'), 'comment_approved' => 1,));
            update_comment_meta($comment_id, 'rating', sanitize_text_field($review['rating']));
          }
        }
      }
      $results = array('error' => false, 'error_msg' => '', 'data' => 'Product inserted successfully');
      wp_send_json($results);
    }
  }
}
add_action('wp_ajax_wish_wooshark-insert-product', 'wish_insertProductInWoocommerce');
add_action('wp_ajax_wish_nopriv_wooshark-insert-product', 'wish_insertProductInWoocommerce');
add_action('wp_ajax_wish_get_products', 'wish_getProduct_FROMWP');
add_action('wp_ajax_wish_nopriv_get_products', 'wish_getProduct_FROMWP');
function wish_searchProductBySku()
{
  $searchSkuValue = isset($_POST['searchSkuValue']) ? sanitize_text_field($_POST['searchSkuValue']) : '';
  if (isset($searchSkuValue)) {
    $args = array('post_type' => 'product', 'posts_per_page' => 1, 'meta_query' => array(array("key" => "_sku", "value" => $searchSkuValue, "compare" => "LIKE"), array('key' => 'productUrl', 'value' => '.wish.', 'compare' => 'LIKE',)));
    $products = new WP_Query($args);
    $finalList = array();
    if ($products->have_posts()) {
      while ($products->have_posts()) : $products->the_post();
        $theid = get_the_ID();
        $product = new WC_Product($theid);
        if (has_post_thumbnail()) {
          $thumbnail = get_post_thumbnail_id();
          $image = $thumbnail ? wp_get_attachment_url($thumbnail) : '';
        }
        $finalList[] = array(sku => $product->get_sku(), id => $theid, image => $image, title => $product->get_title(), productUrl => get_post_meta($theid, 'productUrl', true));
      endwhile;
    } else {
      echo __('No products found');
    }
    wp_reset_postdata();
    wp_send_json($finalList);
  } else {
    $results = array('error' => true, 'error_msg' => 'cannot find result for the introduced sku value, please make sure the product is imported using wooshark', 'data' => '');
    wp_send_json($results);
  }
}
add_action('wp_ajax_wish_search-product-by-sku', 'wish_searchProductBySku');
add_action('wp_ajax_nopriv_wish_search-product-by-sku', 'wish_searchProductBySku');
function wish_getAlreadyImportedProducts()
{
  $listOfSkus = isset($_POST['listOfSkus']) ? ($_POST['listOfSkus']) : array();
  if (isset($listOfSkus) && count($listOfSkus)) {
    $args = array('post_type' => 'product', 'posts_per_page' => 40, 'meta_query' => array(array("key" => "_sku", "value" => $listOfSkus, "compare" => "IN"), array('key' => 'productUrl', 'value' => '.wish.', 'compare' => 'LIKE',)));
    $products = new WP_Query($args);
    $finalList = array();
    if ($products->have_posts()) {
      while ($products->have_posts()) : $products->the_post();
        $theid = get_the_ID();
        $product = new WC_Product($theid);
        $finalList[] = array(sku => $product->get_sku(), id => $theid, title => $product->get_title(), productUrl => get_post_meta($theid, 'productUrl', true));
      endwhile;
    } else {
      echo __('No products found');
    }
    wp_reset_postdata();
    wp_send_json($finalList);
  }
}
add_action('wp_ajax_wish_get-already-imported-products', 'wish_getAlreadyImportedProducts');
add_action('wp_ajax_nopriv_wish_get-already-imported-products', 'wish_getAlreadyImportedProducts');
function wish_upload_image($imageurl)
{
  include_once(ABSPATH . 'wp-admin/includes/image.php');
  $imagetype = end(explode('/', getimagesize($imageurl)['mime']));
  $uniq_name = date('dmY') . '' . (int) microtime(true);
  $filename = $uniq_name . '.' . $imagetype;
  $uploaddir = wp_upload_dir();
  $uploadfile = $uploaddir['path'] . '/' . $filename;
  $contents = file_get_contents($imageurl);
  $savefile = fopen($uploadfile, 'w');
  fwrite($savefile, $contents);
  fclose($savefile);
  $wp_filetype = wp_check_filetype(basename($filename), null);
  $attachment = array('post_mime_type' => $wp_filetype['type'], 'post_title' => $filename, 'post_content' => '', 'post_status' => 'inherit');
  $attach_id = wp_insert_attachment($attachment, $uploadfile);
  return $attach_id;
}
function wish_save_product_images($product, $images)
{
  if (is_array($images)) {
    $gallery = array();
    foreach ($images as $key => $image) {
      if (isset($image)) {
        $upload = wc_rest_upload_image_from_url(esc_url_raw($image));
        if (is_wp_error($upload)) {
          if (!apply_filters('woocommerce_rest_suppress_image_upload_error', false, $upload, $product->get_id(), $images)) {
            throw new WC_REST_Exception('woocommerce_product_image_upload_error', $upload->get_error_message(), 400);
          } else {
            continue;
          }
        }
        $attachment_id = wc_rest_set_uploaded_image_as_attachment($upload, $product->get_id());
      }
      if ($key == 0) {
        $product->set_image_id($attachment_id);
      } else {
        array_push($gallery, $attachment_id);
      }
    }
    if (!empty($gallery)) {
      $product->set_gallery_image_ids($gallery);
    }
  } else {
    $product->set_image_id('');
    $product->set_gallery_image_ids(array());
  }
  return $product;
}
