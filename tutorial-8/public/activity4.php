<!DOCTYPE HTML>
<html>
<head>
  <title>Activity 4</title>
  <style>
    .error { color: red; }
  </style>
</head>
<body>

<?php
// defining variables and setting it to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Name validation
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = $_POST["name"];
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }

  // Email validation
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  // Website validation
  if (!empty($_POST["website"])) {
    $website = $_POST["website"];
    if (!filter_var($website, FILTER_VALIDATE_URL)) {
      $websiteErr = "Invalid URL format";
    }
  }

  // Comment validation
  if (!empty($_POST["comment"])) {
    $comment = $_POST["comment"];
  }

  // Gender validation
  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = $_POST["gender"];
  }
}
?>
<h2>Form</h2>
<form method="post">
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  Website: <input type="text" name="website" value="<?php echo $website;?>">
  <span class="error"><?php echo $websiteErr;?></span>
  <br><br>
  Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
  Gender:
  <input type="radio" name="gender" value="female" <?php if ($gender=="female") echo "checked";?>>Female
  <input type="radio" name="gender" value="male" <?php if ($gender=="male") echo "checked";?>>Male
  <input type="radio" name="gender" value="other" <?php if ($gender=="other") echo "checked";?>>Other
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
