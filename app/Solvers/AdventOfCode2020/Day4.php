<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Day4 extends AbstractSolver
{
    protected $fields = [
        'byr' => true,
        'iyr' => true,
        'eyr' => true,
        'hgt' => true,
        'hcl' => true,
        'ecl' => true,
        'pid' => true,
        'cid' => false,
    ];

    public function validatePassport(string $input, array $rules)
    {
        return Str::of($input)
            // Split into lines
            ->explode("\n\n")

            ->map(function (string $passport) {
                return Str::of($passport)
                    ->split('/\n|\s/')
                    ->mapWithKeys(function ($item) {
                        $parts = Str::of($item)->explode(':');
                        return [$parts->get(0) => $parts->get(1)];
                    });
            })

            ->filter(function (Collection $passport) use ($rules) {
                $validator = Validator::make($passport->toArray(), $rules);

                return $validator->passes();
            });
    }

    protected function partOne(string $input)
    {
        $rules = [
            'byr' => ['required'],
            'iyr' => ['required'],
            'eyr' => ['required'],
            'hgt' => ['required'],
            'hcl' => ['required'],
            'ecl' => ['required'],
            'pid' => ['required'],
            'cid' => [],
        ];

        return $this->validatePassport($input, $rules)
            ->count();
    }

    protected function partTwo(string $input)
    {
        $rules = [
            'byr' => ['required', 'integer', 'min:1920', 'max:2002'],
            'iyr' => ['required', 'integer', 'min:2010', 'max:2020'],
            'eyr' => ['required', 'integer', 'min:2020', 'max:2030'],
            'hgt' => ['required', function ($attribute, $value, $fail) {
                if (Str::contains($value, 'cm')) {
                    $number = (int)Str::replace('cm', '', $value);

                    if ($number < 150 || $number > 193) {
                        $fail('The '.$attribute.' is invalid.');
                    }
                    return;
                }

                if (Str::contains($value, 'in')) {
                    $number = (int)Str::replace('in', '', $value);

                    if ($number < 59 || $number > 76) {
                        $fail('The '.$attribute.' is invalid.');
                    }
                    return;
                }

                $fail('The '.$attribute.' is invalid.');
            }],
            'hcl' => ['required', 'regex:/^#[0-9a-f]{6}/'],
            'ecl' => ['required', Rule::in(['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'])],
            'pid' => ['required', 'numeric', 'digits:9'],
            'cid' => [],
        ];

        return $this->validatePassport($input, $rules)
            ->count();
    }
}
