<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');


$servername = "localhost";
$username = "root";
$password = "root";
$mysql_database = "ata_db";

$conn = new mysqli($servername, $username, $password);

mysqli_set_charset($conn, 'utf8');
mysqli_select_db($conn, $mysql_database);

if (!$conn) {
    echo ("Fail to connect");
}

$agencyId = $_GET['agencyId'];
$sql = "SELECT agency_name AS AgencyName, agency.amadeus_customer_no AS CustomerNumber, office_no AS office_no, province_state AS State, city AS City, CONCAT(province_state, ' ', post_code) AS PostCode, market AS Market,
CONCAT(first_name, ' ', last_name) AS Name, contact_email As email, mobile_no as phone_num, agency_address AS address,
direct_username as direct_username, direct_pwd AS direct_pwd, IATA_no AS IATA_id, amadeus_username As amadeus_user, amadeus_pwd AS amadeus_pwd,
contract.contract_id AS contract_no, contract.account_manager AS manager_name 
FROM ata_db.agency
JOIN ata_db.contract ON agency.agency_id = contract.agency_id
WHERE agency.agency_id = '$agencyId'";




$result = $conn->query($sql);

$response = [
    'status' => 200,
    'msg' => 'Success',
    'code' => 20000,
    'data' => []
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
} else {
    $response['msg'] = '';
    $response['code'] = 30000;
    $response['data'] = [];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

$conn->close();

?>