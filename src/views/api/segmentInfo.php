<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");



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
$agencyId = isset($_GET['agencyId']) ? $_GET['agencyId'] : null;
$segmentId = isset($_GET['segmentId']) ? $_GET['segmentId'] : null;

if($agencyId && !$segmentId){
$sql="SELECT agency.agency_name As AgencyName, agency.amadeus_customer_no AS CustomerNumber, segments.segment_id As SegmentId, segments.year AS Year, segments.month AS Month, segments.total AS Total, segments.domestic_seg AS DomesticSeg
FROM agency JOIN segments ON agency.agency_Id = segments.agency_Id
WHERE agency.agency_id='$agencyId';";
}
elseif ($segmentId) {
    $sql = "SELECT agency.agency_name As AgencyName, agency.amadeus_customer_no AS CustomerNumber, CONCAT(segments.year, ', ', segments.month) AS YearMonth, segments.create_time AS CreateTime,
            segments.base_seg_rate AS BaseRate, segments.intl_seg_rate AS IntlRate, segments.domestic_seg AS DomesticSeg, segments.intl_seg AS IntlSeg
            FROM agency JOIN segments ON agency.agency_Id = segments.agency_Id
            WHERE segments.segment_id='$segmentId';";
}

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