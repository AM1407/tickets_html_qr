<?php
// 3 function call possibilities;
// Number ONE (Ready player one)
function printPDF() {
    echo "Hello world";
}
?>
<form action="" method="post">
    <button type="submit" name="MyButton">PDF Click here if you dare</button>
</form>

<?php
if (isset($_POST['MyButton'])) {
    printPDF();
}
?>

<?php
// Number TWO - The one most similar to JS - AKA AJAX
$id = 12;
?>
<button onclick="callPHP()">Click here</button>
<script>
    function callPHP() {
        fetch('ajaxscript.php?id=<?php echo $id?>').then(res => res.text()).then(
            data => console.log(data);
        );
    }
</script>


<?php
// Number THREE - The Do Something Action thingie
?>
<a href ="myscript.php?action=doSomething">click here</a>

<?php
// myscript.php
if (isset($_GET['action'])) {
    myFuntion();
}