<style>

.percent{
	width:300px;
	background:grey;	
}

.colorPercent{
	background:red;
	display:inline-block;	
}

</style>

<?php require_once "verification.php" ?>

<?php

$current_profile = $_GET['u'];

$profilerow = mysqli_query($con,"SELECT * FROM users WHERE id = $current_profile");
$row = mysqli_fetch_array($profilerow);
	
	$currentprofile_name = $row['name'];
	$currentprofile_id = $row['id'];

?>

<?php
			
			$languages = array();
			
            $languagesrow = mysqli_query($con,"SELECT chat FROM messages WHERE author = $currentprofile_id");
            while ($row = mysqli_fetch_array($languagesrow)){
               
			   	$chat_id = $row['chat'];
			   
				$result = mysqli_query($con,"SELECT language FROM chats WHERE id = $chat_id");
            	$row = mysqli_fetch_array($result);
				
					array_push($languages, $row['language']);
					
			}
			
			$count = array_count_values($languages); //Counts the values in the array, returns associatve array
			arsort($count); //Sort it from highest to lowest
			$keys = array_keys($count); //Split the array so we can find the most occuring key
			
			$total = array_sum($count);
			$percentages = array();

			foreach($count as $language => $hits) {
			   
			   $percent = round($hits / $total * 100, 1);
			   $percentages[$language] = $percent;
			   
			}
			
			?>
                       
            <table style="width:100%">
            <?php
			
			foreach ($keys as $key){
			
			?>
            
              <tr style="width:25%">
                <td><?php echo $key?></td>
                <td>
                    <div class="percent">
                        <div class="colorPercent" style="width:<?php echo $percentages[$key]."%"?>">
                        	<?php echo $percentages[$key]."%"?>
                        </div>
                    </div>
                </td> 
              </tr>
            
            <?php
			}
			
			?>
			</table>