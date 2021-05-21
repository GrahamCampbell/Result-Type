<?php

declare(strict_types=1);

/*
 * This file is part of Result Type.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\ResultType;

use PhpOption\None;
use PhpOption\Option;
use PhpOption\Some;

/**
 * @template-covariant T
 * @extends \GrahamCampbell\ResultType\Result<T,never>
 * @immutable
 */
final class Success extends Result
{
    /**
     * @var T
     */
    private $value;

    /**
     * Internal constructor for a success value.
     *
     * @param T $value
     *
     * @return void
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Create a new Success value.
     *
     * @template S
     *
     * @param S $value
     *
     * @return \GrahamCampbell\ResultType\Result<S,never>
     */
    public static function create($value)
    {
        return new self($value);
    }

    public function success(): Option
    {
        return Some::create($this->value);
    }

    public function map(callable $f): Result
    {
        return self::create($f($this->value));
    }

    public function flatMap(callable $f): Result
    {
        return $f($this->value);
    }

    public function error(): Option
    {
        return None::create();
    }

    public function mapError(callable $f): Result
    {
        return $this;
    }
}
