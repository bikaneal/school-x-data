

<html>
    <head>
        <title>Validity check</title>
    </head>

    <body style="text-align:center;">

        <h1 style='color:red'>
            let us check...</h1>
                <br>
                hm...
                <br>
                <br> 
                <br>
                <h2>the validity of the 
                card number 
                you are about to enter!</h2>
        <br>
        <br>
        <br>
        <form action="" method="POST">

            credit card number:

            <?php

            $submitbutton= $_POST['submitbutton'];

            $number= $_POST['number_entered'];

            $number = preg_replace('/\D/', '', $number);

            ?>
            
            <input type="text" name="number_entered" value='<?php if ($submitbutton) { echo "$number";} ?>'/> 

            <br>
            <br>

            <?php 

            function luhn_check($number) {

            
                // Set the string length and parity
                $number_length=strlen($number);
                $parity=$number_length % 2;
            
                // Loop through each digit and do the maths
                $total=0;
                for ($i=0; $i<$number_length; $i++) {
                $digit=$number[$i];
                // Multiply alternate digits by two
                if ($i % 2 == $parity) {
                    $digit*=2;
                    // If the sum is two digits, add them together (in effect)
                    if ($digit > 9) {
                    $digit-=9;
                    }
                }
                // Total up the digits
                $total+=$digit;
                }
            
                // If the total mod 10 equals 0, the number is valid
                return ($total % 10 == 0) ? TRUE : FALSE;
            
            }

            function validate($number)
            {
                global $type;

                $cardtype = array(
                    'VISA' => '/^4\d{12}(\d{3})?$/',
                    'MASTERCARD' => '/^5[1-5]\d{14}$/',
                    'AMEX' => '/^3(4|7)\d{13}$/',
                    'MAESTRO' => '/^(5020|5038|6304|6759|6761)\d{12}(\d{2,3})?$/',
                    'MIR' => '/^2200\d{12}(\d{3})?$/'
                );

                if (preg_match($cardtype['VISA'],$number))
                {
                $type= "VISA";
                    return '$number -> VISA';
                
                }
                else if (preg_match($cardtype['MASTERCARD'],$number))
                {
                $type= "MASTERCARD";
                    return 'MASTERCARD';
                }
                else if (preg_match($cardtype['AMEX'],$number))
                {
                $type= "AMEX";
                    return 'AMEX';
                
                }
                else if (preg_match($cardtype['MAESTRO'],$number))
                {
                $type= "MAESTRO";
                    return 'MAESTRO';
                }
                else if (preg_match($cardtype['MIR'],$number))
                {
                $type= "MIR";
                    return 'MIR';
                }
                else
                {
                    return false;
                } 
            }

            

            validate($number);

            if ($submitbutton)
            {
            if ((validate($number) !== false) && (luhn_check($number) !== false)) {

            echo "<p style='color:green;'> $type is detected by alexander li. credit card number is valid.</p>";
            }
            else
            {
            echo "<p style='color:red;'> alexander li thinks the card number is invalid.</p>";
            }
            }
            ?>
            
            <br><br>
            
            <input type="submit" value="Submit" name="submitbutton"/>            
            
        </form>
    </body>
</html>