<?php
    
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo "<a href='../public/views/login.php'>Voltar</a>";
        exit('Form not submited.');
    }
    
    session_start();

    require('db/connect.php');
    require('functions.php');

    $order = (int)sanitizeString($_POST['order']);

    if (empty($order) || !is_numeric($order)) {
        exit('Order not valid.');
    }

    $query = "SELECT * FROM eq3.orders 
            WHERE fk_user = :session_id AND id_order = :order AND status_order LIKE 'AGUARDANDO%'";
    $stmt = $conn -> prepare($query);
    $stmt -> bindParam(':session_id', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindParam(':order', $order);
    $stmt -> execute();
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        exit('Order not found.');
    } else {
        $tracknum = bin2hex(random_bytes(8));

        $query = "UPDATE eq3.orders 
                SET status_order = 'PAGO ".translateDate($result['date_order'])."', track_order = :tracknum 
                WHERE id_order = :order AND status_order LIKE 'AGUARDANDO%'";
        $stmt = $conn -> prepare($query);
        $stmt -> bindParam(':tracknum', $tracknum);
        $stmt -> bindParam(':order', $order);
        $stmt -> execute();
        
        if ($stmt -> rowCount() > 0) {
            echo "Order ".$order." Paid!";
        } else {
            echo "Order not paid!<br>";
        }
    }
