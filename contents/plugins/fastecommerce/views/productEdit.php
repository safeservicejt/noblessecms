  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/chosen/bootstrap-chosen.css">
<script src="<?php echo System::getUrl(); ?>bootstrap/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/datepicker/css/datepicker.css">
  <script src="<?php echo ROOT_URL;?>bootstrap/datepicker/js/bootstrap-datepicker.js"></script>
  <script src="<?php echo ROOT_URL;?>contents/plugins/fastecommerce/js/jquery-sortable.js"></script>

<style type="text/css">
body.dragging, body.dragging * {
  cursor: move !important;
}

.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}

.cursor-pointer
{
  cursor: pointer;
}

ol.list-images
{
  list-style: none;
  padding:0px;
  margin: 0px;
  display: block;
  width: 100%;
}
ol.list-images li.placeholder {
  position: relative;
  /** More li styles **/
}
ol.list-images li.placeholder:before {
  position: absolute;
  /** Define arrowhead **/
}  
ol.list-images li
{
  display: inline-block;

  max-width: 30%;
}
ol.list-images li img
{
  max-width: 100%;
  height: auto;
}

</style>
<form action="" method="post" enctype="multipart/form-data">

<!-- row -->
<div class="row">
  <!-- left -->
  <div class="col-lg-8 col-md-8 col-sm-8 ">

    <!-- panel -->
    <div class="panel panel-default">
      <div class="panel-body">
        <?php echo $alert;?>
        <p>
            <label><strong>Title</strong> (<span class="system_count_char" data-target=".prod-title">0</span> characters)</label>
            <input type="text" class="form-control prod-title input-size-medium" name="send[title]" value="<?php echo $productData['title'] ;?>" placeholder="Title" />
        </p>

        <p>
            <label><strong>Content</strong></label>
            <textarea id="editor" rows="15" name="send[content]" class="form-control ckeditor"><?php echo $productData['content'] ;?></textarea>
        </p>

      </div>
    </div>
    <!-- panel -->


    <!-- panel -->    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Product Data</h3>
      </div>    
      <div class="panel-body">
        <div class="wrapper-tabs">
          <ul class="tab-link">
            <li><span class="tab-active" data-target="#tab-general">General</span></li>
            <li><span data-target="#tab-inventory">Inventory</span></li>
            <li><span data-target="#tab-shipping">Shipping</span></li>
            <li><span data-target="#tab-attributes">Attributes</span></li>
            <li><span data-target="#tab-advanced">Advanced</span></li>
            <li><span data-target="#tab-virtualdownload">Virtual Download</span></li>            
            <li><span data-target="#tab-seo">SEO</span></li>
          </ul>

          <div class="tabs-content">
            <!-- tab-general -->
            <div id="tab-general">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">SKU</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <input type="text" class="form-control input-sm" value="<?php echo $productData['sku'] ;?>" name="send[sku]" />
                    </td>
                  </tr>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Regular Price ($)</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <input type="text" class="form-control input-sm input-regular-price" name="send[price]" value="<?php echo $productData['price'] ;?>" />
                    </td>
                  </tr>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Sale Price</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <input type="text" class="form-control input-sm input-sale-price" name="send[sale_price]" value="<?php echo $productData['sale_price'] ;?>" />
                    </td>
                  </tr>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Sale Price Dates</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                      <input type="text" class="form-control input-sm datepicker" data-provide="datepicker"  name="send[sale_price_from]" value="<?php echo $productData['sale_price_from'] ;?>" />
                      <br>
                      <input type="text" class="form-control input-sm datepicker" data-provide="datepicker"  name="send[sale_price_to]" value="<?php echo $productData['sale_price_to'] ;?>" />
                    </td>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- tab-general -->

            <!-- tab-inventory -->
            <div id="tab-inventory">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Manage stock?</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <?php if((int)$productData['quantity'] > 0){ ?>
                    <input type="checkbox"  name="is_stock_manage" checked id="is_stock_manage" value="1" /> <label for="is_stock_manage">Enable stock management at product level</label>
                    <?php }else{ ?>
                    <input type="checkbox"  name="is_stock_manage" id="is_stock_manage" value="1" /> <label for="is_stock_manage">Enable stock management at product level</label>
                    <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Stock Quantity</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <input type="text" class="form-control input-sm" name="send[quantity]" value="<?php echo $productData['quantity'] ;?>" />
                    </td>
                  </tr>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Require Minimum</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <input type="text" class="form-control input-sm" name="send[require_minimum]" value="<?php echo $productData['require_minimum'] ;?>" />
                    </td>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- tab-inventory -->
                        
            <!-- tab-shipping -->
            <div id="tab-shipping">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Weight (<?php echo FastEcommerce::getWeightUnit();?>)</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <input type="text" class="form-control input-sm" name="send[weight]" value="<?php echo $productData['weight'] ;?>" />
                    </td>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- tab-shipping -->


            <!-- tab-attributes -->
            <div id="tab-attributes">
              <div class="head">
                <button type="button" class="btn btn-primary btn-add-attr btn-sm">Add</button>
              </div>
              <hr>
              <div class="body">

              <?php if(is_array($productData['attr_data'])){ 

                $li='';

                $total=count($productData['attr_data']);

                for ($i=0; $i < $total; $i++) { 
                  $li.='
                  <!-- item -->
                  <div class="row margin-bottom-20 attr-item">
                    <div class="col-lg-4 col-md-4 col-sm-4 ">
                      <label>Name:</label>
                      <br>
                      <input type="text" class="form-control input-sm" name="attr_name[]" value="'.$productData['attr_data'][$i]['name'].'" />
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 ">
                      <label>Value(s):</label>
                      <br>
                      <textarea class="form-control" rows="3" name="attr_values[]" placeholder="Enter some text, or some attributes by \'|\' separating values">'.implode('|', $productData['attr_data'][$i]['values']).'</textarea>
                    </div>
                  </div>
                  <!-- item --> 
                  ';
                }

                echo $li;
              ?>

              <?php } ?>                
              </div>
            </div>
            <!-- tab-attributes -->

            <!-- tab-advanced -->
            <div id="tab-advanced">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Purchase Note</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <textarea class="form-control" rows="3" name="send[purchase_note]"><?php echo $productData['purchase_note'] ;?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 ">Enable reviews</td>
                    <td class="col-lg-8 col-md-8 col-sm-8 ">
                    <?php if((int)$productData['enable_review']==1){ ?>
                    <input type="checkbox" id="enable_review" checked name="send[enable_review]" value="1" />
                    <?php }else{ ?>
                    <input type="checkbox" id="enable_review" name="send[enable_review]" value="1" />
                    <?php } ?>
                    </td>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- tab-advanced -->

            <!-- #tab-virtualdownload -->
            <div id="tab-virtualdownload">
              <p>
                  <label><strong>Upload Files</strong></label>
                  <input type="file" multiple="" name="downloads[]" />
                  <?php if(is_array($productData['download_data'])){

                    $li='';

                    $total=count($productData['download_data']);

                    for ($i=0; $i < $total; $i++) { 
                      $li.='
                      <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 ">
                          <span class="label label-primary">'.basename($productData['download_data'][$i]).'</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 text-right">
                          <span class="label label-danger cursor-pointer" title="Remove this file" data-file="'.$productData['download_data'][$i].'">Remove [X]</span>
                        </div>

                      </div>

                      ';
                    }

                    echo $li;

                  } ?>


              </p>               
            </div>
            <!-- #tab-virtualdownload -->

            <!-- tab-advanced -->
            <div id="tab-seo">
              <p>
                  <label><strong>Page Title</strong> (<span class="system_count_char" data-target=".prod-page-title">0</span> characters)</label>
                  <input type="text" class="form-control prod-page-title input-size-medium" name="send[page_title]" placeholder="Page Title" value="<?php echo $productData['page_title'] ;?>" />
              </p> 
              <p>
                  <label><strong>Descriptions</strong> (<span class="system_count_char" data-target=".prod-descriptions">0</span> characters)</label>
                  <input type="text" class="form-control prod-descriptions input-size-medium" name="send[descriptions]" placeholder="Descriptions" value="<?php echo $productData['descriptions'] ;?>" />
              </p> 
              <p>
                  <label><strong>Keywords</strong> (<span class="system_count_char" data-target=".prod-keywords">0</span> characters)</label>
                  <input type="text" class="form-control prod-keywords input-size-medium" name="send[keywords]" placeholder="Keywords" value="<?php echo $productData['keywords'] ;?>" />
              </p>               
            </div>
            <!-- tab-advanced -->
          </div>
        </div>

      </div>
    </div>
    <!-- panel -->

    <!-- panel -->    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Product Short Description</h3>
      </div>    
      <div class="panel-body">
        <textarea id="shortdesc" rows="15" name="send[shortdesc]" class="form-control shortdesc"><?php echo $productData['shortdesc'] ;?></textarea>
      </div>
    </div>
    <!-- panel -->

  </div>
  <!-- left -->
  <!-- right -->
  <div class="col-lg-4 col-md-4 col-sm-4 ">
    <!-- Panel -->
    <div class="panel panel-default">
      <div class="panel-body">
        <?php if($productData['status']!='publish'){ ?>
        <p>
          <input type="checkbox" id="product-status" checked name="send[status]" value="publish" /> <label for="product-status">Publish this product</label>
        </p>
        <?php }else{ ?>
        <p>
          <input type="checkbox" checked id="product-status" checked name="send[status]" value="publish" /> <label for="product-status">Publish this product</label>
        </p>

        <?php } ?>
        <p>
        <?php
        $catSelected=array();

        if(is_array($productData['category_data']))
        {
          $total=count($productData['category_data']);

          for ($i=0; $i < $total; $i++) { 
            $catSelected[]=$productData['category_data'][$i]['catid'];
          }
        }

        ?>
            <label><strong>Category</strong></label>
            <select name="catid[]" multiple class="form-control chosen-select selected-parentid">
                <?php if(isset($listCat[0]['catid'])){ ?>
                <?php
                $total=count($listCat);

                $li='';

                for ($i=0; $i < $total; $i++) { 

                    if(in_array($listCat[$i]['catid'], $catSelected))
                    {
                      $li.='<option selected value="'.$listCat[$i]['catid'].'">'.$listCat[$i]['title'].'</option>';
                    }
                    else
                    {
                      $li.='<option value="'.$listCat[$i]['catid'].'">'.$listCat[$i]['title'].'</option>';
                    }
                    
                }

                echo $li;
                ?>
                <?php } ?>
            </select>
        </p>
        <p>
            <label><strong>Tags (separate by commas)</strong></label>
            <?php

            $li='';

            if(is_array($productData['tag_data']))
            {
              $li='';

              $total=count($productData['tag_data']);

              if($total > 0)
              {
                for ($i=0; $i < $total; $i++) { 
                  $li.=trim($productData['tag_data'][$i]['title']).',';
                }

                $li=substr($li, 0,strlen($li)-1);
              }
            }

            ?>
            <input type="text" class="form-control input-size-medium panda-autocomplete" id="input-tags" name="tags" placeholder="Tags" value="<?php echo $li; ?>" />
        </p>

      </div>
    </div>
    <!-- Panel -->
    <!-- Panel -->
    <div class="panel panel-default">
      <div class="panel-body">
        <p>
        <button type="submit" class="btn btn-primary" style="width: 100%;" name="btnSave">Save Changes</button>
        </p>

      </div>
    </div>
    <!-- Panel -->
    <!-- Panel -->
    <div class="panel panel-default">
      <div class="panel-body">
        <p>
          <label><strong>Product Image</strong></label>
          <input type="file" name="thumbnail" />
        </p>
        <p>
        <img src="<?php echo $productData['imageUrl'] ;?>" class="img-responsive" />
        </p>
      </div>
    </div>
    <!-- Panel -->
    <!-- Panel -->
    <div class="panel panel-default">
      <div class="panel-body">
        <p>
          <label><strong>Product Gallery</strong></label>
          <input type="file" name="images[]" multiple />
        </p>
        <p>
        <div class="row">
          <div class="col-lg-12">
            <ol class="list-images">
            <?php
            if(is_array($productData['image_data']))
            {
              $li='';

              $total=count($productData['image_data']);

              for ($i=0; $i < $total; $i++) { 
                $li.='<li data-id="'.$productData['image_data'][$i]['id'].'" data-order="'.$productData['image_data'][$i]['sort_order'].'"><img src="'.$productData['image_data'][$i]['url'].'" /><input type="hidden" name="images[]" value="'.$productData['image_data'][$i]['id'].'" /></li>';
              }

              echo $li;
            }
            ?>            
              
            </ol>
          </div>

        </div>
        </p>
      </div>
    </div>
    <!-- Panel -->

  </div>
  <!-- right -->
</div>
<!-- row -->



</form>

<div id="template_product_attr" style="display: none;" >
  <!-- item -->
  <div class="row margin-bottom-20 attr-item">
    <div class="col-lg-4 col-md-4 col-sm-4 ">
      <label>Name:</label>
      <br>
      <input type="text" class="form-control input-sm" name="attr_name[]" />
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 ">
      <label>Value(s):</label>
      <br>
      <textarea class="form-control" rows="3" name="attr_values[]" placeholder="Enter some text, or some attributes by '|' separating values"></textarea>
    </div>
  </div>
  <!-- item -->  
</div>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  // CKEDITOR.replace( 'editor' );
CKEDITOR.replace( 'editor' ,{
  extraPlugins: 'wordcount,notification,texttransform,justify',

  filebrowserBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});   

</script>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  // CKEDITOR.replace( 'editor' );
CKEDITOR.replace( 'shortdesc' ,{
  extraPlugins: 'wordcount,notification,texttransform,justify',

  filebrowserBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});   

</script>
<script src="<?php echo ROOT_URL;?>bootstrap/chosen/chosen.jquery.js"></script>  


<script>
$(document).ready(function(){
  $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    })
});

$(function  () {
  $("ol.list-images").sortable();
});
</script>
<script>
  $(function() {
    $('.chosen-select').chosen();
  });
</script>

  <script type="text/javascript">
  var root_url='<?php echo System::getUrl();?>';

  $(document).ready(function(){
      $('#uploadMethod').change(function(){
          var option=$(this).children('option:selected');

          var target=option.attr('data-target');

          $('.pupload').hide();
          $('.'+target).slideDown('fast');

      });

      $('.panda-autocomplete').keydown(function(){
        var theVal=$(this).val();
      });


      $('.btn-add-attr').click(function(){
        var template=$('#template_product_attr').html();

        $('#tab-attributes').children('.body').append(template);

      });

      $('.input-regular-price').keyup(function(event) {
        var theVal=$(this).val();

        $('.input-sale-price').val(theVal);
      });


  });
    
  </script>