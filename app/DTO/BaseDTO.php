<?php


namespace App\DTO;


use App\Exceptions\DTOExceptions\InsufficientData;

abstract class BaseDTO
{
    protected const RULE_REQUIRED = 'required';
    protected const RULE_NULLABLE = 'nullable';
    protected array $fields = [];

    public function __construct(array $data)
    {
        $rules = $this->rules();
        foreach ($rules as $field => $rule) {
            throw_if(
                empty($data[$field]) && $rule === static::RULE_REQUIRED,
                new InsufficientData('Lost required data in your DTO object')
            );

            if (!empty ($data[$field])) {
                $this->$field = $data[$field];
                $this->fields[] = $field;
            }
        }
    }

    public function toArray(): array
    {
        $res = [];
        foreach ($this->fields as $field) {
            $res[$field] = $this->$field;
        }

        return $res;
    }

    abstract protected function rules(): array;
}
