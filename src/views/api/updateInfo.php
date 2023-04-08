<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "root";
$mysql_database = "ata_db";

$conn = new mysqli($servername, $username, $password, $mysql_database);
$conn->set_charset('utf8');

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$input = json_decode(file_get_contents('php://input'), true);

$agencyData = $input['agencyData'];

$updates = [];
$params = [];
$paramTypes = '';

$columnMapping = [
    'CustomerNumber' => 'agency.amadeus_customer_no',
    'OfficeNumber' => 'agency.office_no',
    'email' => 'agency.contract_email',
    'Market' => 'agency.market',
    'FirstName' => 'agency.first_name',
    'LastName' => 'agency.last_name',
    'phone_num' => 'agency.mobile_no',
    'address' => 'agency.agency_address',
    'direct_username' => 'agency.direct_username',
    'direct_pwd' => 'agency.direct_pwd',
    'IATA_id' => 'agency.IATA_no',
    'amadeus_user' => 'agency.amadeus_username',
    'amadeus_pwd' => 'agency.amadeus_pwd',
    'manager_name' => 'contract.account_manager',
    'contract_no' => 'contract.contract_id',
];

foreach ($agencyData as $key => $value) {
    if ($key === 'Name') {
        $name_parts = explode(' ', $value, 2);
        $updates[] = $columnMapping['FirstName'] . " = ?";
        $params[] = $name_parts[0];
        $paramTypes .= 's';

        $updates[] = $columnMapping['LastName'] . " = ?";
        $params[] = isset($name_parts[1]) ? $name_parts[1] : '';
        $paramTypes .= 's';
    } elseif (isset($columnMapping[$key])) {
        $updates[] = $columnMapping[$key] . " = ?";
        $params[] = $value;
        $paramTypes .= 's';
    }
}

$response = [
    'status' => 200,
    'msg' => 'Success',
    'code' => 20000,
    'data' => []
];

if (count($updates) > 0) {
$updateStr = implode(', ', $updates);

$sql = "UPDATE agency
JOIN contract ON agency.agency_id = contract.agency_id
SET $updateStr
WHERE agency.amadeus_customer_no = ?";
$params[] = $agencyData['CustomerNumber'];
$paramTypes .= 's';

$stmt = $conn->prepare($sql);
$stmt->bind_param($paramTypes, ...$params);
$stmt->execute();



    if ($stmt->affected_rows > 0) {
        $response['data'] = ['affected_rows' => $stmt->affected_rows];
    } 
    else {
        $response['msg'] = 'No changes were made';
        $response['data'] = ['custom_warning' => true];
        }
    }
else {
    $response['msg'] = 'No fields to update';
    $response['data'] = ['custom_warning' => true];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

$conn->close();
?>
