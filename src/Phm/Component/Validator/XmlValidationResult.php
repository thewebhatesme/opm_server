<?php
/**
 * Declares the ValidationResult class.
 *
 * @author     Mike Lohmann <mike.lohmann@phplabs.de>
 */

namespace Phm\Component\Validator;


class XmlValidationResult implements ValidationResultInterface
{
    /**
     * @var array
     */
    private $errors = array();

    /**
     * @param array $errors
     */
    public function __construct(array $errors = array())
    {
        $this->errors = $errors;
    }

    /**
     * {@inheritDoc}
     */
    public function hasErrors()
    {
        return count($this->errors) == 0;
    }

    /**
     * {@inheritDoc}
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * {@inheritDoc}
     */
    public function toString()
    {
        foreach($this->errors as $error) {
            printf("Error: %s \nfile: %s, line: %s, column: %s, level: %s, code: %s\n",
              $error->message,
              $error->file,
              $error->line,
              $error->column,
              $error->level,
              $error->code
            );
        }
    }
}