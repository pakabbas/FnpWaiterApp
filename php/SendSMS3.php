
<?php
        require_once '/vendor/autoload.php';
      use telesign\enterprise\sdk\verify\VerifyClient;

    
        $customer_id = '9F70BA09-6F5A-4FEC-BC39-C6397206EA75';
        $api_key = "Q59vZP17Vfz1gLB2sYqXTmdz7uxfP16hGwfEKO72r5HiIhJbWWf6e60/OeoyvnI3nuYyhFVAFCLS94A5rxExsg==";
      $phone_number = getenv('PHONE_NUMBER') ?? '17345893503';
      $verify_code ='12345';
      $verify_client = new VerifyClient($customer_id, $api_key);
      $response = $verify_client->sms($phone_number, [ "verify_code" => $verify_code, "sender_id" => "6363297650" ]);
      echo("\nResponse HTTP status:\n");
      print_r($response->status_code);
      echo("\nResponse body: \n");
      print_r($response->json);
      echo "Please enter the verification code you were sent: ";
      $user_entered_verify_code = rtrim(fgets(STDIN));
      if ($user_entered_verify_code == $verify_code) {
        echo "Your code is correct.\n";
      } else {
        echo "Your code is incorrect.\n";
      }
      ?>
    