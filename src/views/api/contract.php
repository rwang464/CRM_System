<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $mysql_database = "ata_db";
    
    $conn = new mysqli($servername, $username, $password);


    $sql = "SELECT a.agency_name, 
            a.agency_id,
            a.amadeus_customer_no, 
            b.start_date, 
            b.end_date, 
            b.payout_period, 
            c.amadeus_base_rate,
            c.amadeus_intl_rate,
            c.amadeus_commitment_pct,
            c.amadeus_total_GDSseg,
            d.contract_type_name
            FROM agency a 
            JOIN contract b ON a.agency_id = b.agency_id
            JOIN contract_amadeus c ON b.contract_id = c.contract_id
            JOIN contract_type d ON d.contract_type_id = b.contract_type_id";


    $response = [
        'status' => 200,
        'msg' => 'Success',
        'code' => 20000,
        'data' => []
    ];

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    if (strtoupper($requestMethod) == 'GET') {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response['data'][] = $row;
            }
        } else {
            $response['msg'] = '';
            $response['code'] = 30000;
            $response['data'] = [];
        };
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);

        $conn->close();

    }else if (strtoupper($requestMethod) == 'POST') {
        try{

            $_POST = json_decode(file_get_contents("php://input"), true);
            // var_dump( $_POST);
            // 
            $insert_constract = 'insert into contract(agency_id,start_date,end_date,payout_period)
            values("'. $_POST['agency_id'].'","'. $_POST['start_date'].'","'. $_POST['end_date'].'","'.$_POST['paid_every'].'")';
            
            $conn->query($insert_constract);
            $id = $conn->insert_id;
            
            if( isset( $_POST['gds'])){
                $sql = "";
                if($_POST['gds'] =='Amadeus'){
                    // us
                    if($_POST['contract_type'] == "1"){
                        $sql='insert into contract_amadeus (amadeus_intl_rate,contract_id,amadeus_base_rate,amadeus_total_GDSseg,amadeus_commitment_pct,
                        ATA_contract_requested_date,ATA_contract_sent_date,ATA_contract_signed_date,Amadeus_contract_requested_date,Amadeus_docusign_sent_date
                        ,Amadeus_docusign_signed_date,Amadeus_install_received_date,ATID_installation_received_date,pro_printer_complete_date,Amadeus_notified_date)
                        values(
                         "'.$_POST['inter_rate'].'","'.$id.'", "'.$_POST['domes_rate'].'","'.$_POST['total_gds'].'","'.$_POST['commitment_percentage'].'"
                        ,"'.$_POST['ATA_contract_requested_date'].'","'.$_POST['ATA_contract_sent_date'].'","'.$_POST['ATA_contract_signed_date'].'","'.$_POST['docusign_requested_date'].'"
                        ,"'.$_POST['docusign_sent_date'].'","'.$_POST['docusign_signed_date'].'","'.$_POST['Amadeus_install_received_date'].'","'.$_POST['Amadeus_ATID_installation_received_date'].'"
                        ,"'.$_POST['Amadeus_pro_printer_complete_date'].'","'.$_POST['Amadeus_notified_date'].'")';
                    }else{
                        $sql='insert into contract_amadeus (contract_id,amadeus_base_rate,amadeus_total_GDSseg,amadeus_commitment_pct,ATA_contract_requested_date
                        ,ATA_contract_sent_date,ATA_contract_signed_date,Amadeus_contract_requested_date,Amadeus_docusign_sent_date,Amadeus_docusign_signed_date
                        ,Amadeus_install_received_date,ATID_installation_received_date,pro_printer_complete_date,Amadeus_notified_date)
                        values("'.$id.'", "'.$_POST['base_rate'].'","'.$_POST['total_gds'].'","'.$_POST['commitment_percentage'].'","'.$_POST['ATA_contract_requested_date'].'","'.$_POST['ATA_contract_sent_date'].'"
                        ,"'.$_POST['ATA_contract_signed_date'].'","'.$_POST['docusign_requested_date'].'","'.$_POST['docusign_sent_date'].'","'.$_POST['docusign_signed_date'].'"
                        ,"'.$_POST['Amadeus_install_received_date'].'","'.$_POST['Amadeus_ATID_installation_received_date'].'"
                        ,"'.$_POST['Amadeus_pro_printer_complete_date'].'","'.$_POST['Amadeus_notified_date'].'")';
                    }
                    // $conn->query($sql);
                }else if($_POST['gds'] =='Vacation'){
                    $sql='insert into contract_vacation (contract_id,vacation_sign_date,vacation_payment_cycle)
                    values("'.$id.'","'.$_POST['vacation_sign_date'].'","'.$_POST['vacation_payment_cycle'].'")';
                    // echo  $sql;
                    // die;
                }else if($_POST['gds'] =='Sirev'){

                }else if($_POST['gds'] =='Air'){

                }else if($_POST['gds'] =='Hotel'){
                }
                if(isset($sql)){
                    $conn->query($sql);
                }
            }
            $conn->close();
            // $response['data'] = $id;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }catch(Exception $ex){
            $response['msg'] = $ex->getMessage();
            $response['code'] =400;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }

    }else if (strtoupper($requestMethod) == 'PUT') {
    //    $sql =' update set aaa='aaa' where id = $_POST["id"]';

    }else if(strtoupper($requestMethod) == 'DELETE') {
        //
    }

?>