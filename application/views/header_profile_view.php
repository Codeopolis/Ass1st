<ul class="nav pull-right player-controls">
    <li>
		<!-- player logo -->
		<img class="img-player" src="<?php echo $picture; ?>" />
    </li>
    <li>
    	<!-- player controls -->
		<div class="dropdown pull-right">
			<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
				<?php echo $full_name; ?> <b class="caret white-caret"></b>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a href="<?php echo base_url(); ?>pages/user_profile">My Profile</a></li>
				<li><a href="<?php echo base_url(); ?>edit_profile">Edit Profile</a></li>
				<li class="divider"></li>
				<li><a href="<?php echo base_url(); ?>logout">Log Out</a></li>
			</ul>
		</div>    	
    </li>
</ul>