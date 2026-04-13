<?php
require 'vendor/autoload.php';
$client=new MongoDB\Client("mongodb://localhost:27017");
$db=$client->parking_system;
$collection=$db->slots;
if ($collection->countDocuments()==0) {
    for ($i=1; $i <=20; $i++) {
        $collection->insertOne([
            'slot' => $i,
            'status'=> ($i <= 10 ? 'available' : 'occupied'),
            'type'=> ($i <= 8 ? 'AC' : 'Non-AC')
        ]);
    }
}
if (isset($_GET['action'])) {
    $slot=(int)$_GET['slot'];
    if ($_GET['action']=="book") {
        $collection->updateOne(
            ['slot' => $slot],
            ['$set' => ['status' => 'occupied']]
        );
    }
    if ($_GET['action']=="cancel") {
        $collection->updateOne(
            ['slot' => $slot],
            ['$set' => ['status' => 'available']]
        );
    }
    header("Location: smart_parking_mongo.php");
}
// FETCH DATA
$slots=$collection->find([], ['sort' => ['slot' => 1]]);
?>
<!DOCTYPE html>
<html>
<head>
<title>Smart Parking (MongoDB)</title>
<style>
body { font-family: Arial; text-align:center; }
.slots {
    display:grid;
    grid-template-columns:repeat(5,80px);
    gap:10px;
    justify-content:center;
}
.slot {
    padding:15px;
    color:white;
    border-radius:5px;
}
.available { background:green; }
.occupied { background:red; }
a { color:white; text-decoration:none; }
</style>
</head>
<body>
<h2>🚗 Smart Parking System (MongoDB)</h2>
<div class="slots">
<?php foreach ($slots as $s): ?>
    <div class="slot <?php echo $s['status']; ?>">
        <?php echo "S" . $s['slot']; ?><br>
        <?php echo $s['type']; ?><br>
        <?php if ($s['status'] == "available"): ?>
            <a href="?action=book&slot=<?php echo $s['slot']; ?>">Book</a>
        <?php else: ?>
            <a href="?action=cancel&slot=<?php echo $s['slot']; ?>">Cancel</a>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>
</body>
</html>