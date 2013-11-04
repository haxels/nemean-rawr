<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 10:33 PM
 */

    require_once 'Field.php';

    class Validator
    {
        private $fields;
        private $errors = array();

        const NAME      = 'NAME';
        const EMAIL     = 'EMAIL';
        const PASSWD    = 'PASSWD';
        const ZIPCODE   = 'ZIPCODE';
        const ADDRESS   = 'ADDRESS';
        const TLF       = 'TLF';
        const DATE      = 'DATE';
        const RDATE     = 'RDATE';
        const TIME      = 'TIME';
        const REQUIRED  = 'REQUIRED';
        const NUMBER    = 'NUMBER';


        public function __construct(array $fields = array())
        {
            $this->fields = $fields;
        }

        /**
         * Add a field to be validated to the validator
         * @param $name
         * @param $value
         * @param array $rules
         * @param array $opts
         */
        public function addField($name, array $rules = array(), array $opts = array())
        {
            $value = (isset($_GET[$name])) ? $_GET[$name] : (isset($_POST[$name])) ? $_POST[$name] : '';
            $this->fields[$name] = new Field($name, $value, $rules, $opts);
        }

        /**
         * Return an array of the fields to be validated
         * @return array
         */
        public function getFields()
        {
            return $this->fields;
        }

        public function getField($name)
        {
            return $this->fields[$name];
        }

        public function getFieldValue($name)
        {
            return $this->fields[$name]->getValue();
        }

        /**
         * Checks if there are any errors with any of the fields
         * @return bool
         */
        public function hasErrors()
        {
            return (count($this->errors) > 0) ? true : false;
        }

        /**
         * If there are any errors, this will return an array of them with the fieldname as key
         * @return array
         */
        public function getErrors()
        {
            return $this->errors;
        }

        public function setError($fieldName, $error)
        {
            $this->errors[$fieldName] = $error;
        }

        /**
         *
         */
        public function validate()
        {
            foreach($this->fields as $field)
            {
                foreach ($field->getRules() as $rule)
                {
                    switch ($rule)
                    {
                        case Validator::NAME:
                            $this->validateName($field->getName());
                            break;

                        case Validator::EMAIL:
                            $this->validateEmail($field->getName());
                            break;

                        case Validator::PASSWD:
                            $this->validatePassword($field->getName());
                            break;

                        case Validator::ZIPCODE:
                            $this->validateZipCode($field->getName());
                            break;

                        case Validator::TLF:
                            $this->validateTelephone($field->getName());
                            break;

                        case Validator::DATE:
                            $this->validateDate($field->getName());
                            break;

                        case Validator::TIME:
                            $this->validateTime($field->getName());
                            break;

                        case Validator::REQUIRED:
                           $this->validateRequired($field->getName());
                            break;

                        case Validator::NUMBER:
                            $this->validateNumber($field->getName());
                    }
                }
            }

        }

        /** Validation methods */

        /**
         * @param $field
         */
        private function validateOptions($field)
        {
            $opts = $field->getOpts();

            if(in_array('min', array_keys($opts)))
            {
                $ok  = $this->validateMinLength($field->getValue(), $opts['min']);

                if(!$ok)
                {
                    $this->errors[$field->getName()] = 'Input må bestå av minst '.$opts['min'].' tegn.';
                }
            }

            if(in_array('max', array_keys($opts)))
            {
                $ok  = $this->validateMaxLength($field->getValue(), $opts['max']);

                if(!$ok)
                {
                    $this->errors[$field->getName()] = 'Input kan ikke være lengre enn '.$opts['max'].' tegn';
                }
            }

            if (in_array('whitelist', array_keys($opts)))
            {
                $ok = $this->inArray($field->getValue(), $opts['whitelist']);

                if(!$ok)
                {
                    $this->errors[$field->getName()] = 'Input må være en gyldig kategori.';
                }
            }

            if (in_array('is_equal', array_keys($opts)))
            {
                $ok = $this->assertEqual($field->getValue(), $opts['is_equal']);

                if (!$ok)
                {
                    $this->errors[$field->getName()] = 'Inputtene må samsvare.';
                }
            }

            if (in_array('checkbox', array_keys($opts)))
            {
                $ok = $this->assertEqual($field->getValue(), $opts['checkbox']);

                if (!$ok)
                {
                    $this->errors[$field->getName()] = 'Input må være krysset av.';
                }
            }

            if (in_array('min_num', array_keys($opts)))
            {
                $ok = $this->validateMinNumber($field->getValue(), $opts['min_num']);

                if (!$ok)
                {
                    $this->errors[$field->getName()] = 'Input må være større enn eller lik '.$opts['min_num'];
                }
            }

            if (in_array('max_num', array_keys($opts)))
            {
                $ok = $this->validateMaxNumber($field->getValue(), $opts['max_num']);

                if (!$ok)
                {
                    $this->errors[$field->getName()] = 'Input må være mindre enn eller lik '.$opts['max_num'];
                }
            }

            if (in_array('min_max_num', array_keys($opts)))
            {
                $ok = $this->validateMinMaxNumber($field->getValue(), $opts['min_max_num'][0], $opts['min_max_num'][1]);

                if (!$ok)
                {
                    $this->errors[$field->getName()] = 'Input må være mellom '.$opts['min_max_num'][0]. ' og '.$opts['min_max_num'][1];
                }
            }


        }

        /**
         * @param $name
         */
        public function validateName($name)
        {
            $field = $this->fields[$name];

            if (is_array($field->getOpts()))
            {
                $this->validateOptions($field);
            }


            if (!preg_match("/^[A-ZÆØÅa-zæøå]+([- ][A-ZÆØÅa-zæøå]+)?$/", $field->getValue()))
            {
                $this->errors[$name] = 'Ugyldig navn.' ;
            }
        }

        public function validateEmail($name)
        {
            $field = $this->fields[$name];

            if (is_array($field->getOpts()))
            {
                $this->validateOptions($field);
            }

            if (!filter_var($field->getValue(), FILTER_VALIDATE_EMAIL))
            {
                $this->errors[$name] = 'Ugyldig e-post.';
            }
        }

        /**
         * @param $name
         */
        public function validatePassword($name)
        {
            $field = $this->fields[$name];

            if (is_array($field->getOpts()))
            {
                $this->validateOptions($field);
            }

            if(
                (   !preg_match("/^[A-Zֵa-z0-9]+$/" , $field->getValue()))            // numbers & digits only
                &&  !preg_match('[A-Zֵ]'            , $field->getValue())             // at least one upper case
                &&  !preg_match('[a-z]'            , $field->getValue())             // at least one lower case
                &&  !preg_match('[0-9]'            , $field->getValue()))            // at least one digit
            {
                $this->errors[$name] = 'Ugyldig passord. Passordet må bestå av minst 6 tegn og må bestå av minst et tall, en liten og en stor bokstav.';
            }
        }

        /**
         * @param $name
         */
        public function validateZipCode($name)
        {
            $field = $this->fields[$name];

            if (is_array($field->getOpts()))
            {
                $this->validateOptions($field);
            }

            if(!preg_match("/^[0-9]{4}$/", $field->getValue()))
            {
                $this->errors[$name] = 'Postnummer kan kun bestå av fire siffer.';
            }
        }

        /**
         * @param $name
         */
        public function validateTelephone($name)
        {
            $field = $this->fields[$name];

            if (is_array($field->getOpts()))
            {
                $this->validateOptions($field);
            }

            if(!preg_match("/^[0-9]{8}$/", $field->getValue()))
            {
                $this->errors[$name] = "Ugyldig telefonnummer. Må bestå av 8 siffer.";
            }
        }

        /**
         * @param $name
         */
        public function validateDate($name)
        {
            $field = $this->fields[$name];

            @list ($day, $month, $year) = explode('/', $field->getValue());

            if(!@checkdate((int)$month, (int)$day, (int)$year))
            {
                $this->errors[$name] = "Ugyldig dato". $field->getValue();
            }
        }

        public function validateTime($name)
        {
            $field = $this->fields[$name];

            if (!preg_match('#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#', $field->getValue()))
            {
                $this->errors[$name] = 'Ugyldig tid';
            }
        }

        /**
         * @param $name
         */
        public function validateRequired($name)
        {
            $field = $this->fields[$name];

            if (is_array($field->getOpts()))
            {
                $this->validateOptions($field);
            }

            if ($field->getValue() == '')
            {
                $this->errors[$name] = 'Feltet kan ikke være tomt';
            }
        }

        public function validateNumber($name)
        {
            $field = $this->fields[$name];

            if (is_array($field->getOpts()))
            {
                $this->validateOptions($field);
            }

            if(!is_numeric($field->getValue()))
            {
                $this->errors[$name] = 'Ugyldig tall';
            }
        }

        /**
         * @param $value
         * @param $length
         * @return bool
         */
        public function validateMinLength($value, $length)
        {
            return (strlen($value) >= $length) ? true : false;
        }

        /**
         * @param $value
         * @param $length
         * @return bool
         */
        public function validateMaxLength($value, $length)
        {
            return (strlen($value) <= $length) ? true : false;
        }

        /**
         * @param $value
         * @param $min
         * @param $max
         * @return bool
         */
        public function validateMinMaxLength($value, $min, $max)
        {
            $length = strlen($value);
            return ($length >= $min && $length <= $max) ? true : false;
        }

        public function validateMinNumber($value, $min)
        {
            return ($value >= $min) ? true : false;
        }

        public function validateMaxNumber($value, $max)
        {
            return ($value <= $max) ? true : false;
        }

        public function validateMinMaxNumber($value, $min, $max)
        {
            return ($value >= $min && $value <= $max) ? true : false;
        }

        /**
         * @param $value
         * @param array $array
         * @return bool
         */
        public function inArray($value, array $array = array())
        {
            return (in_array($value, $array));
        }

        public function assertEqual($val1, $val2)
        {
            return ($val1 == $val2) ? true : false;
        }

        public function hasKey($key, array $array = array())
        {
            return (array_key_exists($key, $array));
        }
    }
?>