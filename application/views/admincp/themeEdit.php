<style type="text/css">
.ul-list-files
{
	list-style: none;
	padding: 0px;
	margin:0px;
  overflow: scroll;
      overflow-y: auto;
    overflow-x: hidden;  
    max-height: 500px;	
}

.ul-list-files li a
{
	color:#419b0d;
}

.btn-icon
{
	cursor: pointer;
}

.btn-icon:hover
{
	color: #ed2f0e;
}
</style>

<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
    	<!-- left -->
    	<div class="col-lg-3">
    	<h3>All Files</h3>
    		<ul class="ul-list-files">
    		<li><a href="<?php echo System::getAdminUrl().'theme/edit/'.$themeName.'/?path='.dirname($subPath);?>">..</a></li>
    		<?php
    		if(isset($listFiles[0]))
    		{
    			$total=count($listFiles);

    			$li='';

    			for ($i=0; $i < $total; $i++) { 

    				if(!preg_match('/\w+/i', $subPath))
    				{
    					$subPath='';
    				}

    				$li.='<li><a href="'.System::getAdminUrl().'theme/edit/'.$themeName.'/?path='.$subPath.$listFiles[$i].'">'.$listFiles[$i].'</a>
    				<div class="pull-right">
    				
    				</div>
    				</li>';
    			}

    			echo $li;
    		}
    		?>
    		</ul>
    	</div>
    	<!-- left -->
    	<!-- right -->
    	<div class="col-lg-9">
    	<form action="" method="post" enctype="multipart/form-data">
    		<h3>Content of <?php if(isset($file['name']))echo $file['name'] ;?>
    		<button type="submit" name="btnSave" class="btn btn-primary btn-xs pull-right">Save changes</button>
    		</h3>

    		<div class="file-content">
    			<textarea class="form-control" placeholder="File content" name="send[file_content]" id="file-content" rows="20"><?php if(isset($file['data']))echo $file['data'] ;?></textarea>
    		</div>
    	</form>
    	</div>
    	<!-- right -->

    </div>
  </div>
</div>