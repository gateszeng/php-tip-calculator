<?php
  $billText=0;
  $tipOpt=0;
  if (isset($_POST['bill'])) {
    $billText=htmlspecialchars($_POST['bill']);
  }
  if (isset($_POST['tipSelected'])) {
      $tipOpt=(float)$_POST['tipSelected'];
  }

?>
<html>
  <head>
    <title>Tiply</title>
  </head>

  <body>
    <h2>Tip Calculator</h2>

    <form method="post">
      <p>Bill Amount: $<input type="text" name="bill"
      value="<?php echo "$billText"; ?>" /></p>
      <p>Tip percentage:</p>

      <?php
        $tipAmount = array(0.15, 0.17, 0.20);
        $tipLabel = array("15%", "17%", "20%");
        for ($i=0; $i<3; $i++) {

          if ($tipOpt == $tipAmount[$i]) {
      ?>
        <input type="radio" name="tipSelected" 
          value="<?php echo "$tipAmount[$i]"; ?>" checked /> 
        <?php } else { ?>
        <input type="radio" name="tipSelected" 
          value="<?php echo "$tipAmount[$i]"; ?>" /> 
        <?php } ?>
        <?php echo "$tipLabel[$i]"; ?>

      <?php
        }
      ?>

    <p><input type="submit" name="submit_btn"/></p>
    </form>

    <?php
      $billInt=(float)$billText;
      if (is_numeric($billText) && $billInt>0 && $tipOpt != 0) {
        $tipAmt = $billInt * $tipOpt;
        echo "<p>Tip: $" . number_format($tipAmt, 2, '.', ',') . "</p>";
        $total=$billInt + $tipAmt;
        echo "<p>Total: $" . number_format($total, 2, '.', ',') . "</p>";
      }
      else if (isset($_POST['submit_btn'])) {
        if (!is_numeric($billText)) {
          echo "<p>Please input a number for the bill amount</p>";
        }
        if ($billInt <= 0) {
          echo "<p>Please input a bill amount greater than 0</p>";
        }
        if ($tipOpt == 0) {
          echo "<p>Please select a tip percentage</p>";
        }
      }
    ?>

  </body>
</html>
