<?php

function sanitizeString($string) {
    return trim(htmlspecialchars(filter_var($string, FILTER_SANITIZE_STRING))); 
}

function generateFakePassword() {
    return password_hash(random_bytes(128), PASSWORD_BCRYPT);
}

function validateCPF($cpf) {

    // Verify if it now has a correct lenght and check 
    // for a sequency of equal numbers, eg: 111.111.111-11
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Do the math to validade the CPF
    // for ($t = 9; $t < 11; $t++) {
    //     for ($d = 0, $c = 0; $c < $t; $c++) {
    //         $d += $cpf[$c] * (($t + 1) - $c);
    //     }
    //     $d = ((10 * $d) % 11) % 10;
    //     if ($cpf[$c] != $d) {
    //         return false;
    //     }
    // }
    return true;
}

function validatePassword($password) {
    // Check if the password has at least 6 characters, one capital letter and one number
    return preg_match('/^(?=.*[A-Z])(?=.*\d).{6,}$/', $password);
}
