<?php
$debug = false;
#Amy Moczydlowski, Melissa Chodziutko, Shaina Razvi, Danielle Anderson, Ryan Sheffler
#shows table of characters
function show_smash($dbc) {
	# Create a query to get the characters
	$query = "SELECT bid, update_date, character_name, buyer_name FROM smash" ;

	# Execute the query
	$results = mysqli_query( $dbc , $query ) ;
	check_results($results) ;
	# Show results
	if( $results )
	{
  		# But...wait until we know the query succeed before
  		# rendering the table start.
  		 echo '<H1>Current Listings:</H1>' ;
		echo '<TABLE>';
		  echo '<table border = "1"';
		  echo '<TR>';
		  echo '<TH>Character</TH>';
		  echo '<TH>Highest bid</TH>';
		  echo '<TH>Highest Bidder</TH>';
          echo '<TH>Last Bid Time</TH>';
		  echo '</TR>';
		  # For each row result, generate a table row
		  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
          {
			echo '<TR>' ;
            echo '<TD>' . $row['character_name'] . '</TD>' ;
			echo '<TD>$' . $row['bid'] . '</TD>' ;
			echo '<TD>' . $row['buyer_name'] . '</TD>' ;
            echo '<TD>' . $row['update_date'] . '</TD>' ;
			echo '</TR>' ;
		  }
		  # End the table
		  echo '</TABLE>';
		  # Free up the results in memory
		  mysqli_free_result( $results ) ;
    }
}

#Function to show all the characters from the smash table, formatted to fill a dropdown box.
function get_smash_dropdown($dbc, $selectedid) {
	# Create a query to get the character name and id from the smash table
	$query = 'SELECT character_name, id FROM smash ORDER BY id ASC' ;

	# Execute the query
	$results = mysqli_query($dbc, $query );
	check_results($results);
	
	# Show results
	if($results)
	{
  		# For each row result, output a selection box choice
  		while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  		{
			if($row['id']==$selectedid)
				echo '<option value="'.$row['id'].'" selected>'.$row['character_name'].'</option>';
			else
				echo '<option value="'.$row['id'].'">'.$row['character_name'].'</option>';
  		}

  		# Free up the results in memory
  		mysqli_free_result( $results ) ;
	}
}

#Function to get the current highest bid of a character at [id]
function get_bid($dbc,$id){
	# Create a query to get the current highest bid for a character
	$query='SELECT bid FROM smash WHERE id='.$id;
	
	# Execute the query
	$results = mysqli_query($dbc, $query );
	check_results($results);
	
		# Show results
	if($results)
	{
  		# For each row result, output a selection box choice
  		while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  		{
			return $row['bid'];
		}
		# Free up the results in memory
  		mysqli_free_result( $results );
	}
}

function insert_record($dbc, $id, $bid, $buyer) {
	$query = 'UPDATE smash SET bid =' . $bid . ', update_date = Now(), buyer_name ="' . $buyer . '" WHERE id=' . $id;
	show_query($query);
	$results = mysqli_query($dbc,$query) ;
	check_results($results) ;
	return $results ;
}

# Shows the query as a debugging aid
function show_query($query) {
  global $debug;
  if($debug)
    echo "<p>Records have been changed.</p>" ;
}

# Checks the query results as a debugging aid
function check_results($results) {
  global $dbc;
  if($results != true)
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>'  ; 
}
?>