<p><a href="<?echo ADMIN_URL ?>/screens">Back to Screens Listing</a> | 
  <a href="<?echo ADMIN_URL ?>/screens/edit/<?echo $this->screen->id ?>"> Edit Screen 
</a></p>
<?php
  if($this->screen->width/$this->screen->height==(16/9)){
    $scrimg="screen_169.png";
    $ratio ="16:9";
  }else{
    $scrimg="screen_43.png";
    $ratio ="4:3";
  }
?>
      <img style="float:left; padding-right:10px" src="<?echo 
ADMIN_BASE_URL?>/images/<?echo 
$scrimg?>" alt="" 
/>
      <h3>Location:</h3>
	<p><? echo $this->screen->location?></p>
      <h3>Screen:</h3>
      <p><?php echo $this->screen->width.' x '.$this->screen->height.' ('.$ratio; 
?>)</p>
      <h3>Status</h3>
      <p>
      <?php if(strtotime($this->screen->last_updated)>strtotime('-1 minutes')) { ?>
        <span style="color:green; font-weight:bold;">Online</span>
      <?php } else { ?>
        <span style="color:red; font-weight:bold;">Offline</span>
      <?php } ?> (Last updated: <?php echo $this->screen->last_updated?>)
      </p>
      <h3 style="clear:left">Subscriptions</h3>
      <ul>
	<? foreach ($this->screen->list_fields() as $field) { ?>
	 <li>Position <? echo $field ?><ul>
	   <?php
		$positions = $this->screen->list_positions($field) ;
		if(sizeof($positions)) {
		  foreach ($this->screen->list_positions($field) as $position) { 
	   ?>
		  <li><? print_r( $position[feed_id] ); } ?></li>
	   <?php
		} else echo "<li>(none)</li>";
	   ?>
	 </ul></li>
	<?php }?> 
      </ul>

