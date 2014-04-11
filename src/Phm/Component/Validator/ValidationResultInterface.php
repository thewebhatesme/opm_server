<?php
/**
 * Declares the ValidationResultInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phplabs.de>
 */

namespace Phm\Component\Validator;

interface ValidationResultInterface
{
    /**
     * @return boolean
     */
    public function hasErrors();

    /**
     * @return string
     */
    public function toString();

    /**
     * @param array $errors
     *
     * @return void
     */
    public function setErrors(array $errors);
}