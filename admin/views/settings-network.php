<h3>Sort My Sites</h3>
<table class="form-table">
	<tr>
		<th><label for="<?php echo $this->plugin_slug . "_order_by"  ?>">Order by</label></th>
		<td>
			<select id="<?php echo $this->plugin_slug . "_order_by"  ?>" name="<?php echo $this->plugin_slug . "_order_by"  ?>">
				<?php foreach($this->options['order_options'] as $option => $title){ ?>
		
					<option value="<?php echo $option ?>"  <?php selected( $this->options['order_by'], $option, true );  ?> ><?php echo $title ?></option>

				<?php } ?>
			</select>

		</td>
	</tr>
	<tr>
		<th><label for="<?php echo $this->plugin_slug . "_case_sensitive"  ?>">Case Sensative</label></th>
		<td>
			<label>
				<input type="checkbox" name="<?php echo $this->plugin_slug . "_case_sensitive" ?>" value="1" <?php checked( true, $this->options["case_sensitive" ], true ); ?>>
				 Case Sensitive
			</label>
		</td>
	</tr>
	<tr>
		<th><label for="<?php echo $this->plugin_slug . "_primary_at_top"  ?>">Primary Site at Top</label></th>
		<td>
			<label>
				<input type="checkbox" name="<?php echo $this->plugin_slug . "_primary_at_top" ?>" value="1" <?php checked( true, $this->options["primary_at_top" ], true ); ?>>
				 Keep primary site at the top
			</label>
		</td>
	</tr>
</table>