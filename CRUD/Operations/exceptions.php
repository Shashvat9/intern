<?php

//all the error code for this class will have a prefix of 1
//101 -> Error creating entry
//102 -> Error creating table
class CreateExeption extends Exception {
    public function __construct($message = "Error creating entry", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
//all the error code for this class will have a prefix of 2
//201 -> Error reading entry
//202 -> Error reading table
class ReadExeption extends Exception {
    public function __construct($message = "Error reading entry", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

//all the error code for this class will have a prefix of 3
//301 -> Error updating entry
class UpdateExeption extends Exception {
    public function __construct($message = "Error updating entry", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

//all the error code for this class will have a prefix of 4
//401 -> Error deleting entry
class DeleteExeption extends Exception {
    public function __construct($message = "Error deleting entry", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

//all the error code for this class will have a prefix of 5
//501 -> There is no name of Collum names provided in the arguments.
//502 -> Operation not found
//503 -> Operation not found for Post method
//504 -> unkonwn exeption
class GeneralExeption extends Exception {
    public function __construct($message = "General Error", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
