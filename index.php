<?php
  $billText=0;
  $tipOpt=0;
  $customField=0;
  $splitField=1;
  if (isset($_POST['bill'])) {
    $billText=htmlspecialchars($_POST['bill']);
  }
  if (isset($_POST['tipSelected'])) {
    $tipOpt=(float)$_POST['tipSelected'];
  }
  if (isset($_POST['custom_pcent'])) {
    $customField=htmlspecialchars($_POST['custom_pcent']);
  }
  if (isset($_POST['split_cnt'])) {
    $splitField=(int)$_POST['split_cnt'];
  }

?>
<html>
  <head>
    <title>Tiply</title>
    <style type="text/css">
      body {
        background-color: lightblue;
      }

      h2 {
        text-align: center;
        color: steelblue;
      }

      .content {
        background-color: white;
        width: 250px;
        margin: auto;
        height: auto;
        border: 1px solid black;
        padding: 15px;
      }

      .textfield {
        width: 100px;
      }

      .textfield_small {
        width: 30px;
      }

      .result_style {
        padding: 10px;
        border: 1px solid red;
      }

    </style>
  </head>

  <body>
    <div class="content">
    <h2>Tip Calculator</h2>
    <form method="post">
      <p>Bill Amount: $<input type="text" name="bill"
      value="<?php echo "$billText"; ?>" class="textfield"/></p>
      <p>Tip percentage:</p>

      <?php
        $tipAmount = array(0.15, 0.17, 0.20, 1);
        $tipLabel = array("15%", "17%", "20%", "Custom:");
        for ($i=0; $i<4; $i++) {
          if ($i==3) {
            echo "<br />";
          }
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
    <input type="text" name="custom_pcent" value="<?php echo "$customField"; ?>"
    class="textfield_small"/>%
    <p>Split: <input type="text" name="split_cnt" 
      value="<?php echo"$splitField" ?>" class="textfield_small"/> person(s)</p>
    <div style="text-align:center">
      <input type="submit" name="submit_btn" />
    </div>
    </form>

    <?php
      $billInt=(float)$billText;
      $isCustomValid=true;
      if ($tipOpt==1 && $customField<=0) {
        $isCustomValid=false;
      }
      if (is_numeric($billText) && $billInt>0 && $tipOpt!=0 
          && $splitField>0 && $isCustomValid) {
        echo "<div class='result_style'>";
        if ($tipOpt==1) {
          $tipOpt=(float)$customField / 100;
        }
        $tipAmt=$billInt*$tipOpt;
        $total=$billInt + $tipAmt;
        
        echo "<p>Tip: $" . number_format($tipAmt, 2, '.', ',') . "</p>";
        echo "<p>Total: $" . number_format($total, 2, '.', ',') . "</p>";

        if ($splitField != 1) {
          $tipEach=$tipAmt/$splitField;
          $totalEach=$total/$splitField;

          echo "<p>Tip Each: $" . number_format($tipEach, 2, '.', ',') . "</p>";
          echo "<p>Total Each: $" . number_format($totalEach, 2, '.', ',') . "</p>";
        }
        echo "</div>";
      }
      else if (isset($_POST['submit_btn'])) {
        echo "<div class='result_style'>";
        if (!is_numeric($billText)) {
          echo "<p>Please input a number for the bill amount.</p>";
        }
        if ($billInt <= 0) {
          echo "<p>Please input a bill amount greater than 0.</p>";
        }
        if ($tipOpt == 0) {
          echo "<p>Please select a tip percentage.</p>";
        }
        if (!$isCustomValid) {
          if (!is_numeric($customField)) {
            echo "<p>Please input a number for the custom percentage.</p>";
          }
          echo "<p>Please enter a custom percentage above 0.</p>";
        }
        if ($splitField == 0) {
          echo "<p>Please split the bill with 1+ people.</p>";
        }
        echo "</div>";
      }
    ?>
    </div>
  </body>
</html>
