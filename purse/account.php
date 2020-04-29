<?
include 'common/variables.php';
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?include 'common/html_head.php'?>
</head>
<body>
    <?php include 'common/navbar.php'?>
    <div class="container">
        <div class="card white" style="margin: auto; margin-top: 2em; max-width: 600px; border-radius: 6px">
            <div class="card-content grey-text text-darken-4">
                <span class="card-title"><?=$greeting_text?>, <?=$_SESSION["username"]?>.</span>
                <p><?=$ballance_text?>: 0</p>
            </div>
            <div class="card-action">
                <a href="#"><?=$topup_text?></a>
                <a href="logout.php"><?=$logout_text?></a>
            </div>
        </div>
        
        <div class="card white" style="margin: auto; margin-top: 2em; max-width: 600px; border-radius: 6px">
            <div class="card-content grey-text text-darken-4">
                <span class="card-title"><?=$send_text?></span>
                <div class="my_inner_container">
                <form method="POST" action="send_processor.php">
                    <div class="input-field">
                        <input id="receiver_input_field" name="receiver" type="text" class="validate">
                        <label for="receiver_input_field"><?=$receiver_text?></label>
                    </div>
                    <div class="input-field">
                        <input id="amount_input_field" name="amount" type="number" min="0" step="0.001" class="validate">
                        <label for="amount_input_field"><?=$amount_text?></label>
                    </div>
                    
                    <button class="btn waves-effect waves-light" type="submit" name="action"><?=$send_text?>
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
        </div>
        
        <div class="card white" style="margin: auto; margin-top: 2em; max-width: 600px; border-radius: 6px">
            <div class="card-content grey-text text-darken-4">
                <span class="card-title"><?=$transaction_history_text?></span>
            </div>
            <div class="card-action">
                <a href="#"><?=$transaction_history_delete_text?></a>
            </div>
        </div>
        
        </div>
    <?php include 'common/footer.php'?>
</body>
</html>