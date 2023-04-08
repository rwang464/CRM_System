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
$marketResult=null;
$result=null;

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$customerId = isset($_GET['customer']) ? $_GET['customer'] : '';
$market = isset($_GET['market']) ? $_GET['market'] : '';
$country= isset($_GET['country']) ? $_GET['country'] : '';
$status= isset($_GET['status']) ? $_GET['status'] : '';
if ($searchTerm !== '') {
    $searchTermWithWildcard = '%' . $searchTerm . '%';
    $sql = "SELECT agencyId, AgencyName, Market, Country, CustomerNumber, OfficeNumber, State, City, PostCode, CONCAT(UnpaidCount, ' payouts unpaid (', PeriodDate, ' ) ') AS TotalUnpaid, CONCAT(ExpiredDays, ' days') AS TotalExpiry, Status
        FROM (
            SELECT a.agency_id As agencyId, a.agency_name AS AgencyName, a.market As Market, a.region_country as Country, a.amadeus_customer_no AS CustomerNumber, a.office_no AS OfficeNumber, a.province_state AS State, a.city AS City, CONCAT(a.province_state, ' ', a.post_code) AS PostCode, CONCAT( DATE_FORMAT(c.start_date, '%b %y'), ' - ', DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y')) AS PeriodDate, SUM(CASE WHEN b.payout_status = 0 THEN 1 ELSE 0 END) AS UnpaidCount, DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y') AS PeriodEndDate, TIMESTAMPDIFF(DAY, CURDATE(), DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH)) AS ExpiredDays, c.contract_status_id AS Status
            FROM ata_db.agency a
            JOIN ata_db.segments b ON a.agency_id = b.agency_id
            JOIN ata_db.contract c ON a.agency_id = c.agency_id
        WHERE a.agency_name LIKE ? OR SOUNDEX(a.agency_name) = SOUNDEX(?)
        GROUP BY a.agency_id, a.agency_name, a.amadeus_customer_no, a.office_no, a.province_state, a.city, a.post_code, c.start_date, c.payout_period, c.contract_status_id
    ) AS T
    ORDER BY CustomerNumber ASC";
    $stmt = $conn->prepare($sql);
    if ($customerId !== '') {
        $sql = "SELECT agencyId, AgencyName, Market, Country, CustomerNumber, OfficeNumber, State, City, PostCode, CONCAT(UnpaidCount, ' payouts unpaid (', PeriodDate, ' ) ') AS TotalUnpaid, CONCAT(ExpiredDays, ' days') AS TotalExpiry, Status
        FROM (
            SELECT a.agency_id As agencyId, a.agency_name AS AgencyName, a.market As Market, a.region_country as Country, a.amadeus_customer_no AS CustomerNumber, a.office_no AS OfficeNumber, a.province_state AS State, a.city AS City, CONCAT(a.province_state, ' ', a.post_code) AS PostCode, CONCAT( DATE_FORMAT(c.start_date, '%b %y'), ' - ', DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y')) AS PeriodDate, SUM(CASE WHEN b.payout_status = 0 THEN 1 ELSE 0 END) AS UnpaidCount, DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y') AS PeriodEndDate, TIMESTAMPDIFF(DAY, CURDATE(), DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH)) AS ExpiredDays, c.contract_status_id AS Status
            FROM ata_db.agency a
            JOIN ata_db.segments b ON a.agency_id = b.agency_id
            JOIN ata_db.contract c ON a.agency_id = c.agency_id
            WHERE a.agency_name LIKE ? OR SOUNDEX(a.agency_name) = SOUNDEX(?)
            OR  a.amadeus_customer_no=?
            GROUP BY a.agency_id, a.agency_name, a.amadeus_customer_no, a.office_no, a.province_state, a.city, a.post_code, c.start_date, c.payout_period, c.contract_status_id
        ) AS T
        ORDER BY CustomerNumber ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $searchTermWithWildcard, $searchTerm, $customerId);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $searchTermWithWildcard, $searchTerm);
    }
    $stmt->execute();
    $result = $stmt->get_result();
}else if($customerId !== ''){
        $sql = "SELECT agencyId, AgencyName, Market, Country, CustomerNumber, OfficeNumber, State, City, PostCode, CONCAT(UnpaidCount, ' payouts unpaid (', PeriodDate, ' ) ') AS TotalUnpaid, CONCAT(ExpiredDays, ' days') AS TotalExpiry, Status
        FROM (
            SELECT a.agency_id As agencyId, a.agency_name AS AgencyName, a.market As Market, a.region_country as Country, a.amadeus_customer_no AS CustomerNumber, a.office_no AS OfficeNumber, a.province_state AS State, a.city AS City, CONCAT(a.province_state, ' ', a.post_code) AS PostCode, CONCAT( DATE_FORMAT(c.start_date, '%b %y'), ' - ', DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y')) AS PeriodDate, SUM(CASE WHEN b.payout_status = 0 THEN 1 ELSE 0 END) AS UnpaidCount, DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y') AS PeriodEndDate, TIMESTAMPDIFF(DAY, CURDATE(), DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH)) AS ExpiredDays, c.contract_status_id AS Status
            FROM ata_db.agency a
            JOIN ata_db.segments b ON a.agency_id = b.agency_id
            JOIN ata_db.contract c ON a.agency_id = c.agency_id
            WHERE a.agency_name LIKE ? OR SOUNDEX(a.agency_name) = SOUNDEX(?)
            OR  a.amadeus_customer_no=?
            GROUP BY a.agency_id, a.agency_name, a.amadeus_customer_no, a.office_no, a.province_state, a.city, a.post_code, c.start_date, c.payout_period, c.contract_status_id
        ) AS T
        ORDER BY CustomerNumber ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchTermWithWildcard, $searchTerm, $customerId);
     $stmt->execute();
    $result = $stmt->get_result();
}else if ($market !== '') {
    $sql = "SELECT agencyId, AgencyName, Market, Country, CustomerNumber, OfficeNumber, State, City, PostCode, CONCAT(UnpaidCount, ' payouts unpaid (', PeriodDate, ' ) ') AS TotalUnpaid, CONCAT(ExpiredDays, ' days') AS TotalExpiry, Status
    FROM (
        SELECT a.agency_id As agencyId, a.agency_name AS AgencyName, a.market As Market, a.region_country as Country, a.amadeus_customer_no AS CustomerNumber, a.office_no AS OfficeNumber, a.province_state AS State, a.city AS City, CONCAT(a.province_state, ' ', a.post_code) AS PostCode, CONCAT( DATE_FORMAT(c.start_date, '%b %y'), ' - ', DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y')) AS PeriodDate, SUM(CASE WHEN b.payout_status = 0 THEN 1 ELSE 0 END) AS UnpaidCount, DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y') AS PeriodEndDate, TIMESTAMPDIFF(DAY, CURDATE(), DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH)) AS ExpiredDays, c.contract_status_id AS Status
        FROM ata_db.agency a
        JOIN ata_db.segments b ON a.agency_id = b.agency_id
        JOIN ata_db.contract c ON a.agency_id = c.agency_id
        WHERE a.market = ?
        GROUP BY a.agency_id, a.agency_name, a.amadeus_customer_no, a.office_no, a.province_state, a.city, a.post_code, c.start_date, c.payout_period, c.contract_status_id
    ) AS T
    ORDER BY CustomerNumber ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $market);
    $stmt->execute();
    $result = $stmt->get_result();
} else if($country !==''){
    $sql = "SELECT agencyId, AgencyName, Market, Country, CustomerNumber, OfficeNumber, State, City, PostCode, CONCAT(UnpaidCount, ' payouts unpaid (', PeriodDate, ' ) ') AS TotalUnpaid, CONCAT(ExpiredDays, ' days') AS TotalExpiry, Status
    FROM (
        SELECT a.agency_id As agencyId, a.agency_name AS AgencyName, a.market As Market, a.region_country as Country, a.amadeus_customer_no AS CustomerNumber, a.office_no AS OfficeNumber, a.province_state AS State, a.city AS City, CONCAT(a.province_state, ' ', a.post_code) AS PostCode, CONCAT( DATE_FORMAT(c.start_date, '%b %y'), ' - ', DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y')) AS PeriodDate, SUM(CASE WHEN b.payout_status = 0 THEN 1 ELSE 0 END) AS UnpaidCount, DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y') AS PeriodEndDate, TIMESTAMPDIFF(DAY, CURDATE(), DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH)) AS ExpiredDays, c.contract_status_id AS Status
        FROM ata_db.agency a
        JOIN ata_db.segments b ON a.agency_id = b.agency_id
        JOIN ata_db.contract c ON a.agency_id = c.agency_id
        WHERE a.region_country = ?
        GROUP BY a.agency_id, a.agency_name, a.amadeus_customer_no, a.office_no, a.province_state, a.city, a.post_code, c.start_date, c.payout_period, c.contract_status_id
    ) AS T
    ORDER BY CustomerNumber ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $country);
    $stmt->execute();
    $result = $stmt->get_result();
}
else if($status !==''){
    $sql = "SELECT agencyId, AgencyName, Market, Country, CustomerNumber, OfficeNumber, State, City, PostCode, CONCAT(UnpaidCount, ' payouts unpaid (', PeriodDate, ' ) ') AS TotalUnpaid, CONCAT(ExpiredDays, ' days') AS TotalExpiry, Status
    FROM (
        SELECT a.agency_id As agencyId, a.agency_name AS AgencyName, a.market As Market, a.region_country as Country, a.amadeus_customer_no AS CustomerNumber, a.office_no AS OfficeNumber, a.province_state AS State, a.city AS City, CONCAT(a.province_state, ' ', a.post_code) AS PostCode, CONCAT( DATE_FORMAT(c.start_date, '%b %y'), ' - ', DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y')) AS PeriodDate, SUM(CASE WHEN b.payout_status = 0 THEN 1 ELSE 0 END) AS UnpaidCount, DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y') AS PeriodEndDate, TIMESTAMPDIFF(DAY, CURDATE(), DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH)) AS ExpiredDays, c.contract_status_id AS Status
        FROM ata_db.agency a
        JOIN ata_db.segments b ON a.agency_id = b.agency_id
        JOIN ata_db.contract c ON a.agency_id = c.agency_id
        WHERE c.contract_status_id = ?
        GROUP BY a.agency_id, a.agency_name, a.amadeus_customer_no, a.office_no, a.province_state, a.city, a.post_code, c.start_date, c.payout_period, c.contract_status_id
    ) AS T
    ORDER BY CustomerNumber ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
}
else {
    $sql = "SELECT agencyId, AgencyName, Market, Country, CustomerNumber, OfficeNumber, State, City, PostCode, CONCAT(UnpaidCount, ' payouts unpaid (', PeriodDate, ' ) ') AS TotalUnpaid, CONCAT(ExpiredDays, ' days') AS TotalExpiry, Status
        FROM (
            SELECT a.agency_id As agencyId, a.agency_name AS AgencyName, a.market As Market, a.region_country as Country, a.amadeus_customer_no AS CustomerNumber, a.office_no AS OfficeNumber, a.province_state AS State, a.city AS City, CONCAT(a.province_state, ' ', a.post_code) AS PostCode, CONCAT( DATE_FORMAT(c.start_date, '%b %y'), ' - ', DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y')) AS PeriodDate, SUM(CASE WHEN b.payout_status = 0 THEN 1 ELSE 0 END) AS UnpaidCount, DATE_FORMAT(DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH), '%b %y') AS PeriodEndDate, TIMESTAMPDIFF(DAY, CURDATE(), DATE_ADD(c.start_date, INTERVAL c.payout_period MONTH)) AS ExpiredDays, c.contract_status_id AS Status
            FROM ata_db.agency a
            JOIN ata_db.segments b ON a.agency_id = b.agency_id
            JOIN ata_db.contract c ON a.agency_id = c.agency_id
            GROUP BY a.agency_id, a.agency_name, a.amadeus_customer_no, a.office_no, a.province_state, a.city, a.post_code, c.start_date, c.payout_period, c.contract_status_id
        ) AS T
    ORDER BY CustomerNumber ASC";
    

     $result = $conn->query($sql);
}

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
