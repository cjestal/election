<?php foreach ($data as $key => $position):?> <!-- Load positions -->
	<h3><?php echo $position['name'];?></h3>
	<div class="row">
	<?php foreach ($position['results'] as $key => $candidate):?> <!-- Load candidates -->
		<div class="row">
			<div class="col s4">
				<span class="flow-text">
					<?php echo $candidate['fname'] . " " . $candidate['lname'];?> <!-- Display Candidate FULL Name -->
				</span>
			</div>
				<?php
					$percentage = ((int)$candidate['votes'] / $position['total']) * 100;
					$percentage = number_format((float)$percentage, 2, '.', '');
					echo $percentage . '%';
				?>
			<div class="col s8 progress"> <!-- Display Progress bar with dynamic width -->
				<div class="determinate" style="width: <?php echo $percentage?>%"></div>
			</div>
	    </div>
	<?php endforeach;?> <!-- END of  Load candidates -->
	</div>
<?php endforeach;?> <!-- END of Load positions -->