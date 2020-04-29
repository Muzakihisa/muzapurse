<?include 'common/variables.php';
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: account.php");
    exit;
}
?>
<?include 'common/html_head.php'?>
</head>
<body>
    <div class="container" style="height: 100px;">
        <h2 style="margin-top: 15%"><b><?=$page_name?></b></h2>
        <h4><?=$page_description?></h4>
        <p style="margin-top: 2em"><i>"<?=$index_page_decorative_text_1?>" <b>-<?=$index_page_decorative_text_2?></b></i></p>
        <div style="margin-top: 2em">
            <a href="login.php" class="waves-effect waves-light btn"><i class="material-icons left">account_box</i><?=$login_link_text?></a>
            <a href="register.php" class="waves-effect waves-light btn"><i class="material-icons left">add_box</i><?=$register_link_text?></a>
        </div>
    </div>
</body>
</html>