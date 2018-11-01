<?php

namespace App\Navicu\Util;

/**
 * Validator para los parametros en la aplicacion
 *
 * Reglas disponibles:
 *
 * required             = Requerido
 * numeric              = Requiere un valor numerico
 * min:(param)          = Longitud minima de caracteres
 * max:(param)          = Longitud maxima de caracteres
 * min_value:(param)    = Valor numerico minimo
 * max_value:(param)    = Valor numerico maximo
 * in:(param,param)     = Permitir solo valores indicados
 * not_in:(param,param) = No permitir valores indicados
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class NavicuValidator
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Valida los parametros
     *
     * @param array $params
     * @param array $rules
     */
    public function validate($params, $rules) : void
    {
        $this->checkRequired($params, $rules);
        $this->checkNumeric($params, $rules);
        $this->checkMin($params, $rules);
        $this->checkMAx($params, $rules);
        $this->checkMinValue($params, $rules);
        $this->checkMaxValue($params, $rules);
        $this->checkIn($params, $rules);
        $this->checkNotIn($params, $rules);
    }

    /**
     * Indica si existen errores en los parametros
     *
     * @return bool
     */
    public function hasError() : bool
    {
        return count($this->errors) > 0;
    }

    /**
     * Obtiene todos los errores de validacion
     *
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * Agrega un error de validacion
     *
     * @param string $error
     */
    private function addError($error) : void
    {
        $this->errors[] = $error;
    }

    /**
     * Valida los parametros para la regla "required"
     *
     * @param array $params
     * @param array $rules
     */
    private function checkRequired(array $params, array $rules) : void
    {
        foreach ($rules as $ruleTarget => $rule) {

            $rulesArray = explode('|', $rule);

            if (in_array('required', $rulesArray) && ! isset($params[$ruleTarget])) {
                $this->addError($ruleTarget . ' is required');
            }
        }
    }

    /**
     * Valida los parametros para la regla "numeric"
     *
     * @param array $params
     * @param array $rules
     */
    private function checkNumeric($params, $rules) : void
    {
        foreach ($rules as $ruleTarget => $rule) {

            $rulesArray = explode('|', $rule);

            if (isset($params[$ruleTarget]) && in_array('numeric', $rulesArray) && ! is_numeric($params[$ruleTarget])) {
                $this->addError($ruleTarget . ' must be numeric');
            }
        }
    }

    /**
     * Valida los parametros para la regla "min"
     *
     * @param array $params
     * @param array $rules
     */
    private function checkMin($params, $rules) : void
    {
        foreach ($rules as $ruleTarget => $rule) {

            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {

                $ruleWithParam = explode(':', $r);

                if (count($ruleWithParam) > 1 && $ruleWithParam[0] === 'min') {

                    $min = intval($ruleWithParam[1]);

                    if (isset($params[$ruleTarget]) && strlen($params[$ruleTarget]) < $min) {
                        $this->addError("{$ruleTarget} must contain minimum {$min} characters");
                    }
                }
            }
        }
    }

    /**
     * Valida los parametros para la regla "max"
     *
     * @param array $params
     * @param array $rules
     */
    private function checkMax($params, $rules) : void
    {
        foreach ($rules as $ruleTarget => $rule) {

            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {

                $ruleWithParam = explode(':', $r);

                if (count($ruleWithParam) > 1 && $ruleWithParam[0] === 'max') {

                    $max = intval($ruleWithParam[1]);

                    if (isset($params[$ruleTarget]) && strlen($params[$ruleTarget]) > $max) {
                        $this->addError("{$ruleTarget} must contain maximum {$max} characters");
                    }
                }
            }
        }
    }

    /**
     * Valida los parametros para la regla "min_value"
     *
     * @param array $params
     * @param array $rules
     */
    private function checkMinValue($params, $rules) : void
    {
        foreach ($rules as $ruleTarget => $rule) {

            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {

                $ruleWithParam = explode(':', $r);

                if (count($ruleWithParam) > 1 && $ruleWithParam[0] === 'min_value') {

                    $minValue = intval($ruleWithParam[1]);

                    if (isset($params[$ruleTarget]) && intval($params[$ruleTarget]) < $minValue) {
                        $this->addError("{$ruleTarget} must be min value {$minValue}");
                    }
                }
            }
        }
    }

    /**
     * Valida los parametros para la regla "max_value"
     *
     * @param array $params
     * @param array $rules
     */
    private function checkMaxValue($params, $rules) : void
    {
        foreach ($rules as $ruleTarget => $rule) {

            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {

                $ruleWithParam = explode(':', $r);

                if (count($ruleWithParam) > 1 && $ruleWithParam[0] === 'max_value') {

                    $maxValue = intval($ruleWithParam[1]);

                    if (isset($params[$ruleTarget]) && intval($params[$ruleTarget]) > $maxValue) {
                        $this->addError("{$ruleTarget} must be max value {$maxValue}");
                    }
                }
            }
        }
    }

    /**
     * Valida los parametros para la regla "in"
     *
     * @param array $params
     * @param array $rules
     */
    private function checkIn($params, $rules) : void
    {
        foreach ($rules as $ruleTarget => $rule) {

            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {

                $ruleWithParam = explode(':', $r);

                if (count($ruleWithParam) > 1 && $ruleWithParam[0] === 'in') {

                    $inValues = explode(',', $ruleWithParam[1]);

                    if (isset($params[$ruleTarget]) && ! in_array($params[$ruleTarget], $inValues)) {
                        $this->addError("{$ruleTarget} only accept ({$ruleWithParam[1]})");
                    }
                }
            }
        }
    }

    /**
     * Valida los parametros para la regla "not_in"
     *
     * @param array $params
     * @param array $rules
     */
    private function checkNotIn($params, $rules) : void
    {
        foreach ($rules as $ruleTarget => $rule) {

            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $r) {

                $ruleWithParam = explode(':', $r);

                if (count($ruleWithParam) > 1 && $ruleWithParam[0] === 'not_in') {

                    $notInValues = explode(',', $ruleWithParam[1]);

                    if (isset($params[$ruleTarget]) && in_array($params[$ruleTarget], $notInValues)) {
                        $this->addError("{$ruleTarget} not accept ({$ruleWithParam[1]})");
                    }
                }
            }
        }
    }
}