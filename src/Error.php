<?php

declare(strict_types=1);

/*
 * This file is part of Result Type.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\ResultType;

use PhpOption\None;
use PhpOption\Option;
use PhpOption\Some;

/**
 * @template-covariant E
 * @extends \GrahamCampbell\ResultType\Result<never,E>
 * @immutable
 */
final class Error extends Result
{
    /**
     * @var E
     */
    private $value;

    /**
     * Internal constructor for an error value.
     *
     * @param E $value
     *
     * @return void
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Create a new error value.
     *
     * @template F
     *
     * @param F $value
     *
     * @return \GrahamCampbell\ResultType\Result<never,F>
     */
    public static function create($value): Result
    {
        return new self($value);
    }

    public function success(): Option
    {
        return None::create();
    }

    public function map(callable $f): Result
    {
        return $this;
    }

    public function flatMap(callable $f): Result
    {
        return self::create($this->value);
    }

    public function error(): Option
    {
        return Some::create($this->value);
    }

    public function mapError(callable $f): Result
    {
        return self::create($f($this->value));
    }
}
