<?php
/*
header('Access-Control-Allow-Origin: 127.0.0.1');
header('Access-Control-Allow-Credentials: true');
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

session_start();

require_once 'config/db.php';

$data = array();

// sql statements to get all decks
$query = "SELECT d.deck_id, d.deckname, d.description, d.clan, od.user_id, u.username   
FROM decks d
INNER JOIN ownsdeck od
    on d.deck_id = od.deck_id
INNER JOIN users u
    on od.user_id = u.id";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$resultCount = $result->num_rows;
$stmt->close();

if ($resultCount <= 0)
{
	//$errors['cards_not_found'] = "Could not retrieve cards";
}
else{
	//store retrieved cards
	while ($row = mysqli_fetch_object($result)){
		$data[]=$row;
	}
	
	echo json_encode($data);
}
?>