    <?php
    class Validator {
        
        // Validate if the input is not empty
        public function validateRequired($input) {
            return !empty(trim($input));
        }

        // Validate email
        public function validateEmail($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }

        // Validate if the input is a valid integer
        public function validateInteger($input) {
            return filter_var($input, FILTER_VALIDATE_INT) !== false;
        }

        // Validate string length
        public function validateStringLength($input, $minLength = 0, $maxLength = PHP_INT_MAX) {
            $length = strlen(trim($input));
            return $length >= $minLength && $length <= $maxLength;
        }

        // Sanitize string input
        public function sanitizeString($input) {
            return filter_var($input, FILTER_SANITIZE_STRING);
        }

        // Sanitize email input
        public function sanitizeEmail($email) {
            return filter_var($email, FILTER_SANITIZE_EMAIL);
        }

        // Sanitize integer input
        public function sanitizeInteger($input) {
            return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        }

        // Sanitize URL input
        public function sanitizeURL($url) {
            return filter_var($url, FILTER_SANITIZE_URL);
        }

        // Custom validation for allowed values
        public function validateAllowedValues($input, $allowedValues) {
            return in_array($input, $allowedValues);
        }

        // Custom validation for regex pattern
        public function validatePattern($input, $pattern) {
            return preg_match($pattern, $input);
        }

        public function validateAlphabetic($input) {
            return preg_match('/^[a-zA-Z\s]+$/', $input);
        }
    
        public function validatePhoneNumber($phone) {
            // Basic phone number validation (adjust regex as needed)
            return preg_match('/^[0-9]{10,15}$/', $phone);
        }
    
        public function validateDate($date, $format = 'Y-m-d') {
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) === $date;
        }
    
        public function validateFutureDate($date, $format = 'Y-m-d') {
            $d = DateTime::createFromFormat($format, $date);
            $now = new DateTime();
            return $d > $now;
        }
    
        public function validateDateRange($date, $format, $startDate, $endDate) {
            $d = DateTime::createFromFormat($format, $date);
            $start = DateTime::createFromFormat($format, $startDate);
            $end = DateTime::createFromFormat($format, $endDate);
            return $d >= $start && $d <= $end;
        }
    }
    ?>
