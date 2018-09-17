<?php
require_once "../vendor/paragonie/random_compat/lib/random.php";
try {
    $string = random_bytes(32);
} catch (TypeError $e) {
    // Well, it's an integer, so this IS unexpected.
    die("An unexpected error has occurred");
} catch (Error $e) {
    // This is also unexpected because 32 is a reasonable integer.
    die("An unexpected error has occurred");
} catch (Exception $e) {
    // If you get this message, the CSPRNG failed hard.
    die("Could not generate a random string. Is our OS secure?");
}

echo substr(bin2hex($string),-6);
?>
