<h3>Sort My Sites</h3>
<p>Users can override these settings from the screen options on the My Sites page</p>
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
		<th><label for="<?php echo $this->plugin_slug . "_direction"  ?>">Direction</label></th>
		<td>
			<select id="<?php echo $this->plugin_slug . "_direction"  ?>" name="<?php echo $this->plugin_slug . "_direction"  ?>">
				<option value="asc"  <?php selected( $this->options['direction'], 'asc', false );  ?> >Ascending</option>
				<option value="desc"  <?php selected( $this->options['direction'], 'desc', false );  ?> >Descending</option>
			</select>
		</td>
	</tr>	
	<tr>
		<th><label for="<?php echo $this->plugin_slug . "_case_sensitive"  ?>">Case sensative</label></th>
		<td>
			<label>
				<input type="checkbox" name="<?php echo $this->plugin_slug . "_case_sensitive" ?>" value="1" <?php checked( true, $this->options["case_sensitive" ], true ); ?>>
				 Case sensitive
			</label>
		</td>
	</tr>
	<tr>
		<th><label for="<?php echo $this->plugin_slug . "_primary_at_top"  ?>">Primary Site First</label></th>
		<td>
			<label>
				<input type="checkbox" name="<?php echo $this->plugin_slug . "_primary_at_top" ?>" value="1" <?php checked( true, $this->options["primary_at_top" ], true ); ?>>
				 Always show the primary site first
			</label>
		</td>
	</tr>
</table>