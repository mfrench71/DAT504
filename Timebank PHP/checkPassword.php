<?php

    require_once 'functions.php';

    // Check password strength

    function detect_upper_case ($string) {
        // True if 'strtolower' changes string i.e. it contained UPPERCASE characters
        return strtolower($string) != $string;
    }

    function detect_lower_case ($string) {
        // True if 'strtoupper' changes string i.e. it contained lowercase characters
        return strtoupper($string) != $string;
    }

    function countNumbers($string) {
        // Return the number of numbers in the password
        return preg_match_all('/[0-9]/', $string);
    }

    function countSymbols($string) {
        // Return the number of symbols in the password
        // Escape regex symbols to get their literal values
        $regex = '/[' . preg_quote('!@#$%^&*-_+=?') . ']/';
        return preg_match_all($regex, $string);
    }

    function password_strength($password) {
        
        // Set initial strength value
        $strength = 0;
        
        // Strongest password achieves this number of points
        $possiblePoints = 12;
        
        // Length of password
        $length = strlen($password);

        // Add one point if password contains an upper case character
        if(detect_upper_case ($password)) {
            $strength +=1;
        }

        // Add one point if password contains a lower case character
        if(detect_lower_case ($password)) {
            $strength +=1;
        }

        // If numbers in password, add a maximum of two points to the strength rating
        $strength += min(countNumbers($password), 2);

        // If symbols in password, add a maximum of two points to the strength rating
        $strength += min(countSymbols($password), 2);

        if ($length >= 8) {
            // Add two points for a password of length of 8 characters or more
            $strength += 2;
            // Add half a point for each character over 8 characters with a maximum of four points
            $strength += min(($length - 8) * 0.5, 4);
        }

        $strengthPercent = $strength / (float) $possiblePoints; 
        $rating = floor($strengthPercent * 10);
        return $rating;
    }

    if (isset($_POST['password'])) {
        $password = cleanString($_POST['password']);    
    } else {
        $password = "";
    }

    $rating = password_strength($password);

?>

<div class="my-notify-info">Your password rating is: <?php echo $rating; ?>.</div>
<div id ="meter">
    <?php
       for ($i = 0; $i < 10; $i++) {
           echo "<div";
           if ($rating > $i) {
               echo " class=\"rating-{$rating}\"";
           }
           echo "></div>";
       }
    ?>
</div>
<br />
<br style="clear:both;"/>