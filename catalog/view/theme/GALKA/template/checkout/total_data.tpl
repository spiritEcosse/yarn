<?php foreach ($totals as $total) { ?>
	<tr>
		<td colspan="5" class="price"><b><?php echo $total['title']; ?>:</b></td>
		<td class="total"><div class="rightPrice"><?php echo $total['text']; ?></div></td>
	</tr>
<?php } ?>
