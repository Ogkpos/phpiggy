<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class DateFormatRule implements RuleInterface
{
  public function validate(array $data, string $field, array $params): bool
  {
    $parseDate = date_parse_from_format($params[0], $data[$field]);
    //error count and warning count are associated with the date_parse_from_format method 
    //if the val > 0, then there's an error
    return $parseDate['error_count'] === 0 && $parseDate['warning_count'] === 0;
  }

  public function getMessage(array $data, string $field, array $params): string
  {
    return "Invalid date";
  }
}
