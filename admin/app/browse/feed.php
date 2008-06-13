<? if ($this->feed->user_priv($_SESSION['user'], "edit")) { ?>
<a href="<?=ADMIN_URL.'/feeds/show/'.$this->feed->id ?>"><span class="buttonsel"><div class="buttonleft"><img src="<?= ADMIN_BASE_URL ?>/images/buttonsel_left.gif" border="0" alt="" /></div><div class="buttonmid"><div class="buttonmid_padding">Administration for this feed</div></div><div class="buttonright"><img src="<?= ADMIN_BASE_URL ?>/images/buttonsel_right.gif" border="0" alt="" /></div></span></a><div style="clear:both;height:12px;"></div>
<? } ?>

<?php
if($this->feed->user_priv($_SESSION['user'], "moderate")){
?>
<h3>Moderation status: <span class="emph"><a href="<?=ADMIN_URL?>/moderate/feed/<?=$this->feed->id?>"><?= $this->waiting > 0 ? $this->waiting : "No" ?> items awaiting moderation</a></span></h3>
<?
}
?>

<h3>Content</h3>
<ul>
<? foreach($this->feed->get_types() as $type_id => $type){ ?>
<li><a href="<?= ADMIN_URL ?>/browse/show/<?= $this->feed->id ?>/type/<?= $type_id ?><?= isset($this->args[2]) ? "/{$this->args[2]}" : "" ?>"><?= $type ?></a></li>
<? } ?>
</ul>

<h3>Feed Statistics</h3>
<ul>
<li>Active and Future Content: <?= $this->active_content ?></li>
<li>Expired Content: <?= $this->expired_content ?></li>
</ul>
<p>This feed is moderated by <a href="<?=ADMIN_URL.'/groups/show/'.$this->group->id?>"><?= htmlspecialchars($this->group->name) ?></a>.</p>