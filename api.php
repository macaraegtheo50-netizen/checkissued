<?php
$pdo = new PDO("mysql:host=localhost;dbname=check_registry", "root", "");

$action = $_GET['action'] ?? '';

if ($action == 'fetch') {
    $stmt = $pdo->prepare("SELECT * FROM checks WHERE fund = ? ORDER BY date_issued DESC");
    $stmt->execute([$_GET['fund']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == 'save') {
    $d = json_decode(file_get_contents('php://input'), true);
    if (!empty($d['id'])) {
        $sql = "UPDATE checks SET date_issued=?, check_no=?, payee=?, particulars=?, amount=?, status=? WHERE id=?";
        $pdo->prepare($sql)->execute([$d['date'], $d['check'], $d['payee'], $d['particulars'], $d['amount'], $d['status'], $d['id']]);
    } else {
        $sql = "INSERT INTO checks (fund, date_issued, check_no, payee, particulars, amount, status) VALUES (?,?,?,?,?,?,?)";
        $pdo->prepare($sql)->execute([$d['fund'], $d['date'], $d['check'], $d['payee'], $d['particulars'], $d['amount'], $d['status']]);
    }
}

if ($action == 'delete') {
    $pdo->prepare("DELETE FROM checks WHERE id = ?")->execute([$_GET['id']]);
}
?>