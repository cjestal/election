<form action="?controller=home&action=vote" method="post">
	<?php foreach ($data as $pkey => $position):?> <!-- Load positions -->
		<h3><?php echo $position['name'];?></h3>
		<input type="hidden" class="<?php echo "position_" . $pkey;?>" name="<?php echo $pkey;?>">
		<div class="row">
		
		<?php foreach ($position['results'] as $ckey => $candidate):?> <!-- Load candidate "cards" for current position -->
			<div class="col s4 m4">
				<div class="card sticky-action">

					<!-- Card Image -->
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="https://www.vx.nl/assets/images/avatar-placeholder.jpg?w=60&h=60&useCustomFunctions=1&centerCrop=1">
						<span class="card-title"><?php echo $candidate['fname']. " " .$candidate['lname'];?></span>
					</div>

					<!-- The div that shows only when image is clicked -->
					<div class="card-reveal">
						<span class="card-title grey-text text-darken-4"><?php echo $candidate['fname']. " " .$candidate['lname'];?><i class="material-icons right">close</i></span>
						<ul>
							<li><i class="small material-icons">insert_chart</i><?php echo $candidate['key_campaign']?></li>
							<li><i class="small material-icons">grade	</i><?php echo $candidate['key_achievement']?></li>
							<?php if ($candidate['is_current_officer']) :?>
							<li><i class="small material-icons">vpn_key</i>Currently an officer</li>
							<?php endif;?>
						</ul>
					</div>

					<!-- Card action -->
					<div class="card-action center-align">
						<a id="<?php echo $candidate['id'];?>" class="waves-effect waves-light btn voteBtn btn_<?php echo $pkey;?>" onClick="javascript:void(0);" position="<?php echo $pkey;?>"><i class="material-icons left">thumb_up</i>Vote</a>
					</div>

				</div>
			</div>
		<?php endforeach;?> <!-- END of candidates -->
		</div>
	<?php endforeach;?> <!-- END of positions -->
	<button class="btn waves-effect waves-light btn-large deep-orange s4" type="submit">Submit
	<i class="material-icons right">send</i>
	</button>

</form>

