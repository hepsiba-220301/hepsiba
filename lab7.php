<?php
session_start();
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: google_firebase_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Google Login + Firebase</title>
    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js"></script>
    <!-- Google Identity -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        body { font-family: Arial; text-align:center; margin-top:100px; }
        button { padding:10px 15px; margin-top:10px; }
    </style>
</head>
<body>
<h2>🔐 Social Login (Google + Firebase)</h2>
<?php if(isset($_SESSION['user'])): ?>
    <h3>Welcome <?php echo $_SESSION['user']; ?></h3>
    <a href="?logout=true"><button>Logout</button></a>
<?php else: ?>
    <!-- Google Button -->
    <div id="g_id_onload"
        data-client_id="YOUR_GOOGLE_CLIENT_ID"
        data-callback="handleCredentialResponse">
    </div>
    <div class="g_id_signin" data-type="standard"></div>
<?php endif; ?>
<script>
const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT.firebaseapp.com",
};
firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();
function handleCredentialResponse(response) {
    let user =parseJwt(response.credential);
    fetch("", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(user)
    }).then(()=>location.reload());
}
function parseJwt (token) {
    let base64Url=token.split('.')[1];
    let base64=base64Url.replace(/-/g, '+').replace(/_/g, '/');
    let jsonPayload=decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
    return JSON.parse(jsonPayload);
}
</script>
</body>
</html>
<?php
$data = json_decode(file_get_contents("php://input"), true);

if($data){
    $_SESSION['user'] = $data['name'];
}
?>